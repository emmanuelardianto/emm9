@extends('layouts.main')
@section('content')
<div class="container-fluid">
    <div class="grid">
        <div class="grid-sizer"></div>
        <div class="gutter-sizer"></div>
        @foreach($posts as $post)
        @if($post->first_photo != '')
        <a class="grid-item" href="{{ route('front.post.detail', $post) }}">
            <div style="position: relative;">
                <img src="{{ $post->first_photo['source'] }}" class="grid-image" alt="{{ $post->title }}" width="100%" class="d-block">
                <div class="overlay"></div>
                <div class="title">{{ $post->title }}</div>
            </div>
        </a>
        @endif
        @endforeach
    </div>
    <div class="row g-1 mt-3">
        @foreach($recents as $photo)
        <div class="col-xl-1 col-lg-2 col-md-3 col-sm-4 col-6">
            <a href="{{ route('front.home.recent.photo', $photo['id']) }}">
                <img src="{{ $photo['src'] }}" alt="emmards" width="100%">
            </a>
        </div>               
        @endforeach
    </div>
</div>
@endsection