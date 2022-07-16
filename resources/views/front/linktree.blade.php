@extends('layouts.main')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-4 col-10">
        @foreach($links as $link)
        <a href="{{ $link['link'] }}" class="btn btn-outline-dark btn-lg w-100 my-2" target="_blank">{{ $link['title'] }}</a>
        @endforeach
        </div>
    </div>
</div>
@endsection