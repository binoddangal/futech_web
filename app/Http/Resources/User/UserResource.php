<?php

namespace App\Http\Resources\User;

use App\Http\Resources\User\Setting\UserSettingResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'full_name' => $this->full_name,
            'gender' => $this->gender,
            'gender_text' => $this->gender_text,
            'date_of_birth' => $this->date_of_birth,
            'formatted_date_of_birth' => $this->date_of_birth ? formatDate($this->date_of_birth) : null,
            'date_of_birth_np' => $this->date_of_birth_np,
            'phone_format' => formatPhone($this->phone),
            'mobile_format' => formatPhone($this->mobile),
            'email' => $this->email,
            'unique_identifier' => $this->unique_identifier,
            'mobile' => $this->mobile,
            'phone' => $this->phone,
            'work_phone' => $this->work_phone,
            'application_document_path' => $this->setting->application_document_path ?? null,
            'agreement_document_path' => $this->setting->agreement_document_path ?? null,
            'account_type' => $this->account_type,
            'account_type_text' => $this->account_type_text,
            'user_type' => $this->user_type,
            'user_type_text' => $this->user_type_text,
            'status' => $this->status,
            'full_permanent_address' => $this->permanent_address->full_address ?? null,
            'full_temporary_address' => $this->temporary_address->full_address ?? null,
            'is_profile_complete' => $this->is_profile_complete,
            'is_login_verified' => $this->is_login_verified,
            'is_mfa_enabled' => $this->is_mfa_enabled,
            'is_email_authentication_enabled' => $this->is_email_authentication_enabled,
            'is_active' => $this->is_active
        ];

        if($request->route()->getName() == 'users.show' || $request->route()->getName() == 'user.index') {
            $resource['setting'] = $this->setting ? new UserSettingResource($this->setting) : null;
            unset($resource['setting']['application_document_path']);
            unset($resource['setting']['agreement_document_path']);
        };

        return $resource;
    }
}
