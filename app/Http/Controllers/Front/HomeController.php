<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;

class HomeController extends Controller
{
    public function index(Request $request) {
        $posts = Post::orderBy('created_at', 'desc')->where('status', 1)->get()->take(10);

        return view('front.index', compact('posts'));
    }
}
