@extends('layouts.main')
@section('content')
<div class="container-fluid">
    <div class="grid">
        <div class="grid-sizer"></div>
        @foreach($posts as $post)
        <a class="grid-item" href="{{ route('front.post.detail', $post) }}">
            <div style="position: relative;">
                <img src="{{ $post->first_photo }}" class="grid-image" alt="{{ $post->tags }}" width="100%" class="d-block">
                <div class="overlay"></div>
                <div class="title">{{ $post->title }}</div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endsection