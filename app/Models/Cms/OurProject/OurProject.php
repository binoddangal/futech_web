<?php

namespace App\Models\Cms\OurProject;

use App\Http\Traits\Loggable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OurProject extends Model
{
    use HasFactory ,Sluggable, SoftDeletes,  Loggable;

    protected $uploadPath = "uploads/our-project";

    protected $fillable = ['title', 'slug', 'description', 'featured_photo', 'is_active'];

    protected $appends = ['featured_photo_path'];


    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function getFeaturedPhotoPathAttribute()
    {
        $featuredPhotoPath = [];

        if (!empty($this->featured_photo)) {
            $featuredPhotoPath = getImagePath($this->uploadPath, $this->featured_photo);
        }

        return $featuredPhotoPath;
    }


}
