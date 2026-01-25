@extends('layouts.app')

@section('header', 'Sales History')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Invoice #</th>
                        <th>Date</th>
                        <th>Customer</th>
                        <th>Total Amount</th>
                        <th>Payment</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sales as $sale)
                    <tr>
                        <td>{{ $sale->invoice_number }}</td>
                        <td>{{ $sale->created_at->format('d M Y') }}</td>
                        <td>{{ $sale->customer->name }}</td>
                        <td>₹{{ number_format($sale->total_amount, 2) }}</td>
                        <td>{{ $sale->payment_method }}</td>
                        <td>
                            <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-info btn-sm text-white"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('sales.invoice', $sale->id) }}" target="_blank" class="btn btn-secondary btn-sm"><i class="fas fa-print"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $sales->links() }}
    </div>
</div>
@endsection
