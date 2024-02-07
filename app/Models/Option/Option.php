<?php

namespace App\Models\Option;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Option extends Model
{
    use SoftDeletes, Loggable;
    protected $fillable = ['name','type','value','is_active', 'data_type'];
}
