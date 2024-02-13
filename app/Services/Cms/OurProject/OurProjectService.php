<?php

namespace App\Services\Cms\OurProject;

use App\Http\Resources\Cms\OurProject\OurProjectResource;
use App\Models\Cms\OurProject\OurProject;
use App\Services\Service;

class OurProjectService extends Service
{
    protected $ourProject;
    protected $uploadPath = "uploads/our-project";

    public function __construct(OurProject $ourProject)
    {
        $this->ourProject = $ourProject;
    }

    public function paginate($limit = 25, $request)
    {
        $ourProjects = $this->ourProject->where(function ($query) use ($request) {
            if ($request->filled('title'))
                $query->where('title', 'like', '%' . $request->title . '%');

            if ($request->filled('is_active')) {
                $query->whereIsActive($request->is_active);
            }
        })->paginate($limit);

        return OurProjectResource::collection($ourProjects);
    }

    public function getBySlug($slug)
    {
        return $this->ourProject->whereSlug($slug)->whereIsActive(1)->first();
    }

    public function frontPaginate($limit = 25)
    {
        $album = $this->ourProject->orderBy('id', "DESC")->whereIsActive(1)
            ->paginate($limit);
        return OurProjectResource::collection($album);
    }

    public function getByType($type, $limit)
    {
        $news = $this->ourProject->whereType($type)->orderBy('id', "DESC")->paginate($limit);
        return OurProjectResource::collection($news);
    }

    public function store($data)
    {
        try {
        if (!empty($data['file'])) {
            $data['featured_photo'] = $this->upload($data['file'], $this->uploadPath);
        }
        return $this->ourProject->create($data);
           } catch
           (\Exception $ex) {
               return false;
           }
    }


    public function find($ourProject_id)
    {
        $ourProject = $this->ourProject->find($ourProject_id);
        if (!empty($ourProject))
            return $ourProject;
        return null;
    }

    public function update($id, $data)
    {
        // try {
        $ourProject = $this->find($id);
        if (!empty($data['file'])) {
            if (!empty($ourProject->featured_photo)) {
                $this->deleteFile($this->uploadPath, $ourProject->featured_photo);
            }
            $data['featured_photo'] = $this->upload($data['file'], $this->uploadPath);
        }
        // $data['is_active'] = (isset($data['is_active']) && $data['is_active'] == "1") ? 1 : 0;

        return $ourProject->update($data);;
        // } catch (\Exception $ex) {
        //     return false;
        // }
    }

    public function delete($id)
    {
        try {
            $ourProject = $this->find($id);
            if (!empty($ourProject->featured_photo)) {
                $this->deleteFile($this->uploadPath, $ourProject->featured_photo);
            }
            return $ourProject->delete();
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function findByColumn($column, $value)
    {
        return $this->ourProject->where($column, $value)->first();
    }


    public function findByColumns($data = null, $limit = 0)
    {
        $result = $this->ourProject->where(function ($query) use ($data) {
            foreach ($data as $key => $value) {
                $query->where($key, $data[$key]);
            }
        });
        if (!empty($limit) || $limit != 0) {
            $result = $result->take($limit);
            return OurProjectResource::collection($result);
        } else {
            return new OurProjectResource($result);
        }
    }

    public function getAllActive()
    {
        $project = $this->ourProject->whereIsActive(1)->get();
        return  OurProjectResource::collection($project);
    }
}
