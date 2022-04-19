@extends('layouts.main')
@section('content')
<div class="container">
    <div class="row py-3">
        <div class="col-12 mb-3">
            <h2>{{ $collection->title }}</h2>
        </div>
        @include('components.product.item', ['products' => $collection->products(), 'location' => $location])
    </div>
</div>
@endsection