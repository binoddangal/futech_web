<?php

namespace App\Services\Cms\SiteSetting;

use App\Http\Resources\Cms\SiteSetting\ColorSettingResource;
use App\Http\Resources\Cms\SiteSetting\SiteSettingResource;
use App\Mail\SiteSetting\SMTPTestEmail;
use App\Models\Cms\SiteSetting\SiteSetting;
use App\Services\Service;
use Illuminate\Support\Facades\Mail;

class SiteSettingService extends Service
{
    protected $setting;
    public $uploadPath = 'uploads/setting';

    public function __construct(SiteSetting $setting)
    {
        $this->setting = $setting;
    }

    public function store($data)
    {
//        try {
            $data['is_active'] = (isset($data['is_active']) && $data['is_active'] == true) ? true : 0;
            $data['enable_cookies'] = (isset($data['enable_cookies']) && $data['enable_cookies'] == true) ? true : 0;
            $setting = $this->getSetting();
            if (!empty($data['logo'])) {
                $data['logo'] = $this->upload($data['logo'], null, null, $this->uploadPath);
            }
            if (!empty($data['app_logo'])) {
                $data['app_logo'] = $this->upload($data['app_logo'], null, null, $this->uploadPath);
            }
            if (!empty($data['principal_signature'])) {
                $data['principal_signature'] = $this->upload($data['principal_signature'], null, null, $this->uploadPath);
            }
            if (!empty($data['fav_icon'])) {
                $data['fav_icon'] = $this->upload($data['fav_icon'], null, null, $this->uploadPath);
            }
            if (!empty($data['login_bg_image'])) {
                $data['login_bg_image'] = $this->upload($data['login_bg_image'], null, null, $this->uploadPath);
            }
            if (!empty($data['email_logo_image_file'])) {
                $data['email_logo_image'] = $this->upload($data['email_logo_image_file'], null, null, $this->uploadPath);
            }
            if (!empty($setting))
                return $setting->update($data);
            else
                return $this->setting->create($data);
//        } catch
//        (\Exception $ex) {
//            return false;
//        }
    }
    public function all()
    {
        $setting = $this->setting->get();
        return SiteSettingResource::collection($setting);
    }


    public function getSetting()
    {
        $setting = $this->setting->first();

        if (!empty($setting))
            return new SiteSettingResource($setting);
        return null;
    }
    public function getSettingColors()
    {
        $setting = $this->setting->first();

        if (!empty($setting))
            return new ColorSettingResource($setting);
        return null;
    }

    public function update($id, $data)
    {
//        try {
            $data['is_active'] = (isset($data['is_active']) && $data['is_active'] == true) ? true : 0;
            $data['enable_cookies'] = (isset($data['enable_cookies']) && $data['enable_cookies'] == true) ? true : 0;
            $setting = $this->getSetting();
            if (!empty($data['logo_file'])) {
                if (!empty($setting->logo)) {
                    $this->deleteFile($this->uploadPath, $setting->logo);
                }
                $data['logo'] = $this->upload($data['logo_file'], null, null, $this->uploadPath);
            }
            if (!empty($data['app_logo_file'])) {
                if (!empty($setting->app_logo)) {
                    $this->deleteFile($this->uploadPath, $setting->app_logo);
                }
                $data['app_logo'] = $this->upload($data['app_logo_file'], null, null, $this->uploadPath);
            }
            if (!empty($data['footer_logo_file'])) {
                if (!empty($setting->footer_logo)) {
                    $this->deleteFile($this->uploadPath, $setting->footer_logo);
                }
                $data['footer_logo'] = $this->upload($data['footer_logo_file'], null, null, $this->uploadPath);
            }

            if (!empty($data['fav_icon_file'])) {
                if (!empty($setting->fav_icon)) {
                    $this->deleteFile($this->uploadPath, $setting->fav_icon);
                }
                $data['fav_icon'] = $this->upload($data['fav_icon_file'], null, null, $this->uploadPath);
            }
            if (!empty($data['login_bg_image_file'])) {
                if (!empty($setting->login_bg_image)) {
                    $this->deleteFile($this->uploadPath, $setting->login_bg_image);
                }
                $data['login_bg_image'] = $this->upload($data['login_bg_image_file'], null, null, $this->uploadPath);
            }
            if (!empty($data['email_logo_image_file'])) {
                if (!empty($setting->email_logo_image)) {
                    $this->deleteFile($this->uploadPath, $setting->email_logo_image);
                }
                $data['email_logo_image'] = $this->upload($data['email_logo_image_file'], null, null, $this->uploadPath);
            }
            return $setting->update($data);
//        } catch (\Exception $ex) {
//            return false;
//        }
    }

    public function delete($id)
    {
        try {
            $setting = $this->getSetting($id);
            return $setting->delete();
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function findByColumn($column, $value)
    {
        return $this->setting->where($column, $value)->first();
    }

    public function testAwsUpload($file)
    {
        $uploadPath = 'uploads/test';
        $data = $this->upload($file, null, null, $uploadPath);
        $path = $uploadPath . "/" . $data;
        if (env('APP_ENV')!="production")
            $path = "local/".$path;
        $url = s3_image_url($path);
        return $url;
    }

    public function testS3($type = "files")
    {
        return ($this->listFilesAndFolder($type));
    }

    public function sendTestEmail($email){
        setSMTP();
         Mail::to($email)->send(new SMTPTestEmail());
         return true;
    }
}
