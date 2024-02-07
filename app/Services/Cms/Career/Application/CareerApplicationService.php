<?php


namespace App\Services\Cms\Career\Application;



use App\Http\Resources\Cms\Career\Application\CareerApplicationResource;
use App\Models\Cms\Career\Application\CareerApplication;
use App\Services\Cms\Career\CareerService;
use App\Services\Service;

class CareerApplicationService extends Service
{
    protected $application;
    protected $career;
    protected $uploadPath = "uploads/career";

    public function __construct(
        CareerApplication $application, CareerService $career
    )
    {
        $this->application = $application;
        $this->career = $career;
    }

    public function paginate($limit = 25,$data=null)
    {
        $application = $this->application->orderBy('id', "DESC")->where(function ($query) use ($data){
            if($data->filled('career_id'))
            {
                $query->whereCareerId($data->career_id);
            }

        })->paginate($limit);
        return CareerApplicationResource::collection($application);
    }

    public function getAllActive()
    {
        $applications = $this->application->orderBy('id', "DESC")->whereIsActive(1)->get();
        return $applications;
    }


    public function store($slug, $data=[])
    {
       try {
        $career = $this->career->findByColumn('slug', $slug);
        $data['career_id'] = $career->id;
        if (!empty($data['file'])) {
            $data['file'] = $this->upload($data['file'], null, null, $this->uploadPath);
        }
        return $this->application->create($data);
       }
       catch
       (\Exception $ex) {
           return false;
       }
    }

    public function getById($id)
    {
        $application = $this->application->find($id);
        if (!empty($application))
            return new CareerApplicationResource($application);
        return null;
    }

    public function update($id, $data)
    {
        try {
            $application = $this->getById($id);
            return $application->update($data);
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $application = $this->getById($id);
            return $application->delete();
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function findByColumn($column, $value)
    {
        return $this->application->where($column, $value)->first();
    }
    public function findByColumns($data, $all = false)
    {
        $response = $this->application->where(function ($query) use ($data) {
            if (sizeof($data) > 0) {
                foreach ($data as $k => $v) {
                    $query->where($k, $data[$k]);
                }
            }
        });
        if ($all) {
            return CareerApplicationResource::collection($response->get());
        } else {
            $response = $response->first();
            if (empty($response))
                return null;
            return new CareerApplicationResource($response);
        }
    }
}
