<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
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
        return [
            'title' => 'bail|required|min:4|max:10',
            'slug' => 'bail|required|min:4|max:10',
            // 'description' => 'bail|required|max:10'
        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'Tên danh mục phim không được để trống',
            'title.min' => 'Tên danh mục phim phải lớn hơn 4 và nhỏ hơn 10 ký tự',
            'title.max' => 'Tên danh mục phim phải lớn hơn 4 ký tự và nhỏ hơn 10 ký tự',

            'slug.required' => 'Tên Slug không được để trống',
            'slug.min' => 'Tên Slug phải lớn hơn 4 và nhỏ hơn 10 ký tự',
            'slug.max' => 'Tên Slug phải lớn hơn 4 ký tự và nhỏ hơn 10 ký tự',
            // 'description.required' => ''
        ];
    }
}
