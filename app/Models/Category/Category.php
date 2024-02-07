<?php

namespace App\Models\Category;

use App\Http\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes, Loggable;

    protected $fillable = [
        'title',
        'description',
        'is_active',
    ];
}
