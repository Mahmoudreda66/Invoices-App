<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoicesRequest extends FormRequest
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
            'invoice_number' => 'required|max:255',
            'invoice_date' => 'required|date',
            'dve_date' => 'required|date',
            'section' => 'required|numeric',
            'product' => 'required|numeric',
            'collected_money' => 'required|numeric',
            'commission' => 'required|numeric',
            'discount' => 'required|numeric',
            'rate_vat' => 'required|numeric',
            'value_vat' => 'required|numeric',
            'total' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'invoice_number.required' => 'قم بكتابة رقم الفاتورة',
            'invoice_number.max' => 'يجب ألا يزيد رقم الفاتورة عن 255 حرف',
            'invoice_date.required' => 'قم بكتابة تاريخ الفاتورة',
            'invoice_date.date' => 'قم بكتابة تاريخ صالح',
            'dve_date.required' => 'قم بكتابة تاريخ الإستحقاق',
            'dve_date.date' => 'قم بكتابة تاريخ صالح',
            'section.required' => 'قم بإختيار القسم',
            'section.numeric' => 'يجب أن يتكون معرف القسم من أرقام',
            'product.required' => 'قم بإختيار المنتج',
            'product.numeric' => 'يجب أن يتكون معرف المنتج من أرقام',
            'collected_money.required' => 'قم بكتابة مبلغ التحصيل',
            'collected_money.numeric' => 'يجب أن يتكون مبلغ التحصيل من أرقام',
            'commission.required' => 'قم بكتابة العمولة',
            'commission.numeric' => 'يجب أن تتكون العمولة من أرقام',
            'discount.required' => 'قم بكتابة الخصم',
            'discount.numeric' => 'يجب أن يتكون الخصم من أرقام',
            'rate_vat.required' => 'قم بإختيار نسبة الضريبة',
            'rate_vat.numeric' => 'يجب أن تتكون نسبة الضريبة من أرقام',
            'value_vat.required' => 'خطأ في قيمة الضريبة',
            'value_vat.numeric' => 'يجب أن تتكون قيمة الضريبة من أرقام',
            'total.required' => 'خطأ في المبلغ الكلي',
            'total.numeric' => 'يجب ان يتكون المبلغ الكلي من ارقام',
        ];
    }
}