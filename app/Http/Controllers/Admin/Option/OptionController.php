<?php

namespace App\Http\Controllers\Admin\Option;

use App\Http\Controllers\Controller;
use App\Services\Option\OptionService;

class OptionController extends Controller
{
    protected $option;

    public function __construct(
        OptionService $option
    )
    {
        $this->option = $option;
    }

    public function findByKey($key)
    {
        $option = $this->option->findByColumn('name', $key);
        return response($option);
    }

    public function getOptionByKey($key)
    {
        $option = $this->option->findByColumn('name', $key);
        if (!empty($option))
            return response()->json($option->value);
        return response()->json("No data found");
    }

}
