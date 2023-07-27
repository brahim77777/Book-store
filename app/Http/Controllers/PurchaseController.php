<?php

namespace App\Http\Controllers;

use App\Mail\OrderMail;
use App\Models\Book;
use App\Models\Shopping;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Carbon;

class PurchaseController extends Controller
{
    //
    private $provider ;
    public function __construct()
    {
        $this->provider = new PayPalClient;
        $this->provider->setApiCredentials(config('paypal'));
        $token = $this->provider->getAccessToken();
        $this->provider->setAccessToken($token);
    }

    public function createPayment(Request $request){
        $data = json_decode($request->getContent() , true);
        $books = User::find($data['userId'])->booksInCart;
        $total = $this->getTotalPrice($books);

        $data = [
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "amount" => [
                            "currency_code" => "USD",
                            "value" => $total
                    ]
                ]
            ]
        ];


        $order = $this->provider->createOrder($data);

        return response()->json($order);

    }

    /**
     * @throws \Throwable
     */
    public function executePayment(Request $request){
        $data = json_decode($request->getContent() , true);
        $result = $this->provider->capturePaymentOrder($data['orderId']);
        if($result['status'] === 'COMPLETED') {
            $user = User::find($data['userId']);
            $this->updateCartAfterPurchase($user);
            $this->sendOrderConfirmationEmail($user->booksInCart , $user );
        }

        return response()->json($result);
    }

    public function creditCheckout(Request $request){
        // create intent
        $intent = auth()->user()->createSetupIntent();

        //get the user Total Price
        $books = User::find(auth()->user()->id)->booksInCart;
        $total = $this->getTotalPrice($books);

        //send total and Intent to the credit/checkout.blade.php
        return view('credit.checkout' , compact('total' , 'intent'));

    }
    public function purchase(Request $request){
        // getting the User and Payment method.
        $user = $request->user();
        $payment_method = $request->input('payment_method');

        // calculating the total price

        $books = User::find(auth()->user()->id)->booksInCart;
        $total = $this->getTotalPrice($books);

        // Important !! payment stuff
        try {
            $user->createOrGetStripeCustomer();
            $user->updateDefaultPaymentMethod($payment_method);
            $user->charge($total * 100 , $payment_method );
        }catch (\Exception $exception){
            return back()->with('حصل خطأ اثناء عملية الشراء, الرجاء التأكد من معلومات البطاقة' , $exception->getMessage());

        }
        $this->updateCartAfterPurchase(auth()->user());
        $this->sendOrderConfirmationEmail(auth()->user()->booksInCart , auth()->user());
        return redirect('/cart')->with('message',' تم شراء المنتج ينجاح');
    }

    public function sendOrderConfirmationEmail($order , $user){
        Mail::to($user->email)->send(new OrderMail($order , $user));

    }

    public function getTotalPrice($books){
        $total = 0;
        foreach ($books as $book) $total+= $book->price * $book->pivot->number_of_copies;
        return $total;
    }

    public function updateCartAfterPurchase($user) {

        $books = $user->booksInCart ;
        foreach ($books as $book) {

            $bookPrice = $book->price;
            $user->booksInCart()->updateExistingPivot( $book->id , ['bought' => 1 , 'price'=> $bookPrice, 'created_at'=>Carbon::now()]);
            $book->save();
        }
    }

    public function myProduct(){
        $user = User::find(auth()->user()->id);
        $myBooks =$user->purchasedProduct;
        return view('books.myProduct' , compact('myBooks'));
    }

    public function allProduct(){
        $allBooks =Shopping::where('bought' , true)->get();
        return view('admin.books.allProduct' , compact('allBooks'));
    }

}
