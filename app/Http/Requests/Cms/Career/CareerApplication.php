<?php

namespace App\Http\Requests\Cms\Career;

use Illuminate\Foundation\Http\FormRequest;

class CareerApplication extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "first_name" => "required",
            "last_name" => "required",
            "email" => "required",
            "phone" => "required",
            "file" => "required",
            'g-recaptcha-response' => 'required|captcha'
        ];
    }
}
