<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductsRequest extends FormRequest
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
            'product_name' => 'required|max:255',
            'section_id' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'section_id.numeric' => 'حطأ في معرف القسم',
            'section_id.required' => 'قم بإختيار القسم',
            'product_name.required' => 'قم بكتابة إسم المنتج',
            'product_name.max' => 'يجب ألا يزيد عدد أحرف الإسم عن 255 حرف'
        ];
    }
}
