@extends('layouts.main')
@section('content')
<div class="container-fluid">
    <div class="row py-3">
        <div class="col-12 mb-3">
            <h2>Collections</h2>
        </div>
        <div class="col-12">
            @include('components.general.item', [ 'data' => $data ])
            {{ $collections->appends($_GET)->links() }}
        </div>
    </div>
</div>
@endsection