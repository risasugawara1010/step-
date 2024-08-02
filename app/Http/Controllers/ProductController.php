<?php


namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;
use Exception;

class ProductController extends Controller
{
    
    public function index(Request $request)
    {
        $query = Product::query();
        $companies = Company::all();

        $keyword = $request->input('keyword');
        $companyId = $request->input('company_id');

        if (!empty($keyword)) {
            $products->where('name', 'LIKE', "%{$keyword}%")
                    ->orWhere('comment', 'LIKE', "%{$keyword}%");
        }

        if (!empty($companyId)) {
            $companies->where('company_id', $companyId);
        }


        $products = $query->paginate(10);
        
        
        return view('products.index', ['products' => $products,'companies' => $companies,]);
        

    }

    public function create()
    {
        
        $companies = Company::all();
        $products = Product::all();

        return view('products.create', compact('companies'));
    }

    
    public function store(ProductRequest $request)
    {
        $product = new Product();
            $image = $request->file('image');
            $image_path = null;
            
            if($request->hasFile('img_path')){ 
                $filename = $request->img_path->getClientOriginalName();
                $filePath = $request->img_path->storeAs('products', $filename, 'public');
                $product->img_path = '/storage/' . $filePath;
            }

            DB::beginTransaction();
        try {
            $model = new Product();
            $model->registerProduct($request, $image_path);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::debug($e->getMessage());
            return back();
        }

        $product->save();

        return redirect(route('products.index'));

    }

    public function show(Product $product)
    {
    
        return view('products.show', ['product' => $product]);
    
    }



    public function edit(Product $product)
    {
        $companies = Company::all();

        return view('products.edit', compact('product', 'companies'));
    }
    
    public function update(Request $request, Product $product) {
        try {
            
            $request -> validate([
                'product_name' => 'required',
                'price' => 'required',
                'stock' => 'required',
            ]);

            $product -> product_name = $request -> product_name;
            $product -> company_id = $request -> company_id;
            $product -> price = $request -> price;
            $product -> stock = $request -> stock;
            $product -> comment = $request -> comment;

            if ($request -> hasFile('img_path')) {
                $file_name = $request -> img_path -> getClientOriginalName();
                $file_path = $request -> img_path -> storeAs('products', $file_name, 'public');
                $product -> img_path = '/storage/' . $file_path;
            }

            
            $product -> save();

            return redirect() -> route('products.index') -> with('success', 'Product updated successfully');

        } catch (Exception $e) {
            Log::debug($e->getMessage());
        }
    }

    

    public function destroy($id)
    {
        
        try {

            $product = Product::find($id);
            $product->delete();

        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            
        }


        return redirect(route('products.index'));
    }
    
    
     
}
