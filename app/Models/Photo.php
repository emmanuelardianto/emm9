<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Storage;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'visible',
        'tag',
    ];

    public function getImageAttribute($value) {
        if(str_contains($this->url, 'flickr'))
            return $this->url;
            
        return !empty($this->url) ? Storage::disk('s3')->url($this->url) : '';
    }
}
