@extends('layouts.main')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-3">
                <span>Photo</span>
            </h2>
            <div>
            @include('include.alert')
            <form role="form" method="POST" action="{{ isset($photo) ? route('admin.photo.update', $photo) : route('admin.photo.store') }}" novalidate class="form-button-disabled" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group row mb-3">
                    <label class="col-sm-3 col-form-label border-right">Image</label>
                    <div class="col-sm-9">
                        <div class="custom-file mb-3">
                            <input type="file" class="custom-file-input" id="url" name="url" onchange="document.getElementById('imgImage').src = window.URL.createObjectURL(this.files[0])" />
                            <label class="custom-file-label" for="customFile">{{ isset($photo) ? $photo->url : 'Choose File' }}</label>
                        </div>
                        <img id="imgImage" src="{{ isset($photo) && $photo->url != '' ?  URL($photo->url) : 'https://dummyimage.com/100x100/d1d1d1/dbdbdb.png' }}" alt="image" title="image" width="100px" /><br />
                        <div class="py-1">
                            <button type="button" class="btn btn-sm btn-secondary" onclick="document.getElementById('url').value = '';document.getElementById('imgImage').src = 'https://dummyimage.com/100x100/d1d1d1/dbdbdb.png';">Remove</button>
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="title" class="col-sm-3 col-form-label border-right">Tags</label>
                    <div class="col-sm-9">
                        <input id="tags" type="text" class="form-control" name="tags" value="{{ isset($photo) ? $photo->joined_tag : old('tags') }}" required>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="visible" class="col-sm-3 col-form-label border-right">Visibility</label>
                    <div class="col-sm-9">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="visible" id="cbx_publish" value="1" {{ isset($photo) && $photo->visible == '1' || old('visible') == '1' || !isset($photo) ? 'checked' : '' }}>
                            <label class="form-check-label" for="cbx_publish">Publish</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="visible" id="cbx_unpublish" value="0" {{ isset($photo) && $photo->visible == '0' || old('visible') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="cbx_unpublish">Unpublish</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-9 offset-sm-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.tiny.cloud/1/5c7f4h2e4xyigs7jqeb41nz2ku0empfoyw9r4o9gqbjf83tf/tinymce/5/tinymce.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
@stop