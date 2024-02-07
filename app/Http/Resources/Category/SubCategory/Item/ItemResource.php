<?php

namespace App\Http\Resources\Category\SubCategory\Item;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
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
            // 'full_title' => $this->full_title,
            'category_id' => $this->category_id,
            'category' => $this->category->title ?? null,
            'sub_category_id' => $this->sub_category_id,
            'sub_category' => $this->sub_category->title ?? null,
            'available_for' => !empty($this->available_for) ? explode(',', $this->available_for) : [],
            'available_for_texts' => $this->available_for_texts,
            'description' => $this->description,
            'is_active' => $this->is_active,
        ];


        // if($request->route()->getName() == 'generated::5dp7nIPaSKlJf3E4') {
        //     unset($resource["available_for"]);
        //     unset($resource["available_for_texts"]);
        //     unset($resource["description"]);
        // }

        return $resource;
    }
}
