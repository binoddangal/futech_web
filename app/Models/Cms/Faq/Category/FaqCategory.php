<?php

namespace App\Models\Cms\Faq\Category;

use App\Models\Cms\Faq\Faq;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Http\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class FaqCategory extends Model
{
    use HasFactory, Sluggable, Loggable, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_parent',
        'parent_id',
        'position',
        'is_active',
        'old_table_id',
        'old_table_name'
    ];

    protected $appends = ['faqs'];

    public function  sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function parent()
    {
       return $this->belongsTo(FaqCategory::class, 'parent_id');
    }

    public function getFaqsAttribute()
    {
        $faqs = Faq::whereRaw('FIND_IN_SET(?,category_ids)', $this->id)->orderBy('position', 'ASC')->get();
        if(!empty($faqs)){
            return $faqs;
        }
        return null;
    }
}
