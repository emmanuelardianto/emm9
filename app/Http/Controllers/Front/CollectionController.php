<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Collection;
use Auth;

class CollectionController extends Controller
{
    public function index(Request $request) {
        $collections = Collection::orderBy('title');
        if(!Auth::user()) {
            $collections = $collections->where('status', 1);
        }

        $data = collect();
        $collections = $collections->paginate(24);

        $data = $data->concat($collections->map(function($item) {
            return [
                'thumbnail' => $item->thumbnail,
                'title' => $item->title,
                'link' => route('front.collection.show', $item),
                'type' => 'collection',
                'updated_at' => $item->updated_at
            ];
        }));
        return view('front.collection.index', compact('data', 'collections'));
    }

    public function show(Collection $collection, Request $request)
    {
        $location = $request->get('location');
        return view('front.collection.detail', compact('collection', 'location'));
    }
}
