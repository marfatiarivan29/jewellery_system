<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function generate(Request $request)
    {
        $type = $request->type;
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        if ($type == 'sales') {
            $data = Sale::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->get();
            return view('reports.sales', compact('data', 'startDate', 'endDate'));
        } elseif ($type == 'stock') {
            $data = Product::with('category')->get();
            return view('reports.stock', compact('data'));
        }
        
        return back();
    }
}
