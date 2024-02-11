<?php

use App\Models\Cms\SiteSetting\SiteSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Nilambar\NepaliDate\NepaliDate;

function formatDate($date, $format = 'd M Y', $default = true)
{

    return date($format, strtotime($date));
}

function formatMonthYear($date, $format = 'M Y', $default = true)
{
    return date($format, strtotime($date));
}

function formatTime($time, $format = "g:i A")
{
    if (!empty($time))
        return \Carbon\Carbon::createFromFormat('H:i:s', $time)->format($format);
    return null;
}

function getRandomString($len): string
{
    $string = "";
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    for ($i = 1; $i <= $len; $i++)
        $string .= substr($chars, rand(0, strlen($chars)), 1);

    return strtoupper($string);
}

function generateUniqueIdentifier()
{
    $random_number = randomNumber();
    if ($random_number) {
        while (true) {
            $uniqueNumber = findByUniqueIidentifier($random_number);
            if (!$uniqueNumber) {
                return $random_number;
            } else {
                $random_number = randomNumber();
            }
        }
    }
}

function getMenuNavigation($menuId)
{
    $menuItems = \App\Models\Cms\Menu\Item\MenuItem::whereMenuId($menuId)->whereNull('parent_id')->orderBy('position', "ASC")->get();
    $menu = '';
    foreach ($menuItems as $menuItem) {
        $menu = $menu . buildMenuItem($menuItem);
    }
    return $menu;
}

function buildMenuItem($menuItem)
{

    //Check if menu has dropdown
    $childMenuItems = \App\Models\Cms\Menu\Item\MenuItem::whereParentId($menuItem->id)->whereNotNull('parent_id')->get();
    if ($childMenuItems->count() > 0) {
        $hasDropdownMenu = true;
    } else {
        $hasDropdownMenu = false;
    }

    //If dropdown menu build with dropdown menu
    if ($hasDropdownMenu) {
        $target = $menuItem->new_tab ? "target='_blank'" : '';
        $currentUrl = getMenuLink($menuItem);
        $checkIfActive = ('/' . \Request::path() == $currentUrl || \Request::path() == $currentUrl) ? 'active' : '';
        $menu = '<div class="parent-menu dropdown inline-block relative rounded-md hover:rounded-md">
                    <a ' . $target . ' class="' . $checkIfActive . ' has-children px-2 py-2 font-roboto text-black cursor-pointer group rounded-md  inline-flex items-center justify-between w-full text-md hover:text-white">
                        <span class="mr-1">' . $menuItem->title . '</span>
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                        </svg>
                    </a>
                    <ul class="dropdown-menu absolute hidden text-gray-700 pt-1 z-40  left-1/2 pt-3 transform -translate-x-1/2  w-auto min-w-100 sm:px-0"
                      >
                            ' . getSubMenuNavigation($menuItem->id) . '
                    </ul>
                </div>';
    } else {
        //Build parent menu without dropdown
        $currentUrl = getMenuLink($menuItem);
        $target = $menuItem->new_tab ? "target='_blank'" : '';
        $checkIfActive = ('/' . \Request::path() == $currentUrl || \Request::path() == $currentUrl) ? 'active' : '';
        $class = 'parent-menu group px-2 py-2 lg:rounded-md  inline-flex items-center font-roboto text-black text-md';
        $menu = '<a ' . $target . ' href="' . $currentUrl . '" class="' . $checkIfActive . ' ' . $class . '"><span>' . $menuItem->title . '</span></a>';
    }
    return $menu;
}

function getSubMenuNavigation($parentId)
{
    //Check if active URL
    $menuItems = \App\Models\Cms\Menu\Item\MenuItem::whereParentId($parentId)->whereNotNull('parent_id')->orderBy('position', 'ASC')->get();
    $item = '';
    foreach ($menuItems as $menuItem) {
        $target = $menuItem->new_tab ? "target='_blank'" : '';
        $currentUrl = getMenuLink($menuItem);
        $checkIfActive = ('/' . \Request::path() == $currentUrl || \Request::path() == $currentUrl) ? 'active' : '';
        $item = $item . '<li class=""><a ' . $target . ' href="' . getMenuLink($menuItem) . '"
                                            class="' . $checkIfActive . ' text-gray-900 -m-3 p-5 p-y-3 block  transition ease-in-out duration-150 bg-white border border-solid border-gray-100 text-xs font-medium whitespace-nowrap">
                                    ' . $menuItem->title . '
                                    <br>
                                </a></li>
                                ';
    }
    return $item;
}

function getMenuLink($item, $link = false)
{
    if ($link == true) {
        return '#';
    }
    if (!empty($item->page_id)) {
        $item->menu_type = 'page';
    }
    if (!empty($item->blog_id)) {
        $item->menu_type = 'blog';
    }
    if (!empty($item->blog_category)) {
        $item->menu_type = 'blog_category';
    }
    $url = url('/') . '/';
    switch ($item->menu_type) {
        case "page":
            return !empty($item->page->slug) ? $url . 'page/' . $item->page->slug : '';
            break;
        case "blog":
            return $url . 'blog/' . $item->blog->slug;
            break;
        case "programs":
            return $url . 'program/' . $item->program->slug;
            break;
        case "news":
            return $url . 'news-and-announcement/' . $item->news->slug;
            break;
        case "event":
            return $url . 'events/' . $item->event->slug;
            break;
        case "downloads":
            return $url . 'download/' . $item->download->path;
            break;
        case "downloads_type":
            return $url . 'downloads/type/' . $item->download_type->slug;
            break;
        case "custom_link":
            return $item->link;
            break;
        default:
            return $item->link;
    }
}

function randomNumber()
{
    $random_number = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTVWXYZ"), 0, 6);
    return $random_number;
}

function findByUniqueIidentifier($user)
{
    $user = \App\Models\User\User::whereUniqueIdentifier($user)->first();
    if (!empty($user))
        return $user;
    return false;
}

function getDateString($date)
{
    return date("Y M d", strtotime($date));
}

function getDateTimeString($date)
{
    return date("Y M d h:m a", strtotime($date));
}

function encryptData($value)
{
    try {
        $hash = new Hashids\Hashids('', 6);
        return $hash->encode($value, 6);
    } catch (\Exception $exception) {
        return $value;
    }
}

function decryptData($value)
{
    try {
        $hash = new Hashids\Hashids('', 6);
        if (env('APP_ENV') == "production")
            return $hash->decode($value);
        return $value;
    } catch (\Exception $exception) {
        return $value;
    }
}


function appendZeroInNumber($value, $noOfDigit = 5)
{
    $zeros = null;
    $length = strlen($value);
    for ($i = 0; $i < ($noOfDigit - $length); $i++) {
        $zeros .= '0';
    }
    return $zeros . $value;
}


function getBase64ImageSize($base64Image)
{
    //return memory size in B, KB, MB
    try {
        $size_in_bytes = (int)(strlen(rtrim($base64Image, '=')) * 3 / 4);
        $size_in_kb = $size_in_bytes / 1024;
        $size_in_mb = $size_in_kb / 1024;
        return $size_in_mb;
    } catch (Exception $e) {
        return $e;
    }
}

function formatPhone($phone)
{
    $format_phone = trim($phone);
    try {
        //dd('here'.substr($format_phone, 1, 1).'phone'.$format_phone);
        if (substr($format_phone, 1, 1) === '4') {
            $first_three = preg_replace('/^\w{4}/', "$0 ", $format_phone);
            $explode = explode(' ', $first_three);
            $last_digit = preg_replace('/^\w{3}/', "$0 ", $explode[1]);
            $formatted_phone = $explode[0] . " " . $last_digit;
        } else if (substr($format_phone, 1, 1) === '0') {
            $first_three = preg_replace('/^\w{2}/', "$0 ", $format_phone);
            $explode = explode(' ', $first_three);
            $last_digit = preg_replace('/^\w{4}/', "$0 ", $explode[1]);
            $formatted_phone = $explode[0] . " " . $last_digit;
        } else {
            $first_three = preg_replace('/^\w{2}/', "$0 ", $format_phone);
            $explode = explode(' ', $first_three);
            $last_digit = preg_replace('/^\w{3}/', "$0 ", $explode[1]);
            $formatted_phone = $explode[0] . " " . $last_digit;
        }
    } catch (Exception $e) {
        return $format_phone;
    }

    return $formatted_phone;
}

