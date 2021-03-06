<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Auth;

class PostController extends Controller
{
    public function index(Request $request) {
        $posts = Post::orderBy('created_at', 'desc');

        if(!Auth::check()) {
            $posts = $posts->where('status', 1);
        }

        $posts = $posts->paginate(24);

        $data = collect();

        $data = $data->concat($posts->map(function($item) {
            return [
                'thumbnail' => $item->thumbnail,
                'title' => $item->title,
                'link' => route('front.post.detail', $item),
                'type' => 'post',
                'updated_at' => $item->updated_at
            ];
        }));

        return view('front.post.index', compact('posts', 'data'));
    }

    public function show(Post $post) {
        if(!Auth::check() && $post->status != 1)
            return abort('404');
        
        $data = collect();
        $relateds = $data->concat($post->related_posts->map(function($item) {
            return [
                'thumbnail' => $item->thumbnail,
                'title' => $item->title,
                'link' => route('front.post.detail', $item),
                'type' => 'post',
                'updated_at' => $item->updated_at
            ];
        }));
        
        return view('front.post.detail', compact('post', 'relateds'));
    }

    public function archivePage() {
        return view('front.post.archive');
    }

    public function archive($year, $month) {
        $posts = Post::orderBy('created_at', 'desc')
                    ->whereYear('created_at', '=', $year)
                    ->whereMonth('created_at', '=', $month)
                    ->where('status', 1)->paginate(10);

        $title = 'Archive '.$year.'-'.substr('0'.$month, -2);
        return view('front.post.index', compact('posts', 'title'));
    }

    public function category($category) {
        $posts = Post::orderBy('created_at', 'desc')
                    ->where('category', $category)
                    ->where('status', 1)->paginate(10);

        return view('front.post.index', compact('posts'));
    }

    public function search(Request $request) {
        $search = $request->get('query');

        $posts = Post::orderBy('created_at', 'desc')
                    ->where('title', 'like', '%'.$search.'%')
                    ->where('status', 1)->paginate(10);

        return view('front.post.index', compact('posts', 'search'));
    }

    public function showImageDetail(Post $post, $flickr) {
        if(!Auth::check() && $post->status != 1 && !$flickr)
            return abort('404');
        
        $data = collect(\Flickr::request('flickr.photos.getSizes', ['user_id' => env('FLICKR_USERID'), 'photo_id' => $flickr]))->first();
        if(!isset($data['sizes'])) {
            return abort('404');
        }
        $image = collect($data['sizes']['size'])->where('label', 'Large 1600')->first();
        return view('front.post.detail-photo', compact('post', 'image'));
    }
}
