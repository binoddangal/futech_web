<?php

namespace App\Http\Resources\Cms\SiteSetting;

use Illuminate\Http\Resources\Json\JsonResource;

class SiteSettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $displaySmtpSetting = [
            !empty($this->mail_driver),
            !empty($this->mail_host),
            !empty($this->mail_port),
            !empty($this->mail_user_name),
            !empty($this->mail_password),
            !empty($this->mail_sender_name),
            !empty($this->mail_sender_name)
        ];

        $resource = [
            'id' => $this->id,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'map_url' => $this->map_url,
            'zoom_link' => $this->zoom_link,
            'facebook' => $this->facebook,
            'twitter' => $this->twitter,
            'youtube' => $this->youtube,
            'instagram' => $this->instagram,
            'linkedin' => $this->linkedin,
            'tiktok' => $this->tiktok,
            'pininterest' => $this->pininterest,
            'viber' => $this->viber,
            'whatsapp' => $this->whatsapp,
            'facebook_chat_widgets' => $this->facebook_chat_widgets,
            'google_analytics' => $this->google_analytics,
            'pixels' => $this->pixels,
            'slogan' => $this->slogan,
            'tagline' => $this->tagline,
            'website' => $this->website,
            'date_format' => $this->date_format,
            'address_type' => $this->address_type,
            'enable_cookies' => $this->enable_cookies,
            'cookie_content_text' => $this->cookie_content_text,
            'copy_right_text' => $this->copy_right_text,
            'fav_icon' => $this->fav_icon,
            'logo' => $this->logo,
            'login_bg_image' => $this->login_bg_image,
            'login_bg_color' => $this->login_bg_color,
            'primary_color' => $this->primary_color,
            'secondary_color' => $this->secondary_color,
            'colors_variables' => $this->colors_variables,
            'app_logo' => $this->app_logo,
            'email_logo_image' => $this->email_logo_image,
            'footer_logo' => $this->footer_logo,
            'tax_percentage' => $this->tax_percentage,
            'pan_no' => $this->pan_no,
            'vat_no' => $this->vat_no,
            'fav_icon_path' => $this->fav_icon_path,
            'app_logo_path' => $this->app_logo_path,
            'logo_path' => $this->logo_path,
            'login_bg_path' => $this->login_bg_path,
            'footer_logo_path' => $this->footer_logo_path,
            'display_storage' => !empty($this->storage_type) && ($this->storage_type == "aws" ||  $this->storage_type == "wasabi") ? true : null,
            'email_logo_image' => $this->email_logo_image,
            'email_logo_path' => $this->email_logo_path,
            'display_smtp_setting' => in_array(false, $displaySmtpSetting) ? false : true,
        ];

        return $resource;
    }
}
