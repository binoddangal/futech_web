<?php

namespace App\Models\Cms\Career;

use App\Models\Cms\Career\Application\CareerApplication;
use Cviebrock\EloquentSluggable\Sluggable;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Career extends Model
{
    use HasFactory, SoftDeletes, Sluggable, Loggable;
    public function sluggable():array
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
        'description',
        'opened_at',
        'expiry_date',
        'employment_type',
        'min_qualification',
        'salary_offer',
        'no_of_vacancies',
        'is_active',

    ];
    public function career_applications(){
        return $this->hasMany(CareerApplication::class,'career_id');
    }
}
