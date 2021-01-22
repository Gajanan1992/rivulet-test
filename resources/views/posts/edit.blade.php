@extends('auth.layout')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Post</h5>
        </div>

    </div>
</div>
<div class="container">
    <div class="card">
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
            //fetch post
            var url = window.location.pathname;
            var postId = url.substring(url.lastIndexOf('/') + 1);
            $.ajax({
                type:'get',
                url:'/api/post/'+postId,
                headers: {
                "Authorization": 'Bearer '+ localStorage.getItem('api_token')
                },
                success:function(result){
                    console.log(result);
                    $('#title').val(result.post.title);
                    $('#body').val(result.post.body);
                    $('#category').val(result.post.category.id);
                },
                error:function(err){
                    console.log(err);
                }
            });

        $('#post-form').on('submit', function (event) {
        event.preventDefault();
        var data = new FormData(this);
        var token = $('input[name="_token"]').attr('value');
        console.log(token);
        $.ajax({
            headers: {
                'X-CSRF-Token': token,
                "Authorization": 'Bearer '+ localStorage.getItem('api_token')
            },
            type: "POST",
            url: "/api/posts/update/"+ postId,
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
