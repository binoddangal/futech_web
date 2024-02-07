<?php

namespace App\Http\Resources\Cms\Blog;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $resource = [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'type' => $this->type,
            'publish_date' =>$this->publish_date,
            'formatted_publish_date' => !empty($this->publish_date)?formatDate($this->publish_date):null,
            'author_name' => $this->author_name,
            'author_image_path' => $this->author_image_path,
            'custom_slug' => $this->custom_slug,
            'image_path' => $this->image_path,
            'content' => $this->content,
            'main_css' => $this->main_css,
            'section_css' => $this->section_css,
            'seo_title' => ($this->seo_title != "null")?$this->seo_title:null,
            'seo_keyword' => ($this->seo_keyword != "null")?$this->seo_keyword:null,
            'seo_description' => ($this->seo_description != "null")?$this->seo_description:null,
            'social_share_image' => $this->social_share_image,
            'social_share_description' => $this->social_share_description,
            'category_id' =>  $this->category_ids,
            'categories' => $this->categories,
            'is_active' => ($this->is_active)?true:false,
        ];
        return $resource;
    }
}
