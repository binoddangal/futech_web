<?php

namespace App\Http\Requests\Cms\Slider;

use Illuminate\Foundation\Http\FormRequest;
use function PHPUnit\Framework\stringContains;

class SliderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $request = [
            "title" => "required",
            "image" => "required"
        ];
        if (stringContains(request()->url(), "update"))
            unset($request['image']);
        return $request;

    }
}
