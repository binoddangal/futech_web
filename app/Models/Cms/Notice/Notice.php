<?php

namespace App\Models\Cms\Notice;

use Cviebrock\EloquentSluggable\Sluggable;
use App\Http\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Notice extends Model
{
    use HasFactory, Sluggable, Loggable, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'user_type',
        'position',
        'visible_from_date',
        'is_active',
        'created_at',
        'old_table_id',
        'old_table_name'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected $appends = ['user_types'];


    public function getUserTypesAttribute()
    {
        $types = !empty($this->user_type) ? array_map('trim', explode(',', $this->user_type)) : null;
        if(!empty($types)) {
            $temp = [];
            foreach ($types as $type) {
                $type = ucwords($type);
                array_push($temp, $type);
            }
            return $temp;
        }
        return null;
    }
}
