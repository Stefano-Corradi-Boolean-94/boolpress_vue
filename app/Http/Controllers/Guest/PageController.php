<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PageController extends Controller
{
    public function index(){
        $posts = Post::orderBy('id','desc')->limit(10)->get();
        return view('guest.home', compact('posts'));
    }

    public function posts(){
        return view('guest.posts');
    }

    public function contacts(){
        return view('guest.contacts');
    }

    public function post_detail($slug){

        $post = Post::where('slug', $slug)->first();
        return view('guest.post-detail',compact('post'));
    }


}
