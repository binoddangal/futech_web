<?php

namespace App\Models\Category\SubCategory\Item;

use App\Http\Traits\Loggable;
use App\Models\Category\Category;
use App\Models\Category\SubCategory\SubCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes, Loggable;

    protected $fillable = [
        'category_id',
        'sub_category_id',
        'title',
        'available_for',
        'description',
        'is_active',
    ];

    protected $appends = ['available_for_texts'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function getFullTitleAttribute()
    {
        $title = [];
        $title[] = ucfirst($this->title);

        if($this->sub_category) {
            $title[] = ucfirst($this->sub_category->title);
        }

        if($this->category) {
            $title[] = ucfirst($this->category->title);
        }

        return implode('-', $title);
    }

    public function getAvailableForTextsAttribute()
    {
        $availables = !empty($this->available_for) ? explode(',', $this->available_for) : [];

        if(!empty($availables)) {
            $available_for_text = [];
            foreach ($availables as $available) {
                array_push($available_for_text, ucwords(str_replace('_', ' ', $available)));
            }
            return $available_for_text;
        }

        return [];
    }
}
