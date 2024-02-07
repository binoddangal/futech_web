<?php

namespace App\Http\Resources\Application;

use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
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
            'idea_title' => $this->idea_title,
            'season_id' => $this->season_id,
            'working_summary' => $this->working_summary,
            'background' => $this->background,
            'project_identification' => $this->project_identification,
            'previous_history_and_current_scenario' => $this->previous_history_and_current_scenario,
            'idea_breif_description' => $this->idea_breif_description,
            'opporttunities_and_challenges' => $this->opporttunities_and_challenges,
            'idea_work_plan' => $this->idea_work_plan,
            'additional_file_one' => $this->additional_file_one,
            'additional_file_two' => $this->additional_file_two,
            'additional_file_three' => $this->additional_file_three,
            'additional_file_four' => $this->additional_file_four,
            'additional_file_five' => $this->additional_file_five,
        ];

        return $resource;
    }
}
