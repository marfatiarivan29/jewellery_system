@extends('layouts.app')

@section('header', 'Sales Report')

@section('content')
<div class="card">
    <div class="card-header">
        Sales from {{ $startDate }} to {{ $endDate }}
        <button onclick="window.print()" class="btn btn-sm btn-secondary float-end">Print</button>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Invoice</th>
                    <th>Subtotal</th>
                    <th>Tax</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php $grandTotal = 0; @endphp
                @foreach($data as $sale)
                <tr>
                    <td>{{ $sale->created_at->format('Y-m-d') }}</td>
                    <td>{{ $sale->invoice_number }}</td>
                    <td>{{ number_format($sale->subtotal, 2) }}</td>
                    <td>{{ number_format($sale->tax_amount, 2) }}</td>
                    <td>{{ number_format($sale->total_amount, 2) }}</td>
                </tr>
                @php $grandTotal += $sale->total_amount; @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" class="text-end">Grand Total</th>
                    <th>{{ number_format($grandTotal, 2) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection
