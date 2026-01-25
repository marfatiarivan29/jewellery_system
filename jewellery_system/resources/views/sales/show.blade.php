@extends('layouts.app')

@section('header', 'Sale Details')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <span>{{ $sale->invoice_number }}</span>
                <a href="{{ route('sales.invoice', $sale->id) }}" target="_blank" class="btn btn-secondary btn-sm"><i class="fas fa-print"></i> Print</a>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-6">
                        <h6 class="text-muted">Customer</h6>
                        <h5>{{ $sale->customer->name }}</h5>
                        <p>{{ $sale->customer->phone }}<br>{{ $sale->customer->address }}</p>
                    </div>
                    <div class="col-6 text-end">
                        <h6 class="text-muted">Details</h6>
                        <p>Date: {{ $sale->created_at->format('d M Y h:i A') }}<br>
                        Sold By: {{ $sale->user->name }}</p>
                    </div>
                </div>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th class="text-end">Qty</th>
                            <th class="text-end">Rate</th>
                            <th class="text-end">MC</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sale->items as $item)
                        <tr>
                            <td>{{ $item->product->name }} <br><small class="text-muted">{{ $item->weight }}g</small></td>
                            <td class="text-end">{{ $item->quantity }}</td>
                            <td class="text-end">{{ number_format($item->price, 2) }}</td>
                            <td class="text-end">{{ number_format($item->making_charges, 2) }}</td>
                            <td class="text-end">{{ number_format($item->total, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-end">Subtotal</th>
                            <th class="text-end">{{ number_format($sale->subtotal, 2) }}</th>
                        </tr>
                         <tr>
                            <th colspan="4" class="text-end">GST</th>
                            <th class="text-end">{{ number_format($sale->tax_amount, 2) }}</th>
                        </tr>
                        <tr>
                            <th colspan="4" class="text-end">Total</th>
                            <th class="text-end fs-5">{{ number_format($sale->total_amount, 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
