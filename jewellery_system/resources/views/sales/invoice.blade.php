<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $sale->invoice_number }}</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .header { text-align: center; margin-bottom: 30px; }
        .meta { margin-bottom: 20px; display: flex; justify-content: space-between; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f4f4f4; }
        .text-end { text-align: right; }
        .total-section { float: right; width: 300px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Jewellery Shop</h2>
        <p>123 Jewel Street, City</p>
        <h3>Invoice</h3>
    </div>
    
    <div class="meta">
        <div>
            <strong>Bill To:</strong><br>
            {{ $sale->customer->name }}<br>
            {{ $sale->customer->phone }}
        </div>
        <div style="text-align: right;">
            Invoice #: {{ $sale->invoice_number }}<br>
            Date: {{ $sale->created_at->format('d/m/Y') }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Weight (g)</th>
                <th>Rate</th>
                <th>Making Charges</th>
                <th>GST</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->weight }}</td>
                <td>{{ $item->price }}</td>
                <td>{{ $item->making_charges }}</td>
                <td>{{ $item->gst_amount }}</td>
                <td>{{ $item->total }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <table>
            <tr>
                <td>Subtotal</td>
                <td class="text-end">{{ $sale->subtotal }}</td>
            </tr>
            <tr>
                <td>Tax</td>
                <td class="text-end">{{ $sale->tax_amount }}</td>
            </tr>
            <tr>
                <th>Grand Total</th>
                <th class="text-end">{{ $sale->total_amount }}</th>
            </tr>
        </table>
    </div>

    <script>
        window.print();
    </script>
</body>
</html>