function getYears()
{
    $date = Carbon::now()->format('Y');
    $years = [];
    for ($i = 0; $i <= 10; $i++) {
        $years[] = $date + $i;
    }
    return $years;
}

function generateRandomPassword()
{
    return Str::random(10);
}


function getEmailRawTag($tag)
{
    return $tagHTML = config('email-template.tags.' . $tag);
}

function renderEmailHTML($description, $acceptedTags)
{
    if (!empty($acceptedTags)) {
        foreach ($acceptedTags as $tag) {
            $pattern = "/{!-" . $tag . "-!}/i";
            $description = preg_replace($pattern, getEmailRawTag($tag), $description);
        }
    }
    return $description;
}

function renderEmailData($description, $accepted_inputs, $data)
{
    if (!empty($accepted_inputs)) {
        foreach ($accepted_inputs as $input) {
            $pattern = "/{{" . $input . "}}/i";
            $description = preg_replace($pattern, $data[$input], $description);
        }
    }
    return $description;
}

// method for rendering visa application update logs in mail
function renderVisaApplicationLoopData($description, $loopData)
{
    if (!empty($loopData)) {
        $pattern = '{--loop--}';
        if (Str::contains($description, $pattern)) {
            $html = '';
            $html .= '<ul>';
            foreach ($loopData as $key => $loop) {
                $loop = (array)$loop;
                $html .= '<li></b>' . $loop['field'] .
                    ' changed from ' . $loop['original'] .
                    ' to ' . $loop['changed'] . ' </li>';
            }
            $html .= '</ul><hr>';
            $description = str_replace($pattern, $html, $description);
        }
    }
    return $description;
}

function getToken($type)
{
    if ($type == "email") {
        return hash_hmac('sha256', Str::random(40), config('app.key'));
    }
    else {
        return rand(123456, 987654);
    }
}

function getFavIcon()
{

    $site_settings = SiteSetting::first();

    return !empty($site_settings) && !empty($site_settings->fav_icon) ? $site_settings->fav_icon_path['real'] : asset('assets/images/logo/Futech_Logo.png');

}

function getLogo($footer=false)
{
    $site_settings = SiteSetting::first();
    if($footer){
        return !empty($site_settings) && !empty($site_settings->footer_logo) ? $site_settings->footer_logo_path['real'] : asset('assets/images/logo/Futech_LogoWhite.png');
    }
    return !empty($site_settings->logo) ? $site_settings->logo_path['real'] : asset('assets/images/logo/Futech_Logo.png');
}

function getAdminLogo($footer=false)
{
    $site_settings = SiteSetting::first();

    return !empty($site_settings->app_logo) ? $site_settings->app_logo_path['real'] : asset('assets/images/logo/Futech_LogoWhite.png');
}

function getAllLogs($userId, $applicationId = null, $agentId = null)
{
    $logs = Log::whereUserId($userId);
    if ($agentId) {
        $logs = $logs->whereAgentId($agentId);
    }
    if ($applicationId) {
        $logs = $logs->whereTableId($applicationId)->orWhereNull('table_id')->whereIn('table_name', ['applications', 'application_histories']);
    }
    $logs = $logs->orderBy('log_date', 'DESC')->paginate(20);
    return $logs;
}


function getDefaultCustomAndOtherRoles($name)
{
    $newList = [];
    $action = ["list", 'edit', 'create', 'delete', 'show'];
    $permissionList = Config::get('user-role')['permissions'];
    $permissionList = $permissions = config('permission-role.user-role')['permissions'];
    $customList = [];
    $defaultList = [];
    foreach ($permissionList as $permission) {
        $per = collect($action)->map(function ($ele, $key) use ($permission) {
            return $permission . "-" . $ele;
        });
        $newList = array_merge($newList, $per->all());
    }
    $defaultPermissions = $permissions = config('permission-role.role-permission')[$name];
    foreach ($defaultPermissions as $defaultPermission) {
        if (in_array($defaultPermission, $newList)) {
            $defaultList[] = $defaultPermission;
        } else {
            $customList[] = $defaultPermission;
        }
    }
    return [$defaultList, $customList];
}

function getDateBy($filter_by)
{
    $date = [];
    switch ($filter_by) {
        case 'today':
            $date[0] = Carbon::now()->toDateString();
            break;
        case 'this_week':
            $date[0] = Carbon::now()->startOfWeek()->toDateString();
            $date[1] = Carbon::now()->endOfWeek()->toDateString();
            break;
        case 'this_month':
            $date[0] = Carbon::now()->startOfMonth()->toDateString();
            $date[1] = Carbon::now()->endOfMonth()->toDateString();
            break;
        case 'in_three_month':
            $date[0] = Carbon::now()->subMonths(3)->toDateString();
            $date[1] = Carbon::now()->toDateString();
            break;
        case 'in_six_month':
            $date[0] = Carbon::now()->subMonths(6)->toDateString();
            $date[1] = Carbon::now()->toDateString();
            break;
        case 'in_nine_month':
            $date[0] = Carbon::now()->subMonths(9)->toDateString();
            $date[1] = Carbon::now()->toDateString();
            break;
        case 'one_year':
            $date[0] = Carbon::now()->subMonths(12)->toDateString();
            $date[1] = Carbon::now()->toDateString();
            break;
    }
    return $date;
}


function getCurrentYear(){
    return(\Carbon\Carbon::now()->year);
}

function getInvoiceNumber($invoiceId)
{
   return str_pad($invoiceId, 9, '0', STR_PAD_LEFT);
}


/*Email Templates*/
function getEmailTemplate($role, $type)
{
    $template = \App\Models\EmailTemplate\EmailTemplate::whereRole($role)->whereType($type)->whereIsActive(1)->first();
    return $template;
}


function buildTableNameToLogInfoTitle($tableName)
{
    $nameArr = explode('_', $tableName);
    foreach ($nameArr as $key => $name) {
        $nameArr[$key] = Str::singular($name);
    }
    $name = implode(' ', $nameArr);
    return ucwords($name);
}

function changeLogTableColumnName($columnName)
{
    $nameArr = explode('_', $columnName);
    foreach ($nameArr as $key => $name) {
        $nameArr[$key] = Str::singular($name);
    }
    $name = implode(' ', $nameArr);
    return ucfirst($name);
}

function compareLogData($beforeData, $afterData)
{
    $newAfterData = json_decode($afterData);
    unset($newAfterData->updated_at);
    unset($newAfterData->updated_at);
    unset($newAfterData->id);
    unset($newAfterData->user_id);
    unset($newAfterData->created_at);
    unset($newAfterData->remember_token);
    unset($newAfterData->is_login_verified);

    $newBeforeData = json_decode($beforeData);

    $changedData = [];

    foreach ($newAfterData as $key => $data) {
        $obj = new \stdClass();
        $obj->field = changeLogTableColumnName($key);
        $obj->original = $newBeforeData->$key;
        $obj->changed = $data;
        array_push($changedData, $obj);
    }

    return ($changedData);
}

function getSetting()
{
    return SiteSetting::first();
}

function setSMTP()
{
    if(env('APP_ENV') != 'local') {
        $setting = getSetting();
        Config::set('mail.mailers.smtp.driver', $setting->mail_driver);
        Config::set('mail.mailers.smtp.host', $setting->mail_host);
        Config::set('mail.mailers.smtp.port', $setting->mail_port);
        Config::set('mail.mailers.smtp.encryption', $setting->mail_encryption);
        Config::set('mail.mailers.smtp.username', $setting->mail_user_name);
        Config::set('mail.mailers.smtp.password', $setting->mail_password);
    }
}

function getImagePath($uploadPath, $imageName, $signed = true)
{
    $imagePath = [];
    if (empty($imageName))
        return $imagePath;
    if (getStorageType() != "local") {
        $realPath = $uploadPath . "/" . $imageName;
        $thumbPath = $uploadPath . "/thumb/" . $imageName;

        $realPath = buildUploadPathUrl($realPath);
        $thumbPath = buildUploadPathUrl($thumbPath);

        if(checkFileType($imageName) == 'image') {
            $imagePath = [
                "real" => s3_image_url($realPath, $signed),
                "thumb" => s3_image_url($thumbPath, $signed),
            ];
        } else {
            $imagePath = [
                "real" => s3_image_url($realPath, $signed),
            ];
        }

    } else {
        $imagePath = [
            "real" => asset($uploadPath . "/" . $imageName),
            "thumb" => asset($uploadPath . "/thumb/" . $imageName),
        ];
    }
    return $imagePath;
}

function checkForImage($imageName)
{
    $imageType = ['jpeg', 'jpg', 'png', 'JPEG', 'JPG', 'ico'];

    $docType = ['docx', 'doc'];

    $spreadType = ['xls', 'xlsx'];

    $image = explode('.', $imageName);
    if(in_array($image[1], $imageType))
        return "image";

    if (in_array($image[1], $docType)) {
        return "doc";
    }

    if ($image[1] == 'cvs' || $image[1] == 'txt') {
        return "cvs";
    }

    if (in_array($image[1], $spreadType)) {
        return "xls";
    }
    return 'pdf';
}

function checkFileType($imageName)
{
    $imageType = ['jpeg', 'jpg', 'png', 'JPEG', 'JPG', 'ico'];

    $fileType = ['docx', 'doc', 'cvs', 'xls', 'xlsx'];

    $image = explode('.', $imageName);
    if (in_array($image[1], $imageType))
        return "image";

    if (in_array($image[1], $fileType)) {
        return "doc";
    }
    return 'pdf';
}

function s3_image_url($path, $signed = false)
{
    setStorageConfig();
    $storageDisk = getStorageType();
    if($storageDisk) {
        if ($signed) {
            $client = \Illuminate\Support\Facades\Storage::disk($storageDisk)->getClient();
            $command = $client->getCommand('GetObject', [
                'Bucket' => getSetting()->storage_bucket_name,
                'Key' => $path
            ]);
            $request = $client->createPresignedRequest($command, '+10 minutes');

            return (string)$request->getUri();
        } else {
            return \Illuminate\Support\Facades\Storage::disk($storageDisk)->url($path);
        }
    }
}

function setStorageConfig()
{
    if(getStorageType() == 'aws' || getStorageType() == 'wasabi') {
        $setting = SiteSetting::first();
        if($setting->storage_type=='aws')
        {
            Config::set('filesystems.disks.aws.driver', "s3");
            Config::set('filesystems.disks.aws.key', $setting->storage_access_key);
            Config::set('filesystems.disks.aws.secret', $setting->storage_secret_key);
            Config::set('filesystems.disks.aws.region', $setting->storage_region);
            Config::set('filesystems.disks.aws.bucket', $setting->storage_bucket_name);
            Config::set('filesystems.disks.aws.endpoint', 'https://s3.'.$setting->storage_region.'.amazonaws.com');
        }

        if($setting->storage_type=='wasabi')
        {
            Config::set('filesystems.disks.wasabi.driver', "s3");
            Config::set('filesystems.disks.wasabi.key', $setting->storage_access_key);
            Config::set('filesystems.disks.wasabi.secret', $setting->storage_secret_key);
            Config::set('filesystems.disks.wasabi.region', $setting->storage_region);
            Config::set('filesystems.disks.wasabi.bucket', $setting->storage_bucket_name);
            Config::set('filesystems.disks.wasabi.endpoint', 'https://s3.'.$setting->storage_region.'.wasabisys.com');
        }
    }
}

function getStorageType()
{
    $setting = SiteSetting::first();
    return $setting->storage_type;
}

function buildUploadPathUrl($path)
{
    $env = Config::get('app.env');
    if ($env == "production") {
        return $path;
    } else {
        return "local/" . $path;
    }
}

function getHashedPassword($value)
{
    try {
        return (Hash::make($value));
    } catch (\Exception $exception) {
        return $value;
    }
}

function convertDate($date, $option = 'ad')
{
    if (!empty($date)) {
        $date = explode('-', $date);
        $obj = new NepaliDate();
        if (isset($date[0]) && isset($date[1]) && isset($date[2])) {
            if($option == 'ad')
                $newDate = $obj->convertBsToAd($date[0], $date[1], $date[2]);
            else
                $newDate = $obj->convertAdToBs($date[0], $date[1], $date[2]);

            $month = $newDate['month'];
            $day = $newDate['day'];
            if (strlen((string)$month) == 1)
                $month = "0" . $month;
            if (strlen((string)$day) == 1)
                $day = "0" . $day;
            $adDate = $newDate['year'] . '-' . $month . '-' . $day;
            return $adDate;
        }
        return null;
    }
    return null;
}
