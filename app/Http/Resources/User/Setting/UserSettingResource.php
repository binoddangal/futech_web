<?php

namespace App\Http\Resources\User\Setting;

use App\Http\Resources\Category\SubCategory\Item\ItemResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserSettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $resource = [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'blood_group' => $this->blood_group,
            'education' => $this->education,
            'experience' => $this->experience,
            'cv' => $this->cv,
            'cv_file_path' => $this->cv_file_path,
            'default_address_id' => $this->default_address_id,
            "org_name" => $this->org_name,
            "org_contact_name" => $this->org_contact_name,
            "org_email" => $this->org_email,
            "org_address_id" => $this->org_address_id,
            "application_document" => $this->application_document,
            "agreement_document" => $this->agreement_document,
            "agreement_signed" => $this->agreement_signed,
            "agreement_signed_date" => $this->agreement_signed_date,
            "offering_item_ids" => $this->offering_item_ids ? explode(',', $this->offering_item_ids) : [],
            "offering_sub_category_ids" => $this->offering_sub_category_ids ? explode(',', $this->offering_sub_category_ids) : [],
            "offering_category_ids" => $this->offering_category_ids ? explode(',', $this->offering_category_ids) : [],
            "offering_items" => ItemResource::collection($this->offering_items),
        ];

        return $resource;
    }
}
