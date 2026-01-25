@extends('layouts.app')

@section('header', 'Edit Product')

@section('content')
<div class="row">
    <div class="col-md-9 mx-auto">
        <div class="card">
            <div class="card-header">Edit Product</div>
            <div class="card-body">
                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row g-3">
                        <!-- Basic Info -->
                        <div class="col-md-6">
                            <label class="form-label">Product Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-select" required>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Specs -->
                        <div class="col-md-4">
                            <label class="form-label">Metal</label>
                            <select name="metal_type" class="form-select">
                                <option value="Gold" {{ $product->metal_type == 'Gold' ? 'selected' : '' }}>Gold</option>
                                <option value="Silver" {{ $product->metal_type == 'Silver' ? 'selected' : '' }}>Silver</option>
                                <option value="Platinum" {{ $product->metal_type == 'Platinum' ? 'selected' : '' }}>Platinum</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Purity</label>
                            <input type="text" name="purity" class="form-control" value="{{ $product->purity }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Weight (g)</label>
                            <input type="number" step="0.001" name="weight" class="form-control" value="{{ $product->weight }}">
                        </div>

                        <!-- Pricing -->
                        <div class="col-md-4">
                            <label class="form-label">Making Charges</label>
                            <input type="number" step="0.01" name="making_charges" class="form-control" value="{{ $product->making_charges }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Price</label>
                            <input type="number" step="0.01" name="price" class="form-control" value="{{ $product->price }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Stock</label>
                            <input type="number" name="stock_quantity" class="form-control" value="{{ $product->stock_quantity }}">
                        </div>

                        <!-- Image -->
                         <div class="col-12">
                            <label class="form-label">Product Image</label>
                            <input type="file" name="image" class="form-control">
                            @if($product->image)
                                <div class="mt-2">
                                    <img src="{{ asset($product->image) }}" width="100" class="rounded border">
                                    <small class="d-block text-muted">Current Image</small>
                                </div>
                            @endif
                        </div>

                        <div class="col-12 text-end mt-3">
                            <a href="{{ route('products.index') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Product</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
