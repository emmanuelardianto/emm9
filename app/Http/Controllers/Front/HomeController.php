<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Post;
use App\Model\Collection;
use App\Model\Product;

class HomeController extends Controller
{
    public function index(Request $request) {
        $collections = Collection::orderBy('updated_at', 'desc')->where('status', 1)->take(4)->get();
        $products = Product::orderBy('updated_at', 'desc')->where('status', 1)->take(8)->get();
        $posts = Post::orderBy('created_at', 'desc')->where('status', 1)->get()->take(10);

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

        $data = $data->concat($collections->map(function($item) {
            return [
                'thumbnail' => $item->thumbnail,
                'title' => $item->title,
                'link' => route('front.collection.show', $item),
                'type' => 'collection',
                'updated_at' => $item->updated_at
            ];
        }));

        $data = $data->concat($products->map(function($item) use($request) {
            return [
                'thumbnail' => $item->thumbnail,
                'title' => $item->full_name,
                'link' => $item->getLinkByLocation($request->get('location')),
                'type' => 'product',
                'updated_at' => $item->updated_at
            ];
        }));

        $data = $data->sortByDesc('updated_at');

        return view('front.index', compact('posts', 'collections', 'products', 'data'));
    }
}
