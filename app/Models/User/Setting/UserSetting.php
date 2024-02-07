<?php

namespace App\Models\User\Setting;

use App\Http\Traits\Loggable;
use App\Models\Category\Category;
use App\Models\Category\SubCategory\Item\Item;
use App\Models\Category\SubCategory\SubCategory;

;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSetting extends Model
{
    use HasFactory, SoftDeletes, Loggable;

    protected $uploadPath = 'uploads/user/setting';

    protected $fillable = [
        'user_id',
        'blood_group',
        'education',
        'experience',
        'cv',
        'default_address_id',
        'org_name',
        'org_contact_name',
        'org_email',
        'org_address_id',
        'application_document',
        'agreement_document',
        'agreement_signed',
        'agreement_signed_date',
        'offering_category_ids',
        'offering_sub_category_ids',
        'offering_item_ids',
    ];

    protected $appends = [
        'application_document_path',
        'agreement_document_path',
        'cv_file_path',
        'offering_categories',
        'offering_sub_categories',
        'offering_items',
    ];

    public function getApplicationDocumentPathAttribute()
    {
        $imagePath = [];
        if (!empty($this->application_document)) {
            $imagePath = getImagePath($this->uploadPath, $this->application_document, true);
        }
        return $imagePath;
    }

    public function getCvFilePathAttribute()
    {
        $imagePath = [];
        if (!empty($this->cv)) {
            $imagePath = getImagePath($this->uploadPath, $this->cv);
        }
        return $imagePath;
    }

    public function getAgreementDocumentPathAttribute()
    {
        $imagePath = [];
        if (!empty($this->agreement_document)) {
            $imagePath = getImagePath($this->uploadPath, $this->agreement_document, true);
        }
        return $imagePath;
    }

    public function getOfferingCategoriesAttribute()
    {
        $offering_categories = [];
        if (!empty($this->offering_category_ids)) {
            $offering_category_ids = explode(',', $this->offering_category_ids);
            $offering_categories = Category::whereIsActive(1)->whereIn('id', $offering_category_ids)->get();
        }
        return $offering_categories;
    }

    public function getOfferingSubCategoriesAttribute()
    {
        $offering_sub_categories = [];
        if (!empty($this->offering_sub_category_ids)) {
            $offering_sub_category_ids = explode(',', $this->offering_sub_category_ids);
            $offering_sub_categories = SubCategory::whereIsActive(1)->whereIn('id', $offering_sub_category_ids)->get();
        }
        return $offering_sub_categories;
    }

    public function getOfferingItemsAttribute()
    {
        $offering_items = [];
        if (!empty($this->offering_item_ids)) {
            $offering_item_ids = explode(',', $this->offering_item_ids);
            $offering_items = Item::select(['id', 'title', 'category_id', 'sub_category_id', 'is_active'])->whereIsActive(1)->whereIn('id', $offering_item_ids)->get();
        }
        return $offering_items;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function default_address()
    {
        return $this->belongsTo(UserAddress::class,'default_address_id');
    }

    public function funding_org_address()
    {
        return $this->belongsTo(UserAddress::class,'funding_org_address_id');
    }
}
