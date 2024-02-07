<?php

namespace App\Models\Cms\Popup;

use Cviebrock\EloquentSluggable\Sluggable;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Popup extends Model
{
    use HasFactory, SoftDeletes, Sluggable, Loggable;
    protected $uploadPath = "uploads/popup";

    public function sluggable(): array
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
        'description',
        'link',
        'type',
        'location',
        'show_location',
        'image',
        'start_date',
        'end_date',
        'is_active',
        'position'

    ];
    protected $appends = [
        "image_path"
    ];

    public function getImagePathAttribute()
    {
        $imagePath = [];
        if (!empty($this->image)) {
            $imagePath = getImagePath($this->uploadPath, $this->image);
        }
        return $imagePath;
    }
}
