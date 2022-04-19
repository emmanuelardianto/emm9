@extends('layouts.main')
@section('content')
<div class="container">
    @include('components.general.item', [ 'data' => $data ])
</div>
@endsection