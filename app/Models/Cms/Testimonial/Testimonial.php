<?php

namespace App\Models\Cms\Testimonial;

use App\Models\Cms\Level\Program\Program;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    use HasFactory, SoftDeletes, Loggable;

    protected $uploadPath = "uploads/testimonial";


    protected $fillable = [
        'program_id',
        'title',
        'name',
        'description',
        'type',
        'job_title',
        'image',
        'rating',
        'status',
        'position',
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


    public function program(){
        return $this->belongsTo(Program::class,'program_id');
    }
}
