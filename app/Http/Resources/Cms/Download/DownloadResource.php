<?php

namespace App\Http\Resources\Cms\Download;

use Illuminate\Http\Resources\Json\JsonResource;

class DownloadResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'slug' => $this->slug,
            'download_type_id' => $this->download_type_id,
            'position' => $this->position,
            'type_name' => !empty($this->type) ? $this->type->title : null,
            'path' => $this->path,
            'file_path' => $this->file_path,
            'preview_image' => $this->preview_image,
            'preview_image_path' => $this->preview_image_path,
            'is_private' => $this->is_private,
            'public_hidden' => $this->is_private,
            'is_active' => $this->is_active,
        ];
        return $resource;
    }
}
