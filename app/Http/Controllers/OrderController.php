<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function completed(Request $request)
    {
        $query = Order::with('items.product')
            ->where('status', 'completed');

        if ($request->filled('order_id')) {
            $query->where('id', $request->order_id);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('orders.completed', compact('orders'));
    }
}
