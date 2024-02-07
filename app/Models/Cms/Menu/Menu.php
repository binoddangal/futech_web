<?php

namespace App\Models\Cms\Menu;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory, SoftDeletes, Loggable;
//    protected $uploadPath = "uploads/album";

    protected $fillable = [
        'title',
        'menu_type',
        'header',
        'is_active',
    ];

}
