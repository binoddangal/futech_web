<?php

namespace App\Models\Category\SubCategory;

use App\Http\Traits\Loggable;
use App\Models\Category\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
    use HasFactory, SoftDeletes, Loggable;

    protected $fillable = [
        'title',
        'category_id',
        'description',
        'is_active',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
