<?php

namespace App\Http\Resources\AdminUser;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminUserResource extends JsonResource
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
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'full_name' => $this->full_name,
            'mobile' => $this->mobile,
            'phone' => $this->phone,
            'username' => $this->username,
            'email' => $this->email,
            'address' => $this->address,
            'user_type' => $this->user_type,
            'user_type_text' => ucwords($this->user_type),
            'is_mfa_enabled' => $this->is_mfa_enabled ? true : false,
            'is_email_authentication_enabled' => $this->is_email_authentication_enabled ? true : false,
            'is_active' => $this->is_active  ? true : false,
        ];

        if($request->route()->getName() == 'admin-user.user-type') {
            $resource = [];

            $resource = [
                'id' => $this->id,
                'first_name' => $this->first_name,
                'middle_name' => $this->middle_name,
                'last_name' => $this->last_name,
                'full_name' => $this->full_name,
                'mobile' => $this->mobile,
                'username' => $this->username,
                'email' => $this->email,
                'user_type_text' => ucwords($this->user_type),
                'is_active' => $this->is_active ? true : false,
            ];
        }

        return $resource;
    }
}
