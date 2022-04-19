@extends('layouts.main')
@section('content')
<div class="container">
    <div class="row py-3">
        <div class="col-12 mb-3">
            <h2>Recommended Products</h2>
        </div>
        @include('components.general.item', [ 'data' => $data ])
        <div class="col-12">
            {{ $products->appends($_GET)->links() }}
        </div>
    </div>
</div>
@endsection