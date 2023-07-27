@extends('layouts.main')

@section('head')
<style>
    .long-title{
        height: 40px;
        overflow: hidden;
    }
</style>
@endsection


@section('content')
    <div class="container">
        <div class="row">
            <div>
                <form action="{{route('search')}}" method="get">
                    <div class="row d-flex justify-content-center">
                        <input type="text" class="col-3 mx-sm-3 mb-2" name="term" placeholder="البحث">
                        <button type="submit" class="col-1 btn btn-info mb-2">ابحث</button>
                    </div>
                </form>
                <hr>
            </div>
            <h3 class="my-3">{{$title}}</div>

            <div class="  mt-50 mb-50">
                <div class="row">
                    @if($books->count() > 0)
                        @foreach($books as $book)
                            @if($book->number_of_copies > 0)
                            <div class="col-lg-3 col-md-4 col-sm-6 mt-2 ">
                                    <div class="card mb-3">
                                        <div class="">
                                            <div class="card-img-actions">
                                                <a href="{{route('book.details' , $book)}}">
                                                    <img src="{{asset('storage/'.$book->cover_image)}}" class="card-img img-fluid" width="96" height="350" alt="">
                                                </a>

                                            </div>
                                        </div>

                                        <div class="card-body bg-light text-center">
                                            <div class="mb-2">
                                                <h6 class="font-weight-semibold mb-2 long-title">
                                                    <a href="{{route('book.details' , $book)}}" class="text-default mb-2" data-abc="true">{{$book->title}}</a>
                                                </h6>
                                                @if($book->category != null)
                                                <a href="{{route('gallery.category.show' , $book->category)}}" class="text-muted " data-abc="true">{{$book->category->name}}</a>
                                                @endif
                                            </div>

                                            <h3 class="mb-0 font-weight-semibold">${{$book->price}}</h3>

                                            <div>
                                                <span class="score ">
                                                    <div class="score-wrap">
                                                        <span class="stars-active" style="width: {{$book->rate()*20}}%">
                                                            <i class="fa fa-star star" aria-hidden="true"></i>
                                                            <i class="fa fa-star star" aria-hidden="true"></i>
                                                            <i class="fa fa-star star" aria-hidden="true"></i>
                                                            <i class="fa fa-star star" aria-hidden="true"></i>
                                                            <i class="fa fa-star star" aria-hidden="true"></i>
                                                        </span>
                                                        <span class="stars-inactive">
                                                            <i class="fa fa-star star" aria-hidden="true"></i>
                                                            <i class="fa fa-star star" aria-hidden="true"></i>
                                                            <i class="fa fa-star star" aria-hidden="true"></i>
                                                            <i class="fa fa-star star" aria-hidden="true"></i>
                                                            <i class="fa fa-star star" aria-hidden="true"></i>
                                                        </span>

                                                    </div>
                                                </span>
                                            </div>

                                            <div class="text-muted mb-3">34 reviews</div>
                                        </div>
                                    </div>




                            </div>
                            @endif


                        @endforeach
                    @else
                     <div class="alert alert-info" role="alert">
                        لا نتائج
                     </div>
                     @endif
                </div>
            </div>
        </div>
    </div>
@endsection
