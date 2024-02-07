<?php

namespace App\Http\Resources\Cms\Blog\Category;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'is_parent' => $this->is_parent,
            'parent_id' => $this->parent_id,
            'parent_title' => $this->parent->name ?? null,
            'is_active' => ($this->is_active) ? true : false,
        ];
    }
}
