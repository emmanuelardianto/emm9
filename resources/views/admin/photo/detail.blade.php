@extends('layouts.main')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <a href="{{ route('admin.post.index') }}">Back</a>
            <h1>{{ $post->title }}</h1>
            <a href="{{ route('admin.post.edit', $post) }}">Edit</a>
            <div class="body-post">{!! $post->body !!}</div>
        </div>
    </div>
</div>
@endsection