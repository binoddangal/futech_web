<?php

namespace App\Http\Controllers\Admin\Cms\Menu;

use App\Http\Controllers\Controller;
use App\Services\Cms\Menu\MenuService;
use Illuminate\Http\Request;

class MenuController extends Controller
{

    public $menu;

    public function __construct(MenuService $menu)
    {
        $this->menu = $menu;
    }

    public function indexView()
    {
        return view('admin.cms.menu.index');
    }

    public function index(Request $request)
    {
        return $this->menu->paginate($request->all(), 25);
    }

    public function store(Request $request)
    {
        $menu = $this->menu->store($request->all());
        if ($menu)
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }

    public function update(Request $request, $id)
    {
        $menu = $this->menu->update($id, $request->all());
        if ($menu)
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }

    public function destroy($id)
    {
        if ($this->menu->delete($id))
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }


    public function show($id)
    {
        if ($menu = $this->menu->getById($id))
            return response(['status' => "OK", 'menu' => $menu], 200);
        return response(['status' => 'ERROR'], 500);
    }
}
