{{--
<div class="py-3 px-3 mb-3">
    <h5 class="border-bottom pb-2 mb-3">Subscribe</h5>
    <input type="text" class="form-control" />
</div>
--}}
<div class="py-3">
    <h5 class="title-border pb-1 d-inline-block">Archives</h5>
    @foreach(\App\Model\Post::Archives() as $archive)
    <div class="py-2 border-bottom">
        <a href="{{ route('front.post.archive', ['year' => $archive->year, 'month' => $archive->month]) }}" class="text-dark">{{ $archive->month_name.' '.$archive->year.' ('.$archive->post_count.')' }}</a>
    </div>
    @endforeach
</div>
<div class="py-3">
    <h5 class="title-border pb-1 d-inline-block">Follow Me</h5>
    @foreach(trans('social') as $key => $value)
    <div class="py-2 border-bottom">
        <a href="{{ $value['url'] }}" class="text-dark" rel="nofollow" target="_blank"><i class="{{ $value['icon'] }}"></i>&nbsp;&nbsp;{{ $value['username'] }}</a>
    </div>
    @endforeach
</div>