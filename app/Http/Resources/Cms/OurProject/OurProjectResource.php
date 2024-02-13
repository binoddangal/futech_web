<?php

namespace App\Http\Resources\Cms\OurProject;

use Illuminate\Http\Resources\Json\JsonResource;

class OurProjectResource extends JsonResource
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
            'description' => $this->description,
            'featured_photo' => $this->featured_photo,
            'featured_photo_path' => $this->featured_photo_path,
            'is_active' => $this->is_active,
        ];
        return $resource;
    }
}
