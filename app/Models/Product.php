<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'price',
        'stock',
        'company_id',
        'comment',
        'img_path',
    ];

    public function registerProduct($data, $image_path) {
        // 登録処理
        DB::table('products')->insert([
            'product_name' => $data->product_name,
            'price' => $data->price,
            'stock' => $data->stock,
            'company_id' => $data->company_id,
            'comment' => $data->comment,
            'img_path' => $data->img_path,
        ]);
    }

    public function updateProduct($id, $request, $image_path)
    {

        $product = Product::find($id)->fill([
            'product_name' => $request->product_name,
            'company_id' => $request->company,
            'price' => $request->price,
            'stock' => $request->stock,
            'comment' => $request->text,
            'img_path'  => $image_path,
        ])
            ->save();
    }


    public function sales()
    {
        return $this->hasMany(Sale::class);
    }


    public function company()
    {
        return $this->belongsTo(Company::class);
    }

}
