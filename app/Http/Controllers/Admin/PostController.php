<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Photo;
use Carbon\Carbon;
use Storage;
use Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $posts = Post::orderBy('updated_at', 'desc');
        if ($search != '') {
            $posts = $posts->where('title', 'like', '%'.$search.'%');
        }
        $posts = $posts->paginate(20);
        return view('admin.post.index', compact('posts', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $photos = Photo::orderBy('updated_at', 'desc')->get();
        return view('admin.post.update', compact('photos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required',
        ]);
        
        if (is_null($post)) {
            $post = new Post();
        }

        $tags = collect();
        foreach(explode(',', $request->get('tags')) as $tag) {
            if ($tag != '')
                $tags->push(trim($tag));
        }
        $post->fill([
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'status' => $request->get('status'),
            'tags' => $tags->unique()->values(),
            'images' => collect($request->get('images'))
        ]);
        $slug = '';
        if (is_null($post->created_at)) {
            $datenow = Carbon::now()->timestamp;
            $slug = (Str::slug($request->get('title')) ?: $request->get('title')).'-'.$datenow;
            $post->slug = $slug;
        } else {
            $slug = $post->slug;
        }

        if ($request->hasFile('thumbnail')) {
            $post->thumbnail = $this->upload($request->file('thumbnail'), $slug.'-thumbnail');
        }

        $post->save();
        return redirect()->route('admin.post.show', compact('post'))->with('success', 'New post saved.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('admin.post.update', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
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
        $post->fill([
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'status' => $request->get('status'),
            'overview' => $request->get('overview'),
            'keywords' => $request->get('keywords'),
            'tags' => $tags->unique()->values()
        ]);
        $slug = $post->slug;

        if ($request->hasFile('thumbnail')) {
            $post->thumbnail = $this->upload($request->file('thumbnail'), $slug.'-thumbnail');
        }

        $post->save();
        return redirect()->route('admin.post.show', compact('post'))->with('success', 'New post saved.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
    }

    public function upload($file, $name = '') {
        if (empty($file))
            return '';
        
        $path= 'blog/upload/thumbnail/';
        $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        $timestamp = Carbon::now()->timestamp;
        $name = $name.'-'.$timestamp.'.'.$extension;
        $imgpath = $path.$name;
        Storage::disk('s3')->put($imgpath, file_get_contents($file));
        return $imgpath;
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
