<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'product_name' => 'required | max:255',
            'company_id' => 'required',
            "price" => 'required | integer',
            "stock" => 'required | integer',
            'comment' => 'nullable',
            'img_path' => 'nullable|image|max:2048',
            
        ];
    }

    public function attributes()
{
    return [
        'product_name' => '商品名',
        'company_id' => 'メーカー名',
        'price' => '価格',
        'stock' => '在庫',
        'comment' => 'コメント',
    ];
}

public function messages() {
    return [
        'product_name.required' => ':attributeは必須項目です。',
        'product_name.max' => ':attributeは:max字以内で入力してください。',
        'company_id.required' => ':attributeは必須項目です。',
        'price.required' => ':attributeは必須項目です。',
        'price.integer' => ':数値を入力してください。',
        'stock.required' => ':attributeは必須項目です。',
        'stock.integer' => ':数値を入力してください。',

    ];
}

}