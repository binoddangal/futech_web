<?php

namespace App\Models\AdminUser;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class AdminUser extends Authenticatable
{
    use HasFactory, SoftDeletes, HasApiTokens;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'mobile',
        'phone',
        'username',
        'email',
        'password',
        'address',
        'user_type',
        'is_mfa_enabled',
        'is_email_authentication_enabled',
        'mfa_secret_code',
        'mfa_authentication_image',
        'is_active',
        'last_logged_in',
    ];

    protected $hidden = ['password', 'mfa_secret_code', 'mfa_authentication_image'];

    protected $appends = ['full_name'];

    function getFullNameAttribute()
    {
        if (!empty($this->middle_name))
            return ucfirst($this->first_name . " " . $this->middle_name . " " . $this->last_name);
        else
            return ucfirst($this->first_name . " " . $this->last_name);

    }
}
