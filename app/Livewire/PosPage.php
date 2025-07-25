<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PosPage extends Component
{
    public array $cart = [];
    public float $totalPrice = 0;
    public string $search = '';
    public int $itemCount = 0;

    public function render()
    {
        $products = Product::query()
            ->where('stock', '>', 0)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereRaw('name ILIKE ?', ['%' . $this->search . '%'])
                        ->orWhereRaw('barcode ILIKE ?', ['%' . $this->search . '%']);
                });
            })
            ->orderBy('name')
            ->get();

        return view('livewire.pos-page', [
            'products' => $products,
        ]);
    }

    public function addToCart($productId)
    {
        try {
            $product = Product::findOrFail($productId);

            if (isset($this->cart[$productId])) {
                if ($this->cart[$productId]['quantity'] < $product->stock) {
                    $this->cart[$productId]['quantity']++;
                } else {
                    throw new \Exception('Stok tidak mencukupi');
                }
            } else {
                $this->cart[$productId] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => 1,
                    'max_stock' => $product->stock
                ];
            }

            $this->calculateTotalPrice();
            $this->itemCount = array_sum(array_column($this->cart, 'quantity'));
        } catch (\Exception $e) {
            $this->dispatch(
                'notify',
                type: 'error',
                message: $e->getMessage()
            );
        }
    }

    public function removeFromCart($productId)
    {
        if (isset($this->cart[$productId])) {
            unset($this->cart[$productId]);
            $this->calculateTotalPrice();
            $this->itemCount = array_sum(array_column($this->cart, 'quantity'));
        }
    }

    public function updateQuantity($productId, $quantity)
    {
        $validator = Validator::make(
            ['quantity' => $quantity],
            ['quantity' => 'required|integer|min:1']
        );

        if ($validator->fails()) {
            $this->dispatch(
                'notify',
                type: 'error',
                message: 'Jumlah tidak valid'
            );
            return;
        }

        try {
            $product = Product::findOrFail($productId);
            $quantity = (int)$quantity;

            if (isset($this->cart[$productId])) {
                if ($quantity <= $product->stock) {
                    $this->cart[$productId]['quantity'] = $quantity;
                    $this->cart[$productId]['max_stock'] = $product->stock;
                } else {
                    $this->cart[$productId]['quantity'] = $product->stock;
                    throw new \Exception('Jumlah melebihi stok, diset ke maksimal stok');
                }

                $this->calculateTotalPrice();
                $this->itemCount = array_sum(array_column($this->cart, 'quantity'));
            }
        } catch (\Exception $e) {
            $this->dispatch(
                'notify',
                type: 'error',
                message: $e->getMessage()
            );
        }
    }

    protected function calculateTotalPrice()
    {
        $this->totalPrice = array_reduce($this->cart, function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);
    }

    public function checkout()
    {
        if (empty($this->cart)) {
            $this->dispatch(
                'notify',
                type: 'error',
                message: 'Keranjang masih kosong'
            );
            return;
        }

        try {
            DB::transaction(function () {
                $order = Order::create([
                    'user_id' => Auth::id(),
                    'total_price' => $this->totalPrice,
                    'status' => 'completed',
                    'payment_method' => 'cash',
                ]);

                $productIds = collect($this->cart)->pluck('id');
                $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

                foreach ($this->cart as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item['id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'subtotal' => $item['price'] * $item['quantity']
                    ]);

                    if (isset($products[$item['id']])) {
                        $products[$item['id']]->decrement('stock', $item['quantity']);
                    }
                }
            });

            $this->resetCart();
            $this->dispatch(
                'notify',
                type: 'success',
                message: 'Transaksi berhasil! No. Order: #' . Order::latest()->first()->id
            );
        } catch (\Exception $e) {
            $this->dispatch(
                'notify',
                type: 'error',
                message: 'Checkout gagal: ' . $e->getMessage()
            );
        }
    }

    public function resetCart()
    {
        $this->cart = [];
        $this->totalPrice = 0;
        $this->itemCount = 0;
    }

    public function clearCart()
    {
        $this->resetCart();
        $this->dispatch(
            'notify',
            type: 'success',
            message: 'Keranjang berhasil dikosongkan'
        );
    }
}
