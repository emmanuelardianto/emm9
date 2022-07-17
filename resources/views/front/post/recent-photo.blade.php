@extends('layouts.main')
@section('title', trans('meta.title'))
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1>Recent Photos</h1>
            <div class="text-center mb-3"><img src="{{ $image['source'] }}" style="max-width: 100%;" alt="emmards Recenty Post" title="emmards Recenty Post" /></div>
            <div class="row g-1">
                @foreach($recents as $photo)
                <div class="col-xl-1 col-lg-2 col-md-3 col-sm-4 col-6">
                    <a href="{{ route('front.home.recent.photo', $photo['id']) }}">
                        <img src="{{ $photo['src'] }}" alt="emmards" width="100%">
                    </a>
                </div>               
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection