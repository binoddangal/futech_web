<?php

namespace App\Http\Resources\Cms\Menu\Item;

use Illuminate\Http\Resources\Json\JsonResource;

class MenuItemResource extends JsonResource
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
            'parent_id'=>$this->parent_id,
            'page_id'=>$this->page_id,
            'blog_id'=>$this->blog_id,
            'event_id'=>$this->event_id,
            'news_id'=>$this->news_id,
            'program_id'=>$this->program_id,
            'download_id'=>$this->download_id,
            'menu_type'=>$this->menu_type,
            'menu_id'=>$this->menu_id,
            'menu_location_type'=>$this->menu_location_type,
            'link'=>$this->link,
            'position'=>$this->position,
            'depth'=>$this->depth,
            'new_tab'=>$this->new_tab,
            'nested'=>$this->nested,
            'is_active'=>($this->is_active)?true:false,
        ];
        return $resource;
    }
}
