<?php

namespace App\Services\User\Setting;

use App\Http\Resources\User\Setting\UserSettingResource;
use App\Models\User\Setting\UserSetting;
use App\Services\Service;

class UserSettingService extends Service
{
    protected $userSetting;

    protected $uploadPath = 'uploads/user/setting';

    public function __construct(UserSetting $userSetting)
    {
        $this->userSetting = $userSetting;
    }

    public function paginate($limit = 25, $request)
    {
        $users = $this->userSetting->where(function ($query) use ($request) {

            if ($request->filled('is_active')) {
                $query->whereIsActive($request->is_active);
            }
        })->orderBy('id', "DESC");

        return UserSettingResource::collection($users->paginate($limit));
    }

    public function createOrUpdate($userId, $data)
    {
       try {
            $userSetting = $this->userSetting->whereUserId($userId)->first();
            if (!empty($userSetting)) {
                if (isset($data['application_document_file']) && file_exists($data['application_document_file'])) {
                    $this->deleteFile($this->uploadPath, $userSetting->application_document);
                    $data['application_document'] = $this->upload($data['application_document_file'], null, null, $this->uploadPath, 'private');
                }

                if (isset($data['cv_file']) && file_exists($data['cv_file'])) {
                    $data['cv'] = $this->upload($data['cv_file'], null, null, $this->uploadPath, 'private');
                }

                if (isset($data['agreement_document_file']) && file_exists($data['agreement_document_file'])) {
                    $this->deleteFile($this->uploadPath, $userSetting->agreement_document);
                    $data['agreement_document'] = $this->upload($data['agreement_document_file'], null, null, $this->uploadPath, 'private');
                }
                return $userSetting->update($data);
            } else {
                $data['user_id'] = $userId;
                if (isset($data['application_document_file']) && file_exists($data['application_document_file'])) {
                    $data['application_document'] = $this->upload($data['application_document_file'], null, null, $this->uploadPath, 'private');
                }

                if (isset($data['cv_file']) && file_exists($data['cv_file'])) {
                    $data['cv'] = $this->upload($data['cv_file'], null, null, $this->uploadPath, 'private');
                }

                if (isset($data['agreement_document_file']) && file_exists($data['agreement_document_file'])) {
                    $data['agreement_document'] = $this->upload($data['agreement_document_file'], null, null, $this->uploadPath, 'private');
                }
                return $this->userSetting->create($data);
            }
        } catch
        (\Exception $ex) {
            return false;
        }
    }

    public function find($userId, $id, $resource = false)
    {
        $userSetting = $this->userSetting->whereUserId($userId)->find($id);
        if (!empty($userSetting)) {
            if($resource)
                return new UserSettingResource($userSetting);
            return $userSetting;
        }

        return null;
    }

    public function findByUserId($userId, $resource = false)
    {
        $userSetting = $this->userSetting->whereUserId($userId)->first();
        if (!empty($userSetting)) {
            if($resource)
                return new UserSettingResource($userSetting);
            return $userSetting;
        }

        return null;
    }

    public function delete($userId, $id)
    {
        try {
            $userSetting = $this->userSetting->find($userId, $id);
            return $userSetting->delete();
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function findByColumn($column, $value)
    {
        return $this->userSetting->where($column, $value)->first();
    }

    public function findByColumns($data = [], $all = false, $resource = true, $limit = 0)
    {
        $result = $this->userSetting->where(function ($query) use ($data) {
            if (sizeof($data) > 0) {
                foreach ($data as $key => $value) {
                    if (!empty($data[$key]))
                        $query->where($key, $data[$key]);
                }
            }
        });
        if ($limit > 0)
            $result = $result->take($limit);
        if ($all) {
            $result = $result->get();
            if ($resource)
                return UserSettingResource::collection($result);
            return $result;
        } else {
            $result = $result->first();
            if ($resource)
                return new UserSettingResource($result);
            return $result;
        }
    }

    public function getOfferUserIds($itemId)
    {
        $userIds = $this->userSetting->whereRaw('FIND_IN_SET(?,offering_item_ids)', $itemId)->get()->pluck('user_id')->toArray();
        return $userIds;
    }
}
