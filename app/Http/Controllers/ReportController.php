<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function profitLoss()
    {
        $orders = Order::where('status', 'completed')->with('orderItems.product')->get();

        $totalRevenue = 0;
        $totalCost = 0;

        foreach ($orders as $order) {
            foreach ($order->orderItems as $item) {
                $totalRevenue += $item->quantity * $item->price;
                // Ensure product and cost_price exist before adding to totalCost
                if ($item->product && $item->product->cost_price !== null) {
                    $totalCost += $item->quantity * $item->product->cost_price;
                }
            }
        }

        $profitOrLoss = $totalRevenue - $totalCost;

        return view('reports.profit-loss', compact('totalRevenue', 'totalCost', 'profitOrLoss'));
    }
}
