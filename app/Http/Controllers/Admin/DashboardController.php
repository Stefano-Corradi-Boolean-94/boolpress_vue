<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        $n_posts = Post::where('user_id', Auth::id())->count();

        $last_post = Post::where('user_id', Auth::id())
                           ->orderBy('id', 'desc')->first();
        return view('admin.home', compact('n_posts', 'last_post'));
    }
}
