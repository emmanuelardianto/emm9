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
            <div class="text-center mb-3"><img src="{{ $image['source'] }}" style="max-width: 100%;" alt="{{ $post->title }}" title="{{ $post->title }}" /></div>
            <div class="row g-1">
                @foreach(collect($post->flickr_thumbnails)->reverse() as $photo)
                <div class="col-xl-1 col-lg-2 col-md-3 col-sm-4 col-6">
                    <a href="{{ route('front.post.detail.photo', [ 'post' => $post, 'flickr' => $photo['id'] ]) }}">
                        <img src="{{ $photo['src'] }}" alt="{{ $post->title }}" width="100%">
                    </a>
                </div>               
                @endforeach
            </div>
            <h5 class="mt-3 mb-1">Share this post</h5>
            <div class="addthis_inline_share_toolbox mb-3 data-url="{{ route('front.post.detail', $post) }}" data-title="{{ $post->title }}" data-description="{{ $post->overview }}"></div>
        </div>
    </div>
</div>
@endsection