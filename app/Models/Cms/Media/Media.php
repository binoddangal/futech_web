<?php

namespace App\Models\Cms\Media;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    use HasFactory, SoftDeletes, Loggable;

    protected $table = "medias";
    protected $uploadPath = "uploads/media";

    protected $fillable=[
        'path',
        'title',
        'type',
        'size',
        'is_downloadable',
        'is_featured',
        'uploaded_by',
        'is_active',

    ];

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

}
