<?php

namespace App\Models\User\Address;

use App\Models\Address\District;
use App\Models\Address\Municipality;
use App\Models\Address\Province;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAddress extends Model
{
    use SoftDeletes, Loggable;

    protected $fillable = [
        'user_id',
        'address_line_1',
        'address_line_2',
        'type',
        'province_id',
        'district_id',
        'municipality_id',
        'post_code',
        'ward_no',
    ];

    protected $appends = [
        "full_address"
    ];

    public function getFullAddressAttribute()
    {
        $province = $this->province->title ?? null;
        $district = $this->district->title ?? null;
        $municipality = $this->municipality->title ?? null;
        $address = [$this->address_line_1, $province, $district, $municipality];
        $address = array_filter($address);
        if (sizeof($address) > 0) {
            return implode(", ", $address);
        }
        return null;
    }

    public function province()
    {
       return $this->belongsTo(Province::class, 'province_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function municipality()
    {
        return $this->belongsTo(Municipality::class, 'municipality_id');
    }

}
