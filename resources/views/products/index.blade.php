@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">商品一覧画面</h1>


    <div class="products mt-5">
    <div class="search mt-5">
    
    
    <!-- <form action="{{ route('products.index') }}" method="GET" class="row g-3"> -->
    <form id="search-form" method="GET" action="{{ route('products.search') }}" class="row g-3">
        
        <div class="col-sm-12 col-md-3">
        <input type="text" name="search" class="form-control" placeholder="商品名" value="{{ old('search', request()->input('search', '')) }}">
        </div>

        
        <div class="col-sm-12 col-md-3">
        <select class="form-select" id="company_id" name="company_id">
            <option value="">メーカー名</option>
            @foreach($companies as $company)
            <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>{{ $company->company_name }}</option>
            @endforeach 
        </select>
        </div>

            

    <!-- 最小価格の入力欄 -->
    <div class="col-sm-12 col-md-2">
        <input type="number" name="min_price" class="form-control" placeholder="最小価格" value="{{ request('min_price') }}">
    </div>

    <!-- 最大価格の入力欄 -->
    <div class="col-sm-12 col-md-2">
        <input type="number" name="max_price" class="form-control" placeholder="最大価格" value="{{ request('max_price') }}">
    </div>

    <!-- 最小在庫数の入力欄 -->
    <div class="col-sm-12 col-md-2">
        <input type="number" name="min_stock" class="form-control" placeholder="最小在庫" value="{{ request('min_stock') }}">
    </div>

    <!-- 最大在庫数の入力欄 -->
    <div class="col-sm-12 col-md-2">
        <input type="number" name="max_stock" class="form-control" placeholder="最大在庫" value="{{ request('max_stock') }}">
    </div>

       
        <div class="col-sm-12 col-md-1">
            <button id="search-button" class="btn btn-outline-secondary">検索</button>
        </div>
    
    </form>
</div>



<a href="{{ route('products.index') }}" class="btn btn-success mt-3">検索条件を元に戻す</a>


<div id="product-list">


        <h2>商品情報</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>商品画像</th>
                    <th>商品名</th>
                    <th>価格
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'price', 'direction' => 'asc']) }}">↑</a>
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'price', 'direction' => 'desc']) }}">↓</a>
                    </th>
                    <th>在庫数
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'stock', 'direction' => 'asc']) }}">↑</a>
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'stock', 'direction' => 'desc']) }}">↓</a>
                    </th>
                    <th>メーカー名</th>

                    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">商品新規登録</a>
                </tr>
            </thead>
            <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td><img src="{{ asset($product->img_path) }}" alt="商品画像" width="100"></td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>{{ $product->company->company_name}}</td>
                    
                    
                    </td>
                    <td>
                        <a href="{{ route('products.show', $product) }}" class="btn btn-info btn-sm mx-1">詳細</a>
                        
                        <form method="POST" action="{{ route('products.destroy', $product) }}" class="d-inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm mx-1">削除</button>
                        </form>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    
    {{ $products->appends(request()->query())->links() }} 

    </div>
</div>
@endsection

