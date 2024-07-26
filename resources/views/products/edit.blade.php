@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                
                <div class="card">
                    <div class="card-header"><h2>商品情報編集画面</h2></div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <dt class="col-sm-3">ID</dt>
                            <dd class="col-sm-9">{{ $product->id }}</dd>

                            <div class="mb-3">
                                <label for="product_name" class="form-label">商品名*</label>
                                <input type="text" class="form-control" id="product_name" name="product_name" value="{{ $product->product_name }}" required>
                                @if($errors->has('product_name'))
                                      <p>{{ $errors->first('product_name') }}</p>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="company_id" class="form-label">メーカー名*</label>
                                <select class="form-select" id="company_id" name="company_id" required>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}" {{ $product->company_id == $company->id ? 'selected' : '' }}>{{ $company->company_name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('company_id'))
                                      <p>{{ $errors->first('company_id') }}</p>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">価格*</label>
                                <input type="number" class="form-control" id="price" name="price" value="{{ $product->price }}" required>
                                @if($errors->has('price'))
                                      <p>{{ $errors->first('price') }}</p>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="stock" class="form-label">在庫数*</label>
                                <input type="number" class="form-control" id="stock" name="stock" value="{{ $product->stock }}" required>
                                @if($errors->has('stock'))
                                      <p>{{ $errors->first('stock') }}</p>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="comment" class="form-label">コメント</label>
                                <textarea id="comment" name="comment" class="form-control" rows="3">{{ $product->comment }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="img_path" class="form-label">商品画像:</label>
                                <input id="img_path" type="file" name="img_path" class="form-control">
                                <img src="{{ asset($product->img_path) }}" alt="商品画像" class="product-image">
                            </div>

                            <button type="submit" class="btn btn-primary">更新</button>
                            <a href="{{ route('products.index') }}" class="btn btn-primary mt-1 mb-3">戻る</a>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection