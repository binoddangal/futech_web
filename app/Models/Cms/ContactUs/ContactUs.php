<?php

namespace App\Models\Cms\ContactUs;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactUs extends Model
{
    use HasFactory, SoftDeletes, Loggable;

    protected $fillable = [
        'type',
        'download_id',
        'first_name',
        'last_name',
        'phone',
        'email',
        'subject',
        'message',
        'is_read',
        'replied',
        'is_active',
    ];

}
