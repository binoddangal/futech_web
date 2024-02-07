<?php

namespace App\Http\Resources\Cms\Career;

use Illuminate\Http\Resources\Json\JsonResource;

class CareerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'position' => $this->position,
            'description' => $this->description,
            'opened_at' => $this->opened_at,
            'display_opened_at' => !empty($this->opened_at)?formatDate($this->opened_at):null,
            'display_expiry_date' => !empty($this->expiry_date)?formatDate($this->expiry_date):null,
            'expiry_date' => $this->expiry_date,
            'expiry_date_format' =>  date('Y-m-d', strtotime($this->expiry_date)),
            'employment_type' => $this->employment_type,
            'min_qualification' => $this->min_qualification,
            'salary_offer' => $this->salary_offer,
            'no_of_vacancies' => $this->no_of_vacancies,
            'is_active' => $this->is_active,
            'career_application_count'=>$this->career_applications->count() ?? 0,
        ];

    }
}
