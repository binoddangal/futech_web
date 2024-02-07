<?php

namespace App\Http\Resources\Cms\Popup;

use Illuminate\Http\Resources\Json\JsonResource;

class PopupResource extends JsonResource
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
           'id' => $this->id,
           'title' => $this->title,
           'description' => $this->description,
           'link' => $this->link,
           'type' => $this->type,
           'type_text' => ucwords($this->type),
           'location' => $this->location,
           'show_location' => $this->show_location,
           'image_path' => $this->image_path,
//           'start_date' => $this->start_date,
//           'end_date' => $this->end_date,
//           'start_date_value' => !empty($this->start_date)?date('Y M d', strtotime($this->start_date)):null,
//           'end_date_value' => !empty($this->end_date)?date('Y M d', strtotime($this->end_date)):null,
           'is_active' => $this->is_active,
       ];
       return $resource;
    }
}
