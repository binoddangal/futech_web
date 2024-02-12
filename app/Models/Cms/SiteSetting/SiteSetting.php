<?php

namespace App\Models\Cms\SiteSetting;

use App\Http\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiteSetting extends Model
{
    use HasFactory, SoftDeletes, Loggable;

    public $uploadPath = 'uploads/setting';
    protected $fillable = [
        'phone',
        'email',
        'vat_number',
        'website',
        'address',
        'whatsapp',
        'viber',
        'pininterest',
        'tiktok',
        'linkedin',
        'instagram',
        'youtube',
        'twitter',
        'facebook',
        'copy_right_text',
        'cookie_content_text',
        'terms_condition',
        'offline_payment_instruction',
        'zoom_link',
        'map_url',
        'tagline',
        'logo',
        'email_logo_image',
        'app_logo',
        'enable_cookies',
        'principal_signature',
        'fav_icon',
        'action_button_text',
        'action_button_link',
        'action_button_link_action',
        'facebook_chat_widgets',
        'google_analytics',
        'pixels',
        'slogan',
        'login_bg_image',
        'login_bg_color',
        'primary_color',
        'secondary_color',
        'storage_type',
        'storage_endpoint',
        'storage_access_key',
        'storage_secret_key',
        'storage_region',
        'storage_bucket_name',
        'storage_url',
        'colors_variables',
        'recaptcha_site_key',
        'recaptcha_secret_key',
        'mail_driver',
        'mail_host',
        'mail_port',
        'mail_user_name',
        'mail_password',
        'mail_encryption',
        'mail_sender_name',
        'mail_sender_address',
        'date_format',
        'enable_level',
        'enable_buildings',
        'tax_percentage',
        'pan_no',
        'vat_no',
        'company_name',
        'address_type',
        'footer_logo'
    ];

    protected $appends = [
        'fav_icon_path', 'app_logo_path', 'logo_path', 'login_bg_path', 'footer_logo_path', 'fb_chat_json_values', 'email_logo_path'
    ];

    public function getFavIconPathAttribute()
    {
        $imagePath = [];
        if (!empty($this->fav_icon)) {
            $imagePath = getImagePath($this->uploadPath, $this->fav_icon);
        }
        return $imagePath;
    }


    public function getFbChatJsonValuesAttribute()
    {
        return json_decode($this->facebook_chat_widgets, true);
    }

    public function getColorsVariablesJsonValuesAttribute()
    {
        return json_decode($this->colors_variables, true);
    }


    public function getLogoPathAttribute()
    {
        $imagePath = [];
        if (!empty($this->logo)) {
            $imagePath = getImagePath($this->uploadPath, $this->logo);
        }
        return $imagePath;
    }

    public function getEmailLogoPathAttribute()
    {
        $imagePath = [];
        if (!empty($this->email_logo_image)) {
            $imagePath = getImagePath($this->uploadPath, $this->email_logo_image);
        }
        return $imagePath;
    }

    public function getFooterLogoPathAttribute()
    {
        $imagePath = [];
        if (!empty($this->footer_logo)) {
            $imagePath = getImagePath($this->uploadPath, $this->footer_logo);
        }
        return $imagePath;
    }

    public function getAppLogoPathAttribute()
    {
        $imagePath = [];
        if (!empty($this->app_logo)) {
            $imagePath = getImagePath($this->uploadPath, $this->app_logo);
        }
        return $imagePath;
    }


    public function getLoginBgPathAttribute()
    {
        $imagePath = [];
        if (!empty($this->login_bg_image)) {
            $imagePath = getImagePath($this->uploadPath, $this->login_bg_image);
        }
        return $imagePath;
    }
}
