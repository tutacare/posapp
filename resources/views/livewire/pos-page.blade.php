<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
            <div class="p-8 text-gray-900">
                <h2 class="text-3xl font-bold mb-6 text-indigo-700">🛒 Point of Sale</h2>

                {{-- Alert Message --}}
                @if (session()->has('message'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded-lg shadow-sm">
                        ✅ {{ session('message') }}
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-800 rounded-lg shadow-sm">
                        ⚠️ {{ session('error') }}
                    </div>
                @endif

                <div class="grid md:grid-cols-3 gap-6">
                    {{-- Products Section --}}
                    <div class="md:col-span-2">
                        <h3 class="text-xl font-semibold mb-4 text-gray-700">📦 Products</h3>
                        <div class="mb-4">
                            <input type="text" wire:model.live="search" placeholder="Cari produk..."
                                class="w-full px-4 py-2 border rounded-md mb-4" />

                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @if (!empty($products))
                                @foreach ($products as $product)
                                    <div
                                        class="border rounded-xl p-4 shadow-md transition hover:shadow-lg {{ $product->stock == 0 ? 'bg-gray-100' : 'bg-white' }}">
                                        <h4 class="text-lg font-bold text-gray-800">{{ $product->name }}</h4>
                                        <p class="text-sm text-gray-500 line-clamp-2">{{ $product->description }}</p>
                                        <p class="mt-2 font-semibold text-indigo-600">
                                            Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                                        <p class="text-xs text-gray-500">Stok: {{ $product->stock }}</p>

                                        <button wire:click="addToCart({{ $product->id }})"
                                            {{ $product->stock == 0 ? 'disabled' : '' }}
                                            class="mt-3 w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-medium py-1.5 px-3 rounded-lg text-sm transition disabled:opacity-50 disabled:cursor-not-allowed">
                                            Tambah ke Keranjang
                                        </button>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-gray-500">Tidak ada produk ditemukan.</p>
                            @endif
                        </div>
                    </div>

                    {{-- Cart Section --}}
                    <div class="md:col-span-1">
                        <h3 class="text-xl font-semibold mb-4 text-gray-700">🧾 Keranjang</h3>
                        <div class="border rounded-xl p-4 shadow-md bg-gray-50">
                            @if (empty($cart))
                                <p class="text-gray-500 text-sm">Keranjang masih kosong.</p>
                            @else
                                <ul class="space-y-3 mb-4">
                                    @foreach ($cart as $item)
                                        <li class="flex justify-between items-start text-sm">
                                            <div class="w-full">
                                                <div class="flex justify-between items-center">
                                                    <span class="font-semibold text-gray-800">{{ $item['name'] }}</span>
                                                    <button wire:click="removeFromCart({{ $item['id'] }})"
                                                        class="ml-2 text-red-600 hover:text-red-800 text-xs font-medium">
                                                        ✖ Hapus
                                                    </button>
                                                </div>
                                                <div class="text-gray-600">
                                                    Rp{{ number_format($item['price'], 0, ',', '.') }}</div>
                                                <div class="mt-1">
                                                    <input type="number"
                                                        wire:change="updateQuantity({{ $item['id'] }}, $event.target.value)"
                                                        value="{{ $item['quantity'] }}" min="1"
                                                        class="w-20 text-center border border-gray-300 rounded-md px-2 py-1 text-sm">
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="border-t pt-3 text-right font-semibold text-gray-800 text-base">
                                    Total: Rp{{ number_format($totalPrice, 0, ',', '.') }}
                                </div>

                                <button wire:click="checkout"
                                    class="mt-4 w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 rounded-lg transition">
                                    Checkout & Bayar
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
