<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Photo;
use Carbon\Carbon;
use Storage;
use Str;

class PhotoController extends Controller
{
        /**
        * Display a listing of the resource.
        *
        * @return \Illuminate\Http\Response
        */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $photos = Photo::orderBy('updated_at', 'desc');
        if ($search != '') {
            $photos = $photos->where('title', 'like', '%'.$search.'%');
        }
        $photos = $photos->paginate(20);
        return view('admin.photo.index', compact('photos', 'search'));
    }

    /**
        * Show the form for creating a new resource.
        *
        * @return \Illuminate\Http\Response
        */
    public function create()
    {
        return view('admin.photo.update');
    }

    /**
        * Store a newly created resource in storage.
        *
        * @param  \Illuminate\Http\Request  $request
        * @return \Illuminate\Http\Response
        */
    public function store(Request $request, Photo $photo)
    {
        $request->validate([
            'url' => 'required',
        ]);
        
        if (is_null($photo)) {
            $photo = new Photo();
        }

        $tags = collect();
            foreach(explode(',', $request->get('tags')) as $tag) {
                if ($tag != '')
                    $tags->push(trim($tag));
            }
        $photo->fill([
            'url' => $this->upload($request->file('url')),
            'visible' => $request->get('visible'),
            'tags' => $tags->unique()->values()
        ]);

        $photo->save();
        return redirect()->route('admin.photo.index', compact('photo'))->with('success', 'New photo saved.');
    }

    /**
        * Display the specified resource.
        *
        * @param  int  $id
        * @return \Illuminate\Http\Response
        */
    public function show(Photo $photo)
    {
        $data = collect();
        $relateds = $data->concat($photo->related_photos->map(function($item) {
            return [
                'thumbnail' => $item->thumbnail,
                'title' => $item->title,
                'link' => route('front.photo.detail', $item),
                'type' => 'photo',
                'updated_at' => $item->updated_at
            ];
        }));
        return view('front.photo.detail', compact('photo', 'relateds'));
    }

    /**
        * Show the form for editing the specified resource.
        *
        * @param  int  $id
        * @return \Illuminate\Http\Response
        */
    public function edit(Photo $photo)
    {
        return view('admin.photo.update', compact('photo'));
    }

    /**
        * Update the specified resource in storage.
        *
        * @param  \Illuminate\Http\Request  $request
        * @param  int  $id
        * @return \Illuminate\Http\Response
        */
    public function update(Request $request, Photo $photo)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required'
        ]);
        
        $tags = collect();
        foreach(explode(',', $request->get('tags')) as $tag) {
            if ($tag != '')
                $tags->push(trim($tag));
        }
        $photo->fill([
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'status' => $request->get('status'),
            'overview' => $request->get('overview'),
            'keywords' => $request->get('keywords'),
            'tags' => $tags->unique()->values()
        ]);
        $slug = $photo->slug;

        if ($request->hasFile('thumbnail')) {
            $photo->thumbnail = $this->upload($request->file('thumbnail'), $slug.'-thumbnail');
        }

        $photo->save();
        return redirect()->route('admin.photo.show', compact('photo'))->with('success', 'New photo saved.');
    }

    /**
        * Remove the specified resource from storage.
        *
        * @param  int  $id
        * @return \Illuminate\Http\Response
        */
    public function destroy(Photo $photo)
    {
        $photo->delete();
    }

    public function upload($file, $name = '') {
        if (empty($file))
            return '';
        
        $path= 'blog/upload/';
        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        $timestamp = Carbon::now()->timestamp;
        $name = $name.'-'.$timestamp.'.'.$extension;
        $imgpath = $path.$name;
        return Storage::disk('s3')->put($imgpath, $file);
    }

    public function image_upload(Request $request) {
        $file=$request->file('file');
        $path= 'blog/upload/content/';
        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        $timestamp = Carbon::now()->timestamp;
        $name = $name.'-'.$timestamp.'.'.$extension;
        $imgpath = $path.$name;
        Storage::disk('s3')->put($imgpath, file_get_contents($file));
        return response()->json([
            'location' => Storage::disk('s3')->url($imgpath)
        ]);
    }
}
