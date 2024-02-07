<?php

namespace App\Models\User\Verification;

use App\Http\Traits\Loggable;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserVerification extends Model
{
    use HasFactory,SoftDeletes, Loggable;

    protected $fillable = ['user_id','token', 'verification_code', 'is_used', 'value', 'type'];

    function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
