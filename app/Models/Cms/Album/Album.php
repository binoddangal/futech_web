<?php

namespace App\Models\Cms\Album;

use App\Http\Traits\Loggable;
use App\Models\Album\Value\AlbumValue;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Album extends Model
{
    use HasFactory, SoftDeletes, Sluggable, Loggable;

    protected $uploadPath = "uploads/album";

    public function  sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    protected $fillable = [
        'title',
        'slug',
        'cover_image',
        'description',
        'event_date',
        'is_active',
        'tags',
        'position',
    ];

    protected $appends = [
        "cover_image_path"
    ];

    public function getCoverImagePathAttribute()
    {
        $imagePath = [];
        if (!empty($this->cover_image)) {
            $imagePath = getImagePath($this->uploadPath, $this->cover_image);
        }
        return $imagePath;
    }

    public function photos(){
        return $this->hasMany(AlbumValue::class,'album_id');
    }
}
