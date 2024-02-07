<?php

namespace App\Http\Requests\Cms\Download;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class DownloadRequest extends FormRequest
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
        $req = [
            'title' => 'required',
            "download_type_id" => 'required',
            'path' => 'file'
        ];
        if (Str::contains(request()->url(), 'update')) {
            unset($req['path']);
        }
        return $req;
    }
}
