@extends('layouts.app')

@section('header', 'Stock Report')

@section('content')
<div class="card">
    <div class="card-header">
        Current Stock Level
        <button onclick="window.print()" class="btn btn-sm btn-secondary float-end">Print</button>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Product</th>
                    <th>Metal</th>
                    <th>Weight</th>
                    <th>Stock Qty</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $product)
                <tr>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->metal_type }} {{ $product->purity }}</td>
                    <td>{{ $product->weight }}g</td>
                    <td>{{ $product->stock_quantity }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
