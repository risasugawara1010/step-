<?php


namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\DB;

use Exception;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    
    public function index(Request $request)
    {
        $query = Product::query();
        $companies = Company::all();

        $keyword = $request->input('keyword');
        $companyId = $request->input('company_id');

        if (!empty($keyword)) {
            $query->where('product_name', 'LIKE', "%{$keyword}%");
        }
    
    
        if (!empty($companyId)) {
            $query->where('company_id', $companyId);
        }

        $products = $query->paginate(10);
        
        
        return view('products.index', [
            'products' => $products,
            'companies' => $companies,
            'keyword' => $keyword,
            'companyId' => $companyId
        ]);
        

    }

    public function create()
    {
        
        $companies = Company::all();
        $products = Product::all();

        return view('products.create', compact('companies'));
    }

    
    public function store(ProductRequest $request)
    {
        $product = new Product([
            'product_name' => $request->get('product_name'),
            'company_id' => $request->get('company_id'),
            'price' => $request->get('price'),
            'stock' => $request->get('stock'),
            'comment' => $request->get('comment'),
        ]);

        if($request->hasFile('img_path')){ 
            $filename = $request->img_path->getClientOriginalName();
            $filePath = $request->img_path->storeAs('products', $filename, 'public');
            $product->img_path = '/storage/' . $filePath;
        }

        DB::beginTransaction();

        try {
            $product->save();

            DB::commit();
            session()->flash('success', '製品が正常に作成されました。');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['エラーが発生しました。製品の作成に失敗しました。']);
        
        }

        return redirect('products');
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
    
    public function update(ProductRequest $request, Product $product) {

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


        DB::beginTransaction();
        try {
            
            $product -> save();

            return redirect() -> route('products.index') -> with('success', 'Product updated successfully');
            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            return back();
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
