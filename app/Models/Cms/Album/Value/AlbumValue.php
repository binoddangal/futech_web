<?php

namespace App\Models\Cms\Album\Value;

use App\Http\Traits\Loggable;
use App\Models\Album\Album;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AlbumValue extends Model
{
    use HasFactory, Sluggable, SoftDeletes, Loggable;
    
    protected $uploadPath = "uploads/album/value";



    protected $fillable = [
        'album_id',
        'title',
        'path',
        'is_featured',
        'position',
        'slug',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ]
        ];
    }

    protected $appends = [
        "image_path"
    ];


    public function getImagePathAttribute()
    {
        $imagePath = [];
        if (!empty($this->path)) {
            $imagePath = getImagePath($this->uploadPath, $this->path);
        }
        return $imagePath;
    }

    public function albumb()
    {
        return $this->belongsTo(Album::class, 'album_id');
    }
}
