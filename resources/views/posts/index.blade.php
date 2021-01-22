@extends('auth.layout')
@section('content')
<div class="container">
    <div class="card my-4">
        <div class="card-header">
            <a href="/post/create" class="btn btn-primary float-right">Create</a>
            <h5 class="card-title">Post</h5>
        </div>
    </div>
</div>
<div class="container">
    <div class="row" id="post-container">

    </div>
</div>

@endsection
@section('scripts')
    <script>
        $(function(){
            var authUserId = localStorage.getItem('user_id');
            $.ajax({
                url: 'api/posts',
                type: 'GET',
                headers: {"Authorization": 'Bearer '+ localStorage.getItem('api_token')},
                success:function(result){
                    var postContainer = $('#post-container');
                    if (result.posts.length > 0) {

                        $.each(result.posts, function(key, val){
                            if(val.image == null){
                                var img = '/img/BADMINTON.jpg'
                            }else{
                                var img = '/storage/' + val.image
                            }
                            var template = `<div class="col-md-4">
                                                <div class="card mb-3" >
                                                    <a href="/post/show/${val.id}">
                                                    <img class="card-img-top" src="${img }" alt="Card image cap" style="height: 200px;">
                                                    <div class="card-body">
                                                    <h5 class="card-title">${val.title}</h5>
                                                    </a>
                                                    <p class="card-text">${val.body}</p>
                                                    ${val.created_by == authUserId ? `<a href="/post/edit/${val.id}" class="btn btn-primary float-right">Edit</a>` :`&nbsp;`}

                                                    </div>
                                                    <div class="card-footer">
                                                        <span> ${val.category.name}</span>
                                                        <span class="float-right"> ${ new Date(val.created_at).toDateString() }</span>
                                                    </div>
                                                </div>
                                            </div>`
                            postContainer.append(template);
                        })
                    }else{
                        postContainer.html('<h4>Post not found</h4>')
                    }
                },
                error: function(err){
                    console.log(err.responseJSON.message);
                    if (err.responseJSON.message = 'Unauthenticated') {
                           window.location.href = '/login'
                    }
                }
            })
        });
    </script>
@endsection
