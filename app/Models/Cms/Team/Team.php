<?php

namespace App\Models\Cms\Team;

use App\Http\Traits\Loggable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory, Sluggable, Loggable;

    protected $uploadPath = "uploads/team";

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
        'position',
        'image',
        'description',
        'job_title',
        'fb_url',
        'linked_url',
        'is_active',
    ];

    protected $appends = ['image_path'];


    public function getImagePathAttribute()
    {
        $imagePath = [];
        if (!empty($this->image)) {
            $imagePath = getImagePath($this->uploadPath, $this->image);
        }
        return $imagePath;
    }

}
