<?php

namespace App\Models\Cms\SiteSetting\PaymentGateway;

use App\Http\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentGatewaySetting extends Model
{
    use HasFactory , SoftDeletes, Loggable;

    protected $uploadPath = 'uploads/payment-gateway-setting';

    protected $fillable =[
        'title',
        'type',
        'merchant_id',
        'public_key',
        'private_key',
        'app_id',
        'app_name',
        'user_name',
        'password',
        'pfx_password',
        'bank_qr_code',
        'description',
        'is_active',

    ];

    protected $appends = ['bank_qr_code_path'];

    public function getBankQrCodePathAttribute()
    {
        if($this->bank_qr_code) {
            return getImagePath($this->uploadPath, $this->bank_qr_code);
        }
        return null;
    }
}
