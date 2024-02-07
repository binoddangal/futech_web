<?php

namespace App\Http\Resources\Cms\Media;

use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $resource = [
            'id' => $this->id,
            'image_path' => $this->image_path,
            'title' => $this->title,
            'type' => $this->type,
            'size' => $this->size,
            'is_downloadable' => $this->is_downloadable,
            'is_featured' => $this->is_featured,
            'uploaded_by' => $this->uploaded_by,
            'is_active' => $this->is_active,
        ];
        return $resource;
    }
}
