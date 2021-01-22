@extends('auth.layout')
@section('content')

<div class="container">
    <div class="card mt-5">
        <div class="card-header">
            Create Post
        </div>
        <div class="card-body">
            <form action="" id="post-form" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="title">Title</label>
                    <input id="title" class="form-control" type="text" name="title">
                    <small class="form-text text-danger" id="title-err"></small>
                </div>
                <div class="form-group">
                    <label for="category">Category</label>
                    <select id="category" class="form-control" name="category">
                        @foreach ($categories as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>

                        @endforeach
                    </select>
                    <small class="form-text text-danger" id="category-err"></small>

                </div>
                <div class="form-group">
                    <label for="image">Image</label>
                    <input id="image" class="form-control" type="file" name="image">
                    <small class="form-text text-danger" id="image-err"></small>
                </div>
                <div class="form-group">
                    <label for="body">Body</label>
                    <textarea name="body" id="body" cols="3" class="form-control" rows="4"></textarea>
                </div>
                <button class="btn btn-primary mb-5 float-right" id="submit">Submit</button>
            </form>
        </div>
    </div>
</div>

@endsection
@section('scripts')
    <script>
        $(function(){
        $('#post-form').on('submit', function (event) {
        event.preventDefault();
        var data = new FormData(this);
        var token = $('input[name="_token"]').attr('value');
        $.ajax({
            headers: {
                'X-CSRF-Token': token,
                "Authorization": 'Bearer '+ localStorage.getItem('api_token')
            },

            type: "POST",
            url: "/api/posts/store",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 800000,
            success: function (data) {
                console.log('success', data);
                window.location.href = '/posts';
            },
            error: function (e) {
                console.log(e);
                var errors = e.responseJSON;
                if (errors.title) {
                    $('#title-err').html(errors.title[0]);
                } else {
                    $('#title-err').html('');
                }
                if (errors.category) {
                    $('#category-err').html(errors.category[0]);
                } else {
                    $('#category-err').html('');
                }
                if (errors.image) {
                    $('#image-err').html(errors.image[0]);
                } else {
                    $('#image-err').html('');
                }

            }
        });
    });
        })
    </script>
@endsection
