<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Storage;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'overview',
        'thumbnail',
        'content',
        'tag',
        'status'
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
        return Post::where('status', 1)->where('id', '!=' , $this->id)->get()->take(3);
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
        return self::where('created_at', '>', $this->created_at)->take(1)->first(['title', 'slug']);
    }

    public function previousPost() {
        return self::where('created_at', '<', $this->created_at)->take(1)->first(['title', 'slug']);
    }
}
