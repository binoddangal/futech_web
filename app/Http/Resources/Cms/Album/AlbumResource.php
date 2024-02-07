<?php

namespace App\Http\Resources\Cms\Album;

use Illuminate\Http\Resources\Json\JsonResource;

class AlbumResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $resource = [
            'id'=>$this->id,
            'title'=>$this->title,
            'cover_image_path'=>$this->cover_image_path,
            'description'=>$this->description,
            'tags'=>$this->tags ? explode(',', $this->tags) : [],
            'position'=>$this->position,
            'is_active'=>($this->is_active)?true:false,
        ];
        return $resource;
    }
}
