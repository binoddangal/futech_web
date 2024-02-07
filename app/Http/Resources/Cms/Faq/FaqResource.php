<?php

namespace App\Http\Resources\Cms\Faq;

use Illuminate\Http\Resources\Json\JsonResource;

class FaqResource extends JsonResource
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
            'is_parent'=>$this->is_parent,
            'parent_id'=>$this->parent_id,
            'children'=>$this->children,
            'parent'=>$this->parent,
            'short_description'=>$this->short_description,
            'description'=>$this->description,
            'tags'=>$this->tags,
            'position'=>$this->position,
            'is_active'=>($this->is_active)?true:false,
        ];
        return $resource;
    }
}
