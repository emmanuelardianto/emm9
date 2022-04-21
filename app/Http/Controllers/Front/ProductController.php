<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Product;
use Auth;

class ProductController extends Controller
{
    public function index(Request $request) {
        $products = Product::orderBy('updated_at', 'desc');
        if(!Auth::user()) {
            $products = $products->where('status', 1);
        }

        $products = $products->paginate(24);

        $data = collect();
        $data = $data->concat($products->map(function($item) use($request) {
            return [
                'thumbnail' => $item->thumbnail,
                'title' => $item->full_name,
                'link' => $item->getLinkByLocation($request->get('location')),
                'type' => 'product',
                'updated_at' => $item->updated_at
            ];
        }));

        return view('front.product.index', compact('products', 'data'));
    }
}
