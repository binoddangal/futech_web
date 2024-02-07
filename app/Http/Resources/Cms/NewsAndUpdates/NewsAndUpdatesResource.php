<?php

namespace App\Http\Resources\Cms\NewsAndUpdates;

use Illuminate\Http\Resources\Json\JsonResource;

class NewsAndUpdatesResource extends JsonResource
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
            'slug'=>$this->slug,
            'url'=>$this->url,
            'published_by'=>$this->published_by,
            'publish_date' => $this->publish_date,
            'social_share_image' => $this->social_share_image,
            'is_active' => $this->is_active,
        ];
        return $resource;
    }
}
