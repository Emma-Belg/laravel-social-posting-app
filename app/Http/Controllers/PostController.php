<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        //using eager loading to stop double up queries
        $posts = Post::latest()->with(['user', 'likes'])->paginate(20);

        return view('posts.index', [
            'posts' => $posts
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'body' => 'required'
        ]);

        //auth()->user()->posts()->create();
        $request->user()->posts()->create($request->only('body'));
        return back();
    }

    public function destroy(Post $post)
    {
        if ($post->ownedBy(auth()->user())) {

        }
        $post->delete();
        return back();
    }
}
