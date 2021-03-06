@extends('layouts.main')
@section('title', $post->title.' - '.trans('meta.title'))
@section('meta_image', $post->thumbnail)
@section('meta_description', $post->overview)
@section('meta_keywords', $post->keywords)
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1>{{ $post->title }}</h1>
            <span>{{ $post->publish_date }}</span>
            @if(Auth::check()) <a href="{{ route('admin.post.edit', $post) }}">Edit</a> @endif
            <h5 class="mt-3 mb-1">Share this post</h5>
            <div class="addthis_inline_share_toolbox mb-3 data-url="{{ route('front.post.detail', $post) }}" data-title="{{ $post->title }}" data-description="{{ $post->overview }}"></div>
            <div class="body-post">{!! $post->content !!}</div>
            <div class="grid">
                <div class="grid-sizer"></div>
                <div class="gutter-sizer"></div>
                @foreach(collect($post->flickr)->reverse() as $photo)
                <div class="grid-item">
                    <a href="{{ route('front.post.detail.photo', [ 'post' => $post, 'flickr' => $photo['id'] ]) }}">
                        <img src="{{ $photo['src'] }}" alt="{{ $post->title }}" width="100%">
                    </a>
                </div>               
                @endforeach
            </div>
            <h5 class="mt-3 mb-1">Share this post</h5>
            <div class="addthis_inline_share_toolbox mb-3 data-url="{{ route('front.post.detail', $post) }}" data-title="{{ $post->title }}" data-description="{{ $post->overview }}"></div>
        </div>
        <div class="col-12 col-md-6">
            @if(!is_null($post->previousPost()))
            <span>Previous</span>
            <h2 class="post-sub"><a href="{{ route('front.post.detail', $post->previousPost()) }}" class="text-dark">{{ $post->previousPost()->title }}</a></h2>
            @endif
        </div>
        <div class="col-12 col-md-6 text-left text-md-right">
            @if(!is_null($post->nextPost()))
            <span>Next</span>
            <h2 class="post-sub"><a href="{{ route('front.post.detail', $post->nextPost()) }}" class="text-dark">{{ $post->nextPost()->title }}</a></h2>
            @endif
        </div>
    </div>
</div>
@endsection