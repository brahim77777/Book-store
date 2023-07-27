@extends('theme.default')

@section('head')
    <link href="{{asset('theme/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">

@endsection
@section('heading')
     الناشرون
@endsection

@section('content')
    <a href="{{route('publishers.create')}}" class="btn btn-primary">
        اضف ناشرا جديدا
        <i class="fas fa-plus"></i>

    </a>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-bordered text-right " cellspacing="0" width="100%" id="publishers-table">
                <thead>
                <tr>
                    <th>الاسم</th>
                    <th>العنوان</th>
                    <th>خيارات</th>
                </tr>

                <tbody>
                    @foreach ($publishers as $publisher)
                        <tr>
                            <td>{{ $publisher->name }}</td>
                            <td>{{ $publisher->address }}</td>
                            <td>
                                <a class="btn btn-info btn-sm" href="{{route('publishers.edit' , $publisher)}}" ><i class="fa fa-edit"></i> تعديل</a>
                                <form action="{{route('publishers.destroy' , $publisher)}}" method="post" class="d-inline-block">
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
        $('#publishers-table').DataTable({
            "language":{
                "url": "//cdn.datatables.net/plug-ins/1.13.5/i18n/ar.json"
            }
        });
    </script>
@endsection

