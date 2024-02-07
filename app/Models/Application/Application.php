<?php

namespace App\Models\Application;

use App\Http\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use HasFactory, SoftDeletes, Loggable;

    protected $uploadPath = "uploads/application";

    protected $fillable = [
        'idea_title',
        'season_id',
        'working_summary',
        'background',
        'project_identification',
        'previous_history_and_current_scenario',
        'idea_breif_description',
        'opporttunities_and_challenges',
        'idea_work_plan',
        'additional_file_one',
        'additional_file_two',
        'additional_file_three',
        'additional_file_four',
        'additional_file_five',
    ];

}
