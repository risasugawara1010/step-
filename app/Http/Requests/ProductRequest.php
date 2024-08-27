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
            "product_name" => 'required|max:255',
            "company_id" => 'required|exists:companies,id',
            "price" => 'required|integer',
            "stock" => 'required|integer',
            "comment" => 'max:10000',
            "img_path" => 'nullable|mimes:jpg,jpeg,png,gif|max:2048', 
        ];
    }


    /**
     * 項目名
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'product_name' => '商品名',
            'company_id' => 'メーカー名',
            'price' => '価格',
            'stock' => '在庫',
            'comment' => 'コメント',
            'img_path' => '商品画像',
        ];
    }

    /**
     * エラーメッセージ
     *
     * @return array
     */
    public function messages()
    {
        return [
            'product_name.required' => ':attributeは必須項目です。',
            'product_name.max' => ':attributeは:max字以内で入力してください。',
            'company_id.required' => ':attributeは必須項目です。',
            'price.required' => ':attributeは必須項目です。',
            'price.integer' => ':数値を入力してください。',
            'stock.required' => ':attributeは必須項目です。',
            'stock.integer' => ':数値を入力してください。',
            'comment.max' => ':attributeは:max字以内で入力してください。',
            'img_path.mimes' => ':attributeはjpg、jpeg、png、gif形式のみ受け付けます。',
            'img_path.max' => ':attributeは2048KB以下のファイルを選択してください。',
        ];
    }
}