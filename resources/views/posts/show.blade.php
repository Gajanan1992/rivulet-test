@extends('auth.layout')
@section('content')
{{-- <div class="container">
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title">Post</h5>
            <a href="/post/create" class="btn btn-primary float-right">Create</a>
        </div>
    </div>
</div> --}}
<div class="container">
        <div class="card mt-5" >
            <div class="card-header" style="background-image: url({{ isset($post->image) ? Storage::url( $post->image) : '/img/BADMINTON.jpg' }});  height: 100px; background-size: cover;">
            </div>
            <div class="card-body">
                <h6 class="float-right">{{ $post->created_at->format('d-M-y h:i a') }}</h6>
                <h4>{{ $post->title }}</h4>
                <p class="card-text">{{ $post->body }}</p>
            </div>
          </div>
          <div class="card mt-3">
              <div class="card-header">
                  Comments : <span id="total-comments"></span>
                  <input type="hidden" id="commentCount" name="" value="">
              </div>
              <div class="card-body">
                <div class="be-comment-block" id="comment-container">

                </div>
                  <div class="row" >
                      <div class="col-md-12">
                        <hr>
                          <form action="" method="POST" id="comment-form">
                            @csrf
                              <div class="form-group">
                                  <label for="comment">Post Comment</label>
                                  <textarea id="comment" autocomplete="false" class="form-control"  name="comment" rows="3"></textarea>
                                  <small id="comment-err" class="form-text text-danger"></small>
                              </div>
                              <input type="hidden" id="post-id" name="postId" value="{{ $post->id }}">
                              <button class="btn btn-primary float-right">
                                  Post Comment
                              </button>
                          </form>
                      </div>
                  </div>
              </div>

          </div>
</div>

@endsection
@section('scripts')
    <script>
        $(function(){
            //get comments
            var postId = $('#post-id').val();
            $.ajax({
                type:"get",
                url: '/api/comments/' + postId,
                headers:{
                    "Authorization": 'Bearer '+ localStorage.getItem('api_token')
                },
                success:function(result){
                    // console.log(result);
                    var comments = $('#comment-container');
                    var commetnsCount = result.comments.length;
                    $('#total-comments').text(commetnsCount)
                    $('#commentCount').val(commetnsCount)
                    if (result.comments.length) {
                        $.each(result.comments, function(key, val){
                        comments.append(`<div class="be-comment">
                                <div class="be-img-comment">
                                    <a href="blog-detail-2.html">
                                        <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="" class="be-ava-comment">
                                    </a>
                                </div>
                                <div class="be-comment-content">

                                        <span class="be-comment-name">
                                            ${val.owner.name}
                                            </span>
                                        <span class="be-comment-time">
                                            <i class="fa fa-clock-o"></i>
                                            ${ new Date(val.created_at).toLocaleString() }
                                        </span>

                                    <p class="be-comment-text">
                                        ${val.comment }
                                    </p>
                                </div>
                            </div>`);
                            $('#comment').val('');
                    })
                    }

                },
                error:function(){

                }
            });
            //post comment
            $('#comment-form').on('submit', function (event) {
                event.preventDefault();
                var data = new FormData(this);
                 var token = $('input[name="_token"]').attr('value');
                $.ajax({
                    headers: {
                        'X-CSRF-Token': token,
                        "Authorization": 'Bearer '+ localStorage.getItem('api_token')
                    },
                    type: "POST",
                    url: "/api/posts/comment",
                    data: data,
                   processData: false,
                    contentType: false,
                    cache: false,
                   timeout: 800000,
                    success: function (data) {
                        console.log('success', data);
                        var comments = $('#comment-container');
                        comments.append(`<div class="be-comment">
                                <div class="be-img-comment">
                                    <a href="blog-detail-2.html">
                                        <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="" class="be-ava-comment">
                                    </a>
                                </div>
                                <div class="be-comment-content">

                                        <span class="be-comment-name">
                                            ${data.comment.owner.name}
                                            </span>
                                        <span class="be-comment-time">
                                            <i class="fa fa-clock-o"></i>
                                            ${ new Date(data.comment.created_at).toLocaleString() }
                                        </span>

                                    <p class="be-comment-text">
                                        ${data.comment.comment }
                                    </p>
                                </div>
                            </div>`);
                            $('#comment').val('');
                            $('#total-comments').text(parseInt($('#commentCount').val()) + 1);
                            $('#commentCount').val(parseInt($('#commentCount').val()) + 1)
                    },
                    error: function (e) {
                        console.log(e);
                        var errors = e.responseJSON;
                        if (errors.comment) {
                            $('#comment-err').html(errors.comment[0]);
                        } else {
                            $('#comment-err').html('');
                        }


                    }
                });
            });
        });
    </script>
@endsection
