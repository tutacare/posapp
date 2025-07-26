<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PosController extends Controller
{
    public function index()
    {
        $products = Product::where('stock', '>', 0)->orderBy('name')->paginate(10);
        return view('pos.index', compact('products'));
    }

    public function getProducts(Request $request)
    {
        $query = Product::query()->where('stock', '>', 0)->orderBy('name');

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ILIKE', "%{$search}%")
                  ->orWhere('barcode', 'ILIKE', "%{$search}%");
            });
        }

        $products = $query->paginate(10);

        return response()->json($products);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'cart' => 'required|array',
            'cart.*.id' => 'required|exists:products,id',
            'cart.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            $order = DB::transaction(function () use ($request) {
                $cart = $request->input('cart');
                $productIds = collect($cart)->pluck('id')->toArray();
                $products = Product::find($productIds)->keyBy('id');

                $totalPrice = 0;
                foreach ($cart as $item) {
                    $product = $products->get($item['id']);
                    if (!$product || $item['quantity'] > $product->stock) {
                        throw new \Exception('Stok tidak mencukupi untuk produk: ' . ($product->name ?? 'N/A'));
                    }
                    $totalPrice += $product->price * $item['quantity'];
                }

                $order = Order::create([
                    'user_id' => Auth::id(),
                    'total_price' => $totalPrice,
                    'status' => 'completed',
                    'payment_method' => 'cash',
                ]);

                foreach ($cart as $item) {
                    $product = $products->get($item['id']);
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item['id'],
                        'quantity' => $item['quantity'],
                        'price' => $product->price,
                        'subtotal' => $product->price * $item['quantity'],
                    ]);
                    $product->decrement('stock', $item['quantity']);
                }

                return $order;
            });

            return response()->json([
                'message' => 'Transaksi berhasil! No. Order: #' . $order->id,
                'redirect_url' => route('order.completed', ['order' => $order->id])
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Checkout gagal: ' . $e->getMessage()], 400);
        }
    }
}
