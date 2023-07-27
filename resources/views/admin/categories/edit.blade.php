@extends('theme.default')

@section('heading')
    تعديل التصنيف : {{$category->name}}
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="card mb-4 col-md-8">
            <div class="card-header text-">
                تعديل معلومات التصنيف            </div>
            <div class="card-body">
                <form action="{{ route('categories.update' , $category) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">اسم التصنيف</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $category->name }}" autocomplete="name">

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="description" class="col-md-4 col-form-label text-md-right">الوصف</label>

                        <div class="col-md-6">
                            <textarea id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" autocomplete="description">{{ $category->description }}</textarea>

                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>



                    <div class="form-group row mb-0">
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-primary">عدل</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function readCoverImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#cover-image-thumb')
                        .attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
