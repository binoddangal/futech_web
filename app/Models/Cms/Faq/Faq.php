<?php

namespace App\Models\Cms\Faq;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    use HasFactory, SoftDeletes, Loggable;

    protected $fillable = [
        'title',
        'is_parent',
        'parent_id',
        'short_description',
        'tags',
        'description',
        'position',
        'is_active',
    ];

    public function  children(){
       return $this->hasMany(Faq::class,'parent_id');
    }
    public function  parent(){
        return $this->belongsTo(Faq::class,'parent_id');
    }


}
