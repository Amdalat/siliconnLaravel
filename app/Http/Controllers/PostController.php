<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
// use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(){
        // $posts = Post::all();
        // $posts = Post::inRandomOrder()->get();
        // $posts = Post::orderBy('created_at', 'asc')->get();
        // $posts = Post::orderBy('created_at', 'asc')->limit(2)->get();
        $posts = Post::orderBy('created_at', 'desc')->paginate(2);
        $posts = Post::with('user')->orderBy('created_at', 'desc')->paginate(3);
        // dd($posts);
        return view('home', [
            'posts'=> $posts
        ]);
    }

    public function createPost(){
        return view('create-post');
    }

    public function processPost(Request $request){
        // dd($request->all());
        // dd($request->title);
        $validator = Validator::make($request->all(), [
            // 'title' => 'required|min:3',
            'title' => 'required',
            'body' => 'required',
            'category' => 'required',
            'image' => 'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        // $createdPost = Post::create([
        //     'title'=> $request->title,
        //     'body'=> $request->body,
        //     'category'=> $request->category,
        //     // 'user_id' => Auth::id(),
        //     'user_id' => auth()->id(),
        // ]);

        $formFields = [
            'title'=> $request->title,
            'body'=> $request->body,
            'category'=> $request->category,
            // 'user_id' => Auth::id(),
            'user_id' => auth()->id(),
        ];

        $image = uniqid().'-'.'post-image'.'.'.$request->image->extension();
        // eg: dhbdhsbdbvjfnf-post-image.jpg
        $request->image->move(public_path('posts'), $image);

        $formFields['image'] = $image;
        $createdPost = Post::create($formFields);

        if ($createdPost) {
            return redirect()->back()->with('success', 'Post uploaded successfully');
        }else {
            return redirect()->back()->with('error', 'Post not uploaded');
        }
    }

    public function singlePost($id){
        $singlePost = Post::find($id);
        // $comments = Comment::with('user')->get();
        $comments = Comment::all();
        // dd($singlePost);
        // dd($comments);
        return view('single-post', [
            'post'=> $singlePost,
            'comments' => $comments,
        ]);
    }

    public function editPost($id){
        $singlePost = Post::find($id);
        return view('edit-post', [
            'post'=> $singlePost
        ]);
    }

    public function updatePost(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'body' => 'required',
            'category' => 'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        $post = [
            'title'=> $request->title,
            'body'=> $request->body,
            'category'=> $request->category,
        ];

        $updatePost = Post::where('id', $id)->update($post);

        if ($updatePost) {
            return redirect('/');
        }else {
            return redirect()->back();
        }
    }

    public function deletePost($id){
        $post = Post::where('id', $id)->delete();

        if ($post) {
            return redirect('/');
        }else {
            return redirect()->back();
        }
    }

    public function comment(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'comment' => 'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        if(!auth()->check()){
            return redirect()->back()->with('error', 'You need to login');
        }

        $formFields = [
            'comment'=> $request->comment,
            'post_id' => $id,
            'user_id' => auth()->id(),
        ];

        $comment = Comment::create($formFields);

        if ($comment) {
            return redirect()->back()->with('success', 'Comment uploaded successfully');
        }else {
            return redirect()->back()->with('error', 'Comment not uploaded');
        }
    }


}
