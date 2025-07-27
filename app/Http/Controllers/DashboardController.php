<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function salesData(Request $request)
    {
        $period = $request->get('period', 'daily');

        if ($period === 'daily') {
            $sales = Order::selectRaw('DATE(created_at) as date, SUM(total_price) as total')
                ->whereDate('created_at', '>=', now()->subDays(7))
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            $categories = $sales->pluck('date')->map(fn($date) => \Carbon\Carbon::parse($date)->translatedFormat('l, d M'))->toArray();
            $data = $sales->pluck('total')->toArray();

            return response()->json([
                'categories' => $categories,
                'series' => [
                    ['name' => 'Penjualan', 'data' => $data]
                ]
            ]);
        }

        if ($period === 'monthly') {
            $sales = Order::selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(total_price) as total')
                ->whereYear('created_at', now()->year)
                ->groupBy('month', 'year')
                ->orderBy('year')
                ->orderBy('month')
                ->get();

            $categories = $sales->map(fn($item) => \Carbon\Carbon::create(null, $item->month)->translatedFormat('F'))->toArray();
            $data = $sales->pluck('total')->toArray();

            return response()->json([
                'categories' => $categories,
                'series' => [
                    ['name' => 'Penjualan', 'data' => $data]
                ]
            ]);
        }

        return response()->json([
            'categories' => [],
            'series' => []
        ]);
    }
}
