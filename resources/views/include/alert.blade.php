@if (session('success'))
<div class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
  	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if (session('error'))
<div class="alert alert-danger alert-dismissible fade show">
    {!! session('error') !!}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <strong>エラーが見つかりました。</strong>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('import_error'))
    <div class="alert alert-danger alert-dismissible fade show">
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <strong>エラーが見つかりました。</strong>
        <ul class="mb-0">
            @foreach (session('import_error') as $error)
                <li>
                  列{{ $error['line'] }} : 
                  @foreach ($error['errors'] as $item)
                    {!! $item[0] !!}
                  @endforeach
                </li>
            @endforeach
        </ul>
    </div>
@endif