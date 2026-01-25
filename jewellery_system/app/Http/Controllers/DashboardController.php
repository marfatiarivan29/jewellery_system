<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Customer;
use App\Models\SaleItem;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalItems = Product::count();
        $totalSales = Sale::count();
        $totalCustomers = Customer::count();
        $lowStockItems = Product::where('stock_quantity', '<', 5)->get(); // Alert threshold 5

        // Daily Sales for chart (Last 7 days)
        $dates = collect();
        $dailySales = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $dates->push($date);
            $dailySales->push(Sale::whereDate('created_at', $date)->sum('total_amount'));
        }

        $products = Product::latest()->take(8)->get();

        return view('dashboard', compact('totalItems', 'totalSales', 'totalCustomers', 'lowStockItems', 'dates', 'dailySales', 'products'));
    }
}
