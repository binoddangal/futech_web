<?php

namespace App\Models\Cms\Blog;

use App\Http\Traits\Loggable;
use App\Models\Cms\Blog\Category\BlogCategory;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory ,Sluggable, SoftDeletes, Loggable;

    protected $uploadPath = "uploads/blog";

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
        'publish_date',
        'image',
        'author_name',
        'author_image',
        'content',
        'seo_title',
        'seo_keyword',
        'seo_description',
        'social_share_image',
        'social_share_description',
        'category_id',
        'type',
        'is_active',
    ];

    protected $appends = ['categories', 'category_ids', 'image_path', 'author_image_path', 'share_link'];

    public function getImagePathAttribute()
    {
        $imagePath = [];
        if (!empty($this->image)) {
            $imagePath = getImagePath($this->uploadPath, $this->image);
        }
        return $imagePath;
    }

    public function getShareLinkAttribute()
    {
        if ($this) {
            return shareBlogLink(route('blog.detail', ['slug' => $this->slug]), $this);
        }
        return null;
    }

    public function getAuthorImagePathAttribute()
    {
        $imagePath = [];
        if (!empty($this->author_image)) {
            $imagePath = getImagePath($this->uploadPath, $this->author_image);
        }
        return $imagePath;
    }

    public function getCategoriesAttribute()
    {
        if(!empty($this->category_id)){
            $categoryId = !empty($this->category_id) ? explode(',', $this->category_id) : [];
            $categories = BlogCategory::whereIn('id', $categoryId)->select('id', 'title')->orderBy('position', 'ASC')->get();
            return $categories;
        }
        return [];
    }

    public function getCategoryIdsAttribute()
    {
        if(!empty($this->category_id)) {
            $ids = [];
            $categoryIds = !empty($this->category_id) ? explode(',', $this->category_id) : [];
            foreach ($categoryIds as $categoryId) {
               array_push($ids, intval($categoryId));
            }
            return $ids;
        }
        return [];
    }
}
