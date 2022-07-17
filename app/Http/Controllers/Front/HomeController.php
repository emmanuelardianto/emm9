<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Carbon\Carbon;
use Auth;

class HomeController extends Controller
{
    public function index(Request $request) {
        $posts = Post::orderBy('updated_at', 'desc');

        if(!Auth::check()) {
            $posts = $posts->where('status', 1);
        }

        $posts = $posts->get()->take(10);

        $data = collect(\Flickr::request('flickr.photos.search', ['user_id' => env('FLICKR_USERID'), 'per_page' => 48]))->first();
        $recents = collect();
        if(isset($data['photos'])){
            $recents =  collect($data['photos']['photo'])->map(function($obj) {
                return array(
                    'id' => $obj['id'],
                    'src' => 'https://live.staticflickr.com/'.$obj['server'].'/'.$obj['id'].'_'.$obj['secret'].'_q.jpg'
                );
            });
        }

        return view('front.index', compact('posts', 'recents'));
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

    public function showImageDetail($flickr) {
        if(!$flickr)
            return abort('404');
        
        $data = collect(\Flickr::request('flickr.photos.getSizes', ['user_id' => env('FLICKR_USERID'), 'photo_id' => $flickr]))->first();
        if(!isset($data['sizes'])) {
            return abort('404');
        }

        $search = collect(\Flickr::request('flickr.photos.search', ['user_id' => env('FLICKR_USERID'), 'per_page' => 48]))->first();
        $recents = collect();
        if(isset($search['photos'])){
            $recents =  collect($search['photos']['photo'])->map(function($obj) {
                return array(
                    'id' => $obj['id'],
                    'src' => 'https://live.staticflickr.com/'.$obj['server'].'/'.$obj['id'].'_'.$obj['secret'].'_q.jpg'
                );
            });
        }

        $image = collect($data['sizes']['size'])->where('label', 'Large 1600')->first();
        return view('front.post.recent-photo', compact('image', 'recents'));
    }
}
