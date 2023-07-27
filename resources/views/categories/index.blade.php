@extends('layouts.main')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">تصنيفات الكتب</div>

                <div class="card-body">
                    <div class="row justify-content-center" >
                        <form action="{{route('gallery.category.search')}}" method="get">
                            <div class="row d-flex justify-content-center form-group ">
                                <input type="text" class="col-6 ml-2 " name="term" placeholder="البحث">
                                <button type="submit" class="col-4  btn btn-info ">ابحث</button>
                            </div>
                        </form>
                    </div>
                    <hr>
                    <br>

                    <h3 class="mb-4">{{$title}}</h3>
                    @if($categories->count())
                        @foreach($categories as $category)
                            <a style='color:grey' href="{{route('gallery.category.show' , $category)}}">
                                <li class="list-group-item">
                                    {{$category->name}}
                                </li>
                            </a>
                        @endforeach
                    @else
                        <div class="col-12 alert alert-info mt-4 mx-auto text-center">
                            لا نتائج
                        </div>
                    @endif



                </div>
            </div>
        </div>
    </div>
</div>
@endsection