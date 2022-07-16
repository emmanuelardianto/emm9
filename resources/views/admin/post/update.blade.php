@extends('layouts.main')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-3">
                <span>Post</span>
            </h2>
            <div>
            @include('include.alert')
            <form role="form" method="POST" action="{{ isset($post) ? route('admin.post.update', $post) : route('admin.post.store') }}" novalidate class="form-button-disabled" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group row mb-3">
                    <label for="title" class="col-sm-3 col-form-label border-right">Title</label>
                    <div class="col-sm-9">
                        <input id="title" type="text" class="form-control" name="title" value="{{ isset($post) ? $post->title : old('title') }}" required>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="tinycontent" class="col-sm-3 col-form-label border-right">Content</label>
                    <div class="col-sm-9">
                        <textarea id="tinycontent" style="min-height: 200px;" type="text" class="form-control" name="content">{{ isset($post) ? $post->content : old('content') }}</textarea>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="title" class="col-sm-3 col-form-label border-right">Tags</label>
                    <div class="col-sm-9">
                        <input id="tags" type="text" class="form-control" name="tags" value="{{ isset($post) ? $post->joined_tag : old('tags') }}" required>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="title" class="col-sm-3 col-form-label border-right">Photos</label>
                    <div class="col-sm-9">
                        <div id="imageForm" class="mb-2">
                            @if(isset($post))
                                @foreach($post->images as $image)
                                <div class="input-group my-2">
                                    <input type="text" class="form-control" name="images[]" placeholder="" value="{{ $image }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-danger remove" type="button">Remove {{ $loop->index }}</button>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <input type="text" class="form-control" name="images[]" value="">
                            @endif
                        </div>
                        <button type="button" class="btn btn-secondary" id="append">Append</button>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="status" class="col-sm-3 col-form-label border-right">Status</label>
                    <div class="col-sm-9">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="cbx_publish" value="1" {{ isset($post) && $post->status == '1' || old('status') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="cbx_publish">Publish</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="cbx_unpublish" value="0" {{ isset($post) && $post->status == '0' || old('status') == '0' ? 'checked' : '' }}>
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
<script type="text/javascript">
    $(function() {
        bsCustomFileInput.init()
    });

    tinymce.init({
        selector: 'textarea#tinycontent',
        plugins: [
                "advlist autolink lists link image charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste"
        ],
        toolbar: 'undo redo | styleselect | bold italic | link | alignleft aligncenter alignright | link image',
        min_height: 500,
        images_upload_handler: function (blobInfo, success, failure) {
           var xhr, formData;
           xhr = new XMLHttpRequest();
           xhr.withCredentials = false;
           xhr.open('POST', "{{ route('admin.post.image-upload') }}");
           var token = '{{ csrf_token() }}';
           xhr.setRequestHeader("X-CSRF-Token", token);
           xhr.onload = function() {
               var json;
               if (xhr.status != 200) {
                   failure('HTTP Error: ' + xhr.status);
                   return;
               }
               json = JSON.parse(xhr.responseText);

               if (!json || typeof json.location != 'string') {
                   failure('Invalid JSON: ' + xhr.responseText);
                   return;
               }
               success(json.location);
               console.log(json.location);
           };
           formData = new FormData();
           formData.append('file', blobInfo.blob(), blobInfo.filename());
           xhr.send(formData);
       }
    });

    $('#append').on('click', function(){
        let formGroup = '<div class="input-group my-2">' +
            '<input type="text" class="form-control" name="images[]" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">' +
            '<div class="input-group-append">' +
                '<button class="btn btn-outline-danger remove" type="button">Remove</button>' +
            '</div>' +
        '</div>';
        $('#imageForm').append(formGroup);
    });

    $('#imageForm').on('click', 'button.remove', function(){ 
        $(this).parent().parent().remove();
    });

    function removeItem(e) {

    }
</script>
@stop