@extends('layouts.main')
@section('content')
<div class="container">
    <div class="row py-3">
        <div class="col-lg-8 col-md-8 col-12">
            <h1>Contact Me</h1>
            <p>I open to collaborate with you in photography and web and mobile development. You can reach me directly at <a href="mailto:i_am@emmards.me">i_am@emmards.me</a>.</p>

            <img src="https://emgallery.s3-ap-northeast-1.amazonaws.com/blog/upload/main/contact.jpg" title="this is me" alt="this is me" style="width: 100%" />
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            @include('include.sidebar')
        </div>
    </div>
</div>
@endsection