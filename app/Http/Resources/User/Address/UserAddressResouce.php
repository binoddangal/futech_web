<?php

namespace App\Http\Resources\User\Address;

use Illuminate\Http\Resources\Json\JsonResource;

class UserAddressResouce extends JsonResource
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
            'user_id' => $this->user_id,
            'address_line_1' => $this->address_line_1,
            'address_line_2' => $this->address_line_2,
            'full_address' => $this->full_address,
            'type' => $this->type,
            'type_text' => ucwords($this->type),
            'province_id' => $this->province_id,
            'province' => $this->province->title ?? null,
            'district_id' => $this->district_id,
            'district' => $this->district->title ?? null,
            'municipality_id' => $this->municipality_id,
            'municipality' => $this->municipality->title ?? null,
            'ward_no' => $this->ward_no,
            'post_code' => $this->post_code,
        ];
        return $resource;
    }
}
