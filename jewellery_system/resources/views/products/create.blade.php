@extends('layouts.app')

@section('header', 'Add Product')

@section('content')
<div class="row">
    <div class="col-md-9 mx-auto">
        <div class="card">
            <div class="card-header">New Jewellery Item</div>
            <div class="card-body">
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Product Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required placeholder="e.g. Gold Ring with Diamond">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Category <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label">Metal Type</label>
                            <select name="metal_type" class="form-select" required>
                                <option value="Gold">Gold</option>
                                <option value="Silver">Silver</option>
                                <option value="Platinum">Platinum</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Purity</label>
                            <input type="text" name="purity" class="form-control" placeholder="e.g. 22K, 18K" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Weight (grams) <span class="text-danger">*</span></label>
                            <input type="number" step="0.001" name="weight" class="form-control" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Making Charges (₹)</label>
                            <input type="number" step="0.01" name="making_charges" class="form-control" value="0">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">GST (%)</label>
                            <input type="number" step="0.01" name="gst_percentage" class="form-control" value="3.00">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Total Price (₹)</label>
                            <input type="number" step="0.01" name="price" class="form-control" required>
                            <small class="text-muted">Estimated selling price</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Stock Quantity</label>
                            <input type="number" name="stock_quantity" class="form-control" value="1" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Supplier</label>
                            <select name="supplier_id" class="form-select">
                                <option value="">Select Supplier (Optional)</option>
                                @foreach($suppliers as $sup)
                                    <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label">Product Image</label>
                            <input type="file" name="image" class="form-control">
                        </div>

                        <div class="col-12 text-end mt-4">
                            <a href="{{ route('products.index') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save Product</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
