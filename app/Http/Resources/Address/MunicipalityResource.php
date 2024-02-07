<?php

namespace App\Http\Resources\Address;

use Illuminate\Http\Resources\Json\JsonResource;

class MunicipalityResource extends JsonResource
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
            'title_np' => $this->title_np,
            'is_active' => $this->is_active,
            'province_id' => $this->province_id,
            'district_id' => $this->district_id,
            'data_id' => $this->data_id
        ];

        return $resource;
    }
}
