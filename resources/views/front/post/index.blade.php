@extends('layouts.main')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            @if(isset($title))
            <h1>{{ $title }}</h1>
            @endif
            @foreach($posts as $post)
            <div class="post-item py-2">
                <div>{{ $post->publish_date }}</div>
                <h2 class="post-sub"><a href="{{ route('front.post.detail', $post) }}" class="text-dark">{{ $post->title }}</a></h2>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection