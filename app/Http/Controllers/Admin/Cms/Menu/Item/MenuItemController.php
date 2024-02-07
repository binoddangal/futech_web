<?php

namespace App\Http\Controllers\Admin\Cms\Menu\Item;

use App\Http\Controllers\Controller;
use App\Services\Cms\Menu\Item\MenuItemService;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{

    public $menuItemItem;

    public function __construct(MenuItemService $menuItemItem)
    {
        $this->menuItem = $menuItemItem;
    }

    public function index()
    {
        return $this->menuItem->getMenuItems();
    }

    public function indexView($menu_id)
    {
        return view('admin.cms.menu.item.index', compact('menu_id'));
    }

    public function store(Request $request)
    {
        $menuItemItem = $this->menuItem->store($request->all());
        if ($menuItemItem)
            return response(['status' => $menuItemItem], 200);
        return response(['status' => 'ERROR'], 500);
    }

    public function sort($menu_id, Request $request)
    {
        $value = $this->menuItem->sort( $menu_id,$request->all());
        if ($value)
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }

    public function update(Request $request, $id)
    {
        $menuItemItem = $this->menuItem->update($id, $request->all());
        if ($menuItemItem)
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }

    public function destroy($id)
    {
        if ($this->menuItem->delete($id))
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }

    public function show($id)
    {
        if ($menuItemItem = $this->menuItem->getById($id))
            return response(['status' => "OK", 'menuItem' => $menuItemItem], 200);
        return response(['status' => 'ERROR'], 500);
    }

    public function getMenuItemsByMenuId($id)
    {
        if ($menuItemItem = $this->menuItem->getMenuItemsByMenuId($id))
            return response(['status' => "OK", 'menuItem' => $menuItemItem], 200);
        return response(['status' => 'ERROR'], 500);
    }
}
