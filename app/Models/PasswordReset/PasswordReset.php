<?php

namespace App\Models\PasswordReset;

use App\Http\Traits\Loggable;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use HasFactory, Loggable;

    protected $fillable = ['email', 'token'];

    function user() {
        return $this->belongsTo(User::class,'email','email');
    }
}
