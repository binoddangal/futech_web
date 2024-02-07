<?php

namespace App\Http\Resources\Cms\Faq\Category;

use Illuminate\Http\Resources\Json\JsonResource;

class FaqCategoryResource extends JsonResource
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
            'id'=>$this->id,
            'name'=>$this->name,
            'description'=>$this->description,
            'position'=>$this->position,
            'is_parent'=>$this->is_parent,
            'parent_id'=>$this->parent_id,
            'parent_name'=> $this->parent->name ?? null,
            'is_active'=>$this->is_active
        ];

        return $resource;
    }
}
