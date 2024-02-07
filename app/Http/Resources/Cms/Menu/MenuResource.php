<?php

namespace App\Http\Resources\Cms\Menu;

use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
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
            'menu_type' => $this->menu_type,
            'header' => ($this->header) ? true : false,
            'is_active' => ($this->is_active) ? true : false,
        ];
        return $resource;
    }
}
