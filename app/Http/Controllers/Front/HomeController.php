<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Auth;

class HomeController extends Controller
{
    public function index(Request $request) {
        $posts = Post::orderBy('updated_at', 'desc');

        if(!Auth::check()) {
            $posts = $posts->where('status', 1);
        }

        $posts = $posts->get()->take(10);

        return view('front.index', compact('posts'));
    }

    public function linktree() {
        $links = [
            array(
                'title' => 'Instagram',
                'link' => 'https://instagram.com/emmards'
            ),
            array(
                'title' => 'Instagram',
                'link' => 'https://instagram.com/emmards.me'
            ),
            array(
                'title' => 'Youtube',
                'link' => 'https://www.youtube.com/c/EmmanuelPetit00'
            ),
        ];

        return view('front.linktree', compact('links'));
    }
}
