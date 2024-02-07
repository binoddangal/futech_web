<?php

namespace App\Services\Cms\Menu\Item;

use App\Http\Resources\Cms\Menu\Item\MenuItemResource;
use App\Models\Cms\Menu\Item\MenuItem;
use App\Services\Cms\Menu\MenuService;
use App\Services\Service;
use Illuminate\Support\Facades\Hash;

class MenuItemService extends Service
{
    protected $menuItem;
    protected $menu;
    protected $uploadPath = "uploads/menu";


    public function __construct(MenuService $menuService, MenuItem $menuItem)
    {
        $this->menuItem = $menuItem;
        $this->menu = $menuService;
    }

    public function paginate($menuId ,$data, $limit = 25)
    {
        $menuItem = $this->menuItem->orderBy('position', "DESC")->whereMenuId($menuId)->where(function ($qry)use($data){
            if (isset($data['active']) && !empty($data['active'])){
                $flag = $data['active'] =="active"?1:0;
                $qry->whereIsActive($flag);
            }
        })
            ->paginate($limit);
        return MenuItemResource::collection($menuItem);
    }
    public function getByMenuId($menuId = null)
    {
        $items = $this->menuItem->whereMenuId($menuId)->whereNull('parent_id')->orderBy('position')->whereIsActive(1)
            ->get();
        return MenuItemResource::collection($items);
    }

    public function getMenuItems()
    {
        $footerMenu = $this->menu->findAllByColumn('header', 0)->pluck('id');
        $headerMenu = $this->menu->findByColumn('header', 1);
        $headerItems = MenuItemResource::collection( $this->menuItem->whereMenuId($headerMenu->id)->whereNull('parent_id')->orderBy('position')->whereIsActive(1)->get());
        $footerItems =  MenuItemResource::collection(  $this->menuItem->whereIn('menu_id',$footerMenu)->whereNull('parent_id')->orderBy('position')->whereIsActive(1)->get());
        return [
            "header" => $headerItems,
            "footer" => $footerItems,
        ];

    }
    public function getMenuItemsByMenuId($menuId)
    {
        $menuItems = $this->menuItem->whereMenuId($menuId)->whereNull('parent_id')->orderBy('position')->whereIsActive(1)->get();

       return MenuItemResource::collection($menuItems);

    }

    public function paginateFront($limit = 25)
    {
        $menuItem = $this->menuItem->orderBy('position', "DESC")->whereIsActive(1)->paginate($limit);
        return MenuItemResource::collection($menuItem);
    }
    public function sort(array $data)
    {
        try {
            $data = $this->refactorSortableData($data);
            $temp = [];
            if (sizeof($data) > 0) {
                foreach ($data as $i => $level0) {
                    $level1Nested = $level0['nested'];
                    unset($level0['nested']);
                    $level0['depth'] = $level0['depth'] ?? 0;
                    $level0['position'] = ($i + 1);
                    $level0['parent_id'] = null;
                    array_push($temp, $level0);
                    if (isset($level1Nested) && sizeof($level1Nested) > 0) {
                        foreach ($level1Nested as $ii => $level1) {
                            $level1['parent_id'] = $level0['id'];
                            $level2Nested = $level1['nested'];
                            unset($level1['nested']);
                            $level1['depth'] = $level1['depth'] ?? 0;
                            $level1['position'] = ($ii + 1);
                            array_push($temp, $level1);
                            if (isset($level1Nested) && sizeof($level1Nested) > 0) {
                                foreach ($level2Nested as $iii => $level2) {
                                    $level2['parent_id'] = $level1['id'];
                                    unset($level2['nested']);
                                    $level2['depth'] = $level2['depth'] ?? 0;
                                    $level2['position'] = ($iii + 1);
                                    array_push($temp, $level2);
                                }
                            }
                        }
                    }
                }
            }

            if (sizeof($temp) > 0) {
                foreach ($temp as $item) {
                    $menuItem = $this->getById($item['id']);
                    if (!empty($menuItem))
                        $menuItem->update($item);
                }
            }
            return true;
        } catch
        (\Exception $ex) {
            return $ex;
        }
    }
    public function refactorSortableData($data)
    {

        if (sizeof($data) > 0) {
            foreach ($data as $i => $level0) {
                if (isset($level0['nested']) && sizeof($level0['nested']) > 0) {
                    foreach ($level0['nested'] as $ii => $level1) {
                        if (isset($level1['nested']) && sizeof($level1['nested']) > 0) {
                            foreach ($level1['nested'] as $iii => $level2) {
                                if (isset($level2['nested'])) {
                                    $data[$i]['nested'][$ii]['nested'][$iii]['depth'] = 0;
                                    $data[$i]['nested'][$ii]['depth'] = 1;
                                    $data[$i]['depth'] = 2;

                                }
                            }
                        } else {
                            $data[$i]['nested'][$ii]['depth'] = 0;
                            $data[$i]['depth'] = 1;
                        }
                    }
                } else {
                    $data[$i]['depth'] = 0;
                }
            }
        }
        return $data;
    }

    public function frontPaginate($limit = 25)
    {
        $menuItem = $this->menuItem->orderBy('id', "DESC")->whereIsActive(1)
            ->paginate($limit);
        return MenuItemResource::collection($menuItem);
    }

    public function getByType($type, $limit)
    {
        $news = $this->menuItem->whereType($type)->orderBy('id', "DESC")->paginate($limit);
        return MenuItemResource::collection($news);
    }

    public function getBySlug($slug)
    {
        return $this->menuItem->whereSlug($slug)->first();
    }


    public function store($data)
    {
        try {
            return $this->menuItem->create($data);
        } catch
        (\Exception $ex) {
            return $ex;
        }
    }

    public function getById($id)
    {
        $menuItem = $this->menuItem->whereId($id)->first();
        return new MenuItemResource($menuItem);
    }

    public function update($id, $data)
    {
        try {
            $menuItem = $this->getById($id);
            $data['is_active'] = (isset($data['is_active']) && $data['is_active'] == "1") ? 1 : 0;
            return $menuItem->update($data);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    public function delete($id)
    {
        try {
            $menuItem = $this->getById($id);
            if (!empty($menuItem->cover_image)) {
                $this->deleteFile($this->uploadPath, $menuItem->cover_image);
            }
            return $menuItem->delete();
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function findByColumn($column, $value)
    {
        return $this->menuItem->where($column, $value)->first();
    }

    public function getUserForLogin($email, $password)
    {
        $menuItem = $this->menuItem->whereEmail($email)->first();
        if (empty($menuItem))
            return false;

        if (Hash::check($password, $menuItem->password))
            return $menuItem;

        return false;
    }

    public function findByColumns($data, $all = false)
    {
        $response = $this->menuItem->where(function ($query) use ($data) {
            if (sizeof($data) > 0) {
                foreach ($data as $k => $v) {
                    $query->where($k, $data[$k]);
                }
            }
        });
        if ($all) {
            return MenuItemResource::collection($response->get());
        } else {
            $response = $response->first();
            if (empty($response))
                return null;
            return new MenuItemResource($response);
        }
    }

    public function searchByKey($key, $limit)
    {
        $results = $this->menuItem
            ->where('title', 'like', '%' . $key . '%')
            ->orWhereRaw('FIND_IN_SET(?,tags)', [$key])
            ->take($limit)
            ->whereIsActive(1)
            ->orderBy('id', "DESC")
            ->get();
        $menuItems = [];
        if ($results->count() > 0) {
            foreach ($results as $p) {
                $temp = [
                    'title' => $p->title,
                    'img' => $p->cover_image_path['thumb'],
                    'route' => route('gallery-detail', $p->slug)
                ];
                array_push($menuItems, $temp);
            }
        }
        return $menuItems;
    }
}
