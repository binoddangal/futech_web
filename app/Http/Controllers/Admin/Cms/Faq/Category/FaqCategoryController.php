<?php

namespace App\Http\Controllers\Admin\Cms\Faq\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cms\Faq\Category\FaqCategoryRequest;
use App\Http\Resources\Cms\Faq\Category\FaqCategoryResource;
use App\Services\Cms\Faq\Category\FaqCategoryService;
use Illuminate\Http\Request;

class FaqCategoryController extends Controller
{
    protected $faqCategory;

    function __construct(FaqCategoryService $faqCategory)
    {
        $this->faqCategory = $faqCategory;
    }

    public function indexView()
    {
        return view('admin.cms.faq.category.index');
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        return $this->faqCategory->paginate(20, $request, $user);
    }

    public function all()
    {
        $faqCategory = $this->faqCategory->all();
        return response(['faqCategories' => $faqCategory]);
    }

    public function sort(Request $request){
        if ($this->faqCategory->sort($request->all())) {
            return response(['status' => "OK"], 200);
        }
        return response(['status' => 'ERROR' ], 200);
    }

    public function getParent()
    {
        $faqCategory = $this->faqCategory->getParent();
        return $faqCategory;
    }

    public function store(FaqCategoryRequest $request)
    {
        $user = auth()->user();
        if ($this->faqCategory->store($request->all(), $user)) {
            return response(['status' => "OK"], 200);
        }
        return response(['status' => 'ERROR' ], 200);

    }

    public function show($id)
    {
        if ($faqCategory = $this->faqCategory->find($id))
            return response(['status' => "OK" ,'faqCategory' => new FaqCategoryResource($faqCategory)], 200);
        return response(['status' => 'ERROR'], 200);
    }

    public function update(FaqCategoryRequest $request, $id)
    {
        $user = auth()->user();
        $faqCategory = $this->faqCategory->update($id, $request->all(), $user);
        if ($faqCategory)
            return response(['status' => "OK", "faqCategory" => $faqCategory], 200);

        return response(['status' => 'ERROR' ], 200);
    }

    public function destroy($id)
    {
        if ($this->faqCategory->delete($id)) {
            return response(['status' => "OK"], 200);
        }
        return response(['status' => 'ERROR' ], 200);

    }
}
