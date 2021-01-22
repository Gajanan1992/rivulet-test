<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{

    public function index()
    {
        return view('posts.index');
    }


    public function getAllPosts()
    {
        $posts = Post::with(['category'])->get();

        return response()->json(['posts'=> $posts]);
    }
    public function getPostComments($id)
    {
        $comments = Comment::with(['owner'])->where('post_id',$id)->get();

        return response()->json(['comments'=> $comments]);
    }

    public function create()
    {
        $categories = Category::all();
        // dd($categories);
        return view('posts.create', compact('categories'));
    }


    public function storePost(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'category' => 'required',
            'image' => 'nullable|image',
            'body' => 'nullable',
        ]);
        $user = Auth::user();
        if ($validator->passes()) {

            $post = new Post();

            $post->title = $request->title;
            $post->category_id = $request->category;
            $post->body = $request->body;
            $post->created_by = $user->id;
            $imageUrl = null;

            if ($request->hasFile('image')) {
                $img = $request->image;
                $filename = $img->getClientOriginalName();
                $imageUrl = Storage::putFileAs('/images', $request->file('image'), $filename);
            }
            $post->image = $imageUrl;
            $post->save();
            return response(['result' => 'success','message'=>'Post created successfully.'], 200);
        } else {
            return response()->json($validator->errors(),400);
        }
    }
    public function updatePost(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'category' => 'required',
            'image' => 'nullable|image',
            'body' => 'nullable',
        ]);

        if ($validator->passes()) {

            $post = Post::find($id);

            $post->title = $request->title;
            $post->category_id = $request->category;
            $post->body = $request->body;

            $imageUrl = null;

            if ($request->hasFile('image')) {
                $img = $request->image;
                $filename = $img->getClientOriginalName();
                $imageUrl = Storage::putFileAs('/images', $request->file('image'), $filename);
            }
            $post->image = $imageUrl;
            $post->save();
            return response(['result' => 'success','message'=>'Post updated successfully.'], 200);
        } else {
            return response()->json($validator->errors(),400);
        }
    }

    public function storeComment(Request $request)
    {
       // return $request->all();
        $validator = Validator::make($request->all(), [
            'comment' => 'required',
        ]);
        $user = Auth::user();
        if ($validator->passes()) {

            $comment = new Comment();

            $comment->comment = $request->comment;
            $comment->post_id = $request->postId;
            $comment->created_by = $user->id;
            $comment->save();

            $comment = Comment::with('owner')->where('id',$comment->id)->firstOrFail();
            return response(['result' => 'success','message'=>'Comment created successfully.','comment' => $comment], 200);
        } else {
            return response()->json($validator->errors(),400);
        }

    }


    public function show($id)
    {
        $post = Post::with(['comments.owner'])->where('id',$id)->firstOrFail();
        return view('posts.show', compact('post'));
    }
    public function getPost($id)
    {
        $post = Post::with(['category'])->where('id',$id)->firstOrFail();
        return response()->json(['post'=>$post]);
    }

    public function edit($id)
    {
        $categories = Category::all();
        return view('posts.edit', compact('categories'));
    }


    public function destroy(Post $post)
    {
        //
    }
}
