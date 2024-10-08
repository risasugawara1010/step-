@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">商品一覧画面</h1>

    <div class="search mt-5">
    
    
    
      <form action="{{ route('products.index') }}" method="GET" class="row g-3">
        @csrf

        <div class="col-sm-12 col-md-3">
              <input type="text" name="keyword" class="form-control" placeholder="商品名" value="{{ request('keyword') }}">
        </div>

        <div class="mb-3">
             <select class="form-select" id="company_id" name="company_id">
                 <option value="">全てのメーカー名</option>
                  @foreach($companies as $company)
                 <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                  @endforeach
             </select>
        </div>
        
                
         <div class="col-sm-12 col-md-1">
             <button class="btn btn-outline-secondary" type="submit">検索</button>
         </div>
      </form>
    </div>

</div>


   

    <div class="products mt-5">
        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>商品画像</th>
                    <th>商品名</th>
                    <th>価格</th>
                    <th>在庫数</th>
                    <th>メーカー名</th>
                    
                    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">商品新規登録</a>
                    
                </tr>
            </thead>
            <tbody>

            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td><img src="{{ asset($product->img_path) }}" alt="商品画像" width="100"></td>
                    </td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>{{ $product->company->company_name }}</td>
                    
                    <td>
                        <a href="{{ route('products.show', $product) }}" class="btn btn-info btn-sm mx-1">詳細</a>
                        <form method="POST" action="{{ route('products.destroy', $product) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm mx-1" onclick="return confirm('本当に削除しますか？')">削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{ $products->appends(request()->query())->links() }}
</div>
@endsection
