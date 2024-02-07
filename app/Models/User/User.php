<?php

namespace App\Models\User;

use App\Models\User\Address\UserAddress;
use App\Models\User\Setting\UserSetting;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $uploadPath = "uploads/user";

    protected $fillable = [
        'title',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'date_of_birth',
        'unique_identifier',
        'email',
        'email_verified_at',
        'password',
        'phone',
        'mobile',
        'work_phone',
        'account_type',
        'user_type',
        'is_mfa_enabled',
        'is_email_authentication_enabled',
        'mfa_secret_code',
        'mfa_authentication_image',
        'is_login_verified',
        'status',
        'approved_by',
        'remarks',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'mfa_secret_code',
        'mfa_authentication_image',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
       'full_name', 'gender_text', 'is_profile_complete', 'account_type_text', 'user_type_text'
    ];

    function getFullNameAttribute(): string
    {
        $nameArr = [];
        $nameArr[] = ucfirst($this->first_name);
        $nameArr[] = ucfirst($this->last_name);

        return implode(' ', $nameArr);
    }

    function getGenderTextAttribute()
    {
        if ($this->gender) {
            return ucwords(str_replace('_', ' ', $this->gender));
        }
        return null;
    }

    function getAccountTypeTextAttribute()
    {
        if ($this->account_type) {
            return ucwords(str_replace('_', ' ', $this->account_type));
        }
        return null;
    }

    function getUserTypeTextAttribute()
    {
        if ($this->user_type) {
            return ucwords(str_replace('_', ' ', $this->user_type));
        }
        return null;
    }

    function setting()
    {
        return $this->hasOne(UserSetting::class,'user_id');
    }

    function getIsProfileCompleteAttribute()
    {
        $accountType = $this->account_type;
        if($accountType=='volunteer')
        {
            return true;
        }
        if($accountType=='beneficiary')
        {
            return (!empty($this->setting->application_document) && !empty($this->setting->agreement_document) && $this->status=='approved');
        }
        if($accountType=='pharmaceutical_company')
        {
            return  !empty($this->setting->agreement_document) && $this->status=='approved';
        }

        if($accountType=='funding_organisation')
        {
            return  !empty($this->setting->agreement_document) && $this->status=='approved';
        }
    }

    public function permanent_address()
    {
        return $this->hasOne(UserAddress::class, 'user_id')->whereType('permanent');
    }

    public function temporary_address()
    {
        return $this->hasOne(UserAddress::class, 'user_id')->whereType('temporary');
    }
}
