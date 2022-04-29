@extends('layouts.main')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-3">
                <span>Photo</span>
                <div class="float-right">
                    <a class="btn btn-primary" href="{{ route('admin.photo.create') }}">New Photo</a>
                </div>
            </h2>
            @include('include.alert')
            <div class="row">
                @foreach ($photos as $item)
                <div class="col-lg-3 mb-3">
                    <img src="{{ $item->image }}" alt="{{ $item->tags }}" width="100%">
                    {{ $item->tags }}
                </div>
                @endforeach
            </div>
            <div class="d-flex">
            {{ $photos->appends($_GET)->links() }}
            </div>
        </div>
    </div>
</div>
@endsection