@extends('layouts.main')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Archive</h1>
            @foreach(\App\Model\Post::Archives() as $archive)
            <div class="py-2">
                <a href="{{ route('front.post.archive', ['year' => $archive->year, 'month' => $archive->month]) }}" class="text-dark">{{ $archive->month_name.' '.$archive->year.' ('.$archive->post_count.')' }}</a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection