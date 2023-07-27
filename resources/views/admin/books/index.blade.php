@extends('theme.default')

@section('head')
<link href="{{asset('theme/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">

@endsection
@section('heading')
عرض الكتب
@endsection

@section('content')
<a href="{{route('books.create')}}" class="btn btn-primary">
اضف كتابا جديدا
 <i class="fas fa-plus"></i>

</a>
<hr>
<div class="row">
    <div class="col-md-12">
        <table class="table table-striped table-bordered text-right " cellspacing="0" width="100%" id="books-table">
            <thead>
                <tr>
                    <th>العنوان</th>
                    <th>الرقم التسلسلي</th>
                    <th>التصنيف</th>
                    <th>المؤلفون</th>
                    <th>الناشر</th>
                    <th>السعر</th>
                    <th>خيارات</th>

                </tr>

                <tbody>
                    @foreach ($books as $book)
                        <tr>
                            <td><a href="{{route('admin.books.show', $book)}}">{{ $book->title }}</a></td>
                            <td>{{ $book->isbn }}</td>
                            <td>{{ $book->category ? $book->category->name : '' }}</td>
                            <td>
                                @if($book->authors()->count() > 0)
                                    @foreach ($book->authors as $author)
                                        {{$loop->first ? '':' و '}}
                                        {{ $author->name }}
                                    @endforeach

                                @endif
                            </td>
                            <td>{{ $book->publisher ? $book->publisher->name : '' }}</td>
                            <td>{{ $book->price }}</td>
                            <td>
                                <a class="btn btn-info btn-sm" href="{{route('books.edit' , $book)}}" ><i class="fa fa-edit"></i> تعديل</a>
                                <form action="{{route('books.destroy' , $book)}}" method="post" class="d-inline-block">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل انت متأكد ؟')"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>


                        </tr>
                    @endforeach
                </tbody>
            </thead>
        </table>
    </div>
</div>
@endsection


@section('script')
<script src="{{asset('theme/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('theme/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

<script>
    $('#books-table').DataTable({
        "language":{
            "url": "//cdn.datatables.net/plug-ins/1.13.5/i18n/ar.json"
        }
    });
</script>
@endsection
