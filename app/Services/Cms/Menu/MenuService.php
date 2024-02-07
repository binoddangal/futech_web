<?php

namespace App\Services\Cms\Menu;

use App\Http\Resources\Cms\Menu\MenuResource;
use App\Models\Cms\Menu\Menu;
use App\Services\Service;

class MenuService extends Service
{
    protected $menu;
    protected $uploadPath = "uploads/menu";


    public function __construct(Menu $menu)
    {
        $this->menu = $menu;
    }

    public function paginate($data, $limit = 25)
    {
        $menu = $this->menu->orderBy('id', "DESC")->where(function ($qry)use($data){
            if (isset($data['active']) && !empty($data['active'])){
                $flag = $data['active'] =="active"?1:0;
                $qry->whereIsActive($flag);
            }
        })
            ->paginate($limit);
        return MenuResource::collection($menu);
    }

    public function paginateFront($limit = 25)
    {
        $menu = $this->menu->orderBy('id', "DESC")->whereIsActive(1)->paginate($limit);
        return MenuResource::collection($menu);
    }


    public function getByType($type, $limit)
    {
        $news = $this->menu->whereType($type)->orderBy('id', "DESC")->paginate($limit);
        return MenuResource::collection($news);
    }

    public function store($data)
    {
        try {
            $data['is_active'] = (isset($data['is_active']) && $data['is_active'] == true) ? true : 0;
            return $this->menu->create($data);
        } catch
        (\Exception $ex) {
            return false;
        }
    }

    public function getById($id, $resource = false)
    {
        $menu = $this->menu->find($id);
        if(!empty($menu)) {
            return  $resource ? new MenuResource($menu) : $menu;
        }
        return null;
    }

    public function update($id, $data)
    {
        try {
            $menu = $this->getById($id);
            $data['is_active'] = (isset($data['is_active']) && $data['is_active'] == "1") ? 1 : 0;
            return $menu->update($data);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    public function delete($id)
    {
        try {
            $menu = $this->getById($id);
            return $menu->delete();
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    public function findByColumn($column, $value)
    {
        return $this->menu->where($column, $value)->first();
    }

    public function findAllByColumn($column, $value)
    {
        return $this->menu->where($column, $value)->get();
    }

    public function findByColumns($data, $all = false)
    {
        $response = $this->menu->where(function ($query) use ($data) {
            if (sizeof($data) > 0) {
                foreach ($data as $k => $v) {
                    $query->where($k, $data[$k]);
                }
            }
        });
        if ($all) {
            return MenuResource::collection($response->get());
        } else {
            $response = $response->first();
            if (empty($response))
                return null;
            return new MenuResource($response);
        }
    }


}
