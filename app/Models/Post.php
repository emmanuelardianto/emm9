<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Storage;
use App\Models\Photo;
use Auth;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'overview',
        'thumbnail',
        'content',
        'tags',
        'status',
        'images'
    ];

    protected $casts = [
        'images' => 'array',
        'tags' => 'array'
    ];

    public function getRouteKeyName() {
        return 'slug';
    }

    public function getThumbnailAttribute($value) {
        return !empty($value) ? Storage::disk('s3')->url($value) : '';
    }

    public static function Archives() {
        $return = \DB::table('posts')
                    ->select(\DB::raw('YEAR(created_at) year, DATE_FORMAT(`created_at`,"%m") as month, MONTHNAME(created_at) month_name, COUNT(*) post_count'))
                    ->where('status', 1)
                    ->groupBy('year')
                    ->groupBy('month')
                    ->groupBy('month_name')
                    ->orderBy('year', 'desc')
                    ->orderBy('month', 'desc')
                    ->get();
        return $return;
    }

    public function getPublishDateAttribute() {
        return $this->created_at->format('d M Y');
    }

    public function getRelatedPostsAttribute() {
        return Post::where('status', 1)->where('status', 1)->where('id', '!=' , $this->id)->get()->take(3);
    }

    public function getBodyOverviewAttribute() {
        $delimiter = '<p class="d-none separator">&nbsp;</p>';
        $return = $this->body;
        if (substr_count($this->body, $delimiter) > 0) {
            $return = explode($delimiter, $this->body)[0];
            $doc = new \DOMDocument();
            $doc->loadHTML($return);
            $return = $doc->saveHTML();
            $return .= '<a class="text-dark" href="'.route('front.post.detail', $this).'">Read More</a>';
        } elseif (strlen(strip_tags($this->body)) > 350) {
            $return = substr($this->body, 0, 500);
            $doc = new \DOMDocument();
            $doc->loadHTML($return);
            $return = $doc->saveHTML();
            $return .= '<a class="text-dark" href="'.route('front.post.detail', $this).'">Read More</a>';
        }
        return $return;
    }

    public function nextPost() {
        return self::where('updated_at', '>', $this->created_at)->where('status', 1)->first();
    }

    public function previousPost() {
        return self::where('updated_at', '<', $this->created_at)->where('status', 1)->first();
    }

    public function getPhotosAttribute() {
        return Photo::whereIn('id', collect($this->images)->map(function($obj) {
            return (Int)$obj;
        })->toArray())->get();
    }
    
    public function getFirstPhotoAttribute() {
        if(count($this->images) == 0)
            return '';
        $data = collect(\Flickr::request('flickr.photos.getSizes', ['user_id' => env('FLICKR_USERID'), 'photo_id' => collect($this->images)->last()]))->first();

        if(!isset($data['sizes']))
            return '';
        
        $image = collect($data['sizes']['size'])->where('label', 'Large 1600')->first();
        return $image;
    }

    public function getTitleAttribute($value) {
        return $value.(Auth::check() && !$this->status ? ' - unpublish' : '');
    }

    public function getJoinedTagAttribute() {
        return implode(',', $this->tags);
    }

    public function getFlickerSearch($size = 'b') {
        if(!$this->joined_tag) {
            return [];
        }
        $data = collect(\Flickr::request('flickr.photos.search', ['user_id' => env('FLICKR_USERID'), 'tags' => $this->joined_tag ]))->first();
        if(isset($data['photos'])){
            return collect($data['photos']['photo'])->map(function($obj) use($size) {
                return array(
                    'id' => $obj['id'],
                    'src' => 'https://live.staticflickr.com/'.$obj['server'].'/'.$obj['id'].'_'.$obj['secret'].'_'.$size.'.jpg'
                );
            });
        }
        return [];
    }

    public function getFlickrAttribute() {
        return $this->getFlickerSearch();
    }

    public function getFlickrThumbnailsAttribute() {
        return $this->getFlickerSearch('q');
    }
}
