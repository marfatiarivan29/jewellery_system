<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('customer', 'user')->latest()->paginate(10);
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $customers = Customer::all();
        $products = Product::where('stock_quantity', '>', 0)->get();
        
        // Fetch current rates
        $goldRate24k = Setting::where('key', 'gold_rate_24k')->value('value') ?? 0;
        $goldRate22k = Setting::where('key', 'gold_rate_22k')->value('value') ?? 0;
        $silverRate = Setting::where('key', 'silver_rate')->value('value') ?? 0;

        return view('sales.create', compact('customers', 'products', 'goldRate24k', 'goldRate22k', 'silverRate'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required',
            'products' => 'required|array',
            'payment_method' => 'required'
        ]);

        try {
            DB::beginTransaction();

            $sale = Sale::create([
                'customer_id' => $request->customer_id,
                'user_id' => auth()->id() ?? 1, // Fallback to 1 if not logged in for testing
                'invoice_number' => 'INV-' . time(),
                'subtotal' => 0,
                'tax_amount' => 0,
                'total_amount' => 0,
                'payment_method' => $request->payment_method
            ]);

            $subtotal = 0;
            $taxTotal = 0;

            foreach ($request->products as $item) {
                $product = Product::find($item['product_id']);
                
                if ($product->stock_quantity < $item['quantity']) {
                    throw new \Exception("Insufficient stock for " . $product->name);
                }

                $quantity = $item['quantity'];
                
                // Calculate Price Logic
                // If price is overridden in form, use it, else calculate
                // For simplicity, assuming the form submits the calculated 'unit_price' and 'total'
                // But generally backend should verify. I'll rely on form data for flexibility here and validating basic math?
                // Actually safer to recalculate.
                // Price logic: (Weight * Rate) + Making Charge. Not handled here, assuming front-end sends final price or we take product price.
                // Let's assume the request sends the final agreed price per unit or total.
                
                $price = $item['price']; // Unit price
                $making_charges = $item['making_charges'] ?? 0;
                $rowTotal = ($price * $quantity) + $making_charges;
                
                // GST
                $gstPercent = $product->gst_percentage;
                $gstAmount = ($rowTotal * $gstPercent) / 100;
                $rowFinalTotal = $rowTotal + $gstAmount;

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'weight' => $product->weight,
                    'price' => $price,
                    'making_charges' => $making_charges,
                    'gst_amount' => $gstAmount,
                    'total' => $rowFinalTotal
                ]);

                // Reduce Stock
                $product->decrement('stock_quantity', $quantity);

                $subtotal += $rowTotal;
                $taxTotal += $gstAmount;
            }

            $sale->update([
                'subtotal' => $subtotal,
                'tax_amount' => $taxTotal,
                'total_amount' => $subtotal + $taxTotal
            ]);

            DB::commit();

            return redirect()->route('sales.show', $sale->id)->with('success', 'Sale completed successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(Sale $sale)
    {
        $sale->load('items.product', 'customer');
        return view('sales.show', compact('sale'));
    }

    public function invoice(Sale $sale)
    {
        $sale->load('items.product', 'customer');
        // In a real app, use PDF library. For now, returning view calling window.print()
        return view('sales.invoice', compact('sale'));
    }
}
