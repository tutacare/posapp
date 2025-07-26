<x-apppos-layout>
    <div x-data="pos()" class="py-12 bg-gray-50 min-h-screen">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
                <div class="p-8 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-3xl font-bold text-indigo-700">🛒 Point of Sale</h2>
                        <button @click="clearCart" x-show="cart.length > 0"
                            class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm transition flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            Kosongkan Keranjang
                        </button>
                    </div>

                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="md:col-span-2">
                            <h3 class="text-xl font-semibold mb-4 text-gray-700">📦 Produk</h3>
                            <div class="mb-4 relative">
                                <input type="text" x-model.debounce.500ms="search"
                                    placeholder="Cari produk (nama/barcode)..."
                                    class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                <button x-show="search" @click="search = ''"
                                    class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                                <template x-for="product in products" :key="product.id">
                                    <div
                                        class="border rounded-xl p-4 shadow-md transition hover:shadow-lg bg-white flex flex-col h-full">
                                        <h4 class="text-lg font-bold text-gray-800 mb-1" x-text="product.name"></h4>
                                        <p class="text-xs text-gray-500 mb-1" x-show="product.barcode">SKU: <span
                                                x-text="product.barcode"></span></p>
                                        <p class="text-sm text-gray-500 line-clamp-2 flex-grow"
                                            x-text="product.description"></p>
                                        <p class="mt-2 font-semibold text-indigo-600"
                                            x-text="formatCurrency(product.price)"></p>
                                        <p class="text-xs"
                                            :class="product.stock < 5 ? 'text-red-500' : 'text-gray-500'">Stok: <span
                                                x-text="product.stock"></span></p>
                                        <button @click="addToCart(product)" :disabled="product.stock == 0"
                                            class="mt-3 w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-medium py-1.5 px-3 rounded-lg text-sm transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Tambah
                                        </button>
                                    </div>
                                </template>
                                <div x-show="isLoadingMore" class="col-span-full text-center py-4">
                                    <svg class="animate-spin mx-auto h-8 w-8 text-indigo-500"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Memuat lebih banyak produk...
                                </div>
                                <div x-show="!hasMoreProducts && products.length > 0"
                                    class="col-span-full text-center py-4 text-gray-500">
                                    Semua produk telah dimuat.
                                </div>
                            </div>
                        </div>

                        <div class="md:col-span-1">
                            <h3 class="text-xl font-semibold mb-4 text-gray-700">🧾 Keranjang <span
                                    class="text-sm font-normal" x-text="`(${itemCount} item)`"></span></h3>
                            <div class="border rounded-xl p-4 shadow-md bg-gray-50 sticky top-4">
                                <div x-show="cart.length === 0" class="text-center py-8">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-3"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <p class="text-gray-500">Keranjang masih kosong.</p>
                                </div>
                                <ul x-show="cart.length > 0" class="space-y-3 mb-4 max-h-96 overflow-y-auto pr-2">
                                    <template x-for="item in cart" :key="item.id">
                                        <li
                                            class="flex justify-between items-start text-sm bg-white p-3 rounded-lg shadow-sm">
                                            <div class="w-full">
                                                <div class="flex justify-between items-center">
                                                    <span class="font-semibold text-gray-800" x-text="item.name"></span>
                                                    <button @click="removeFromCart(item.id)"
                                                        class="ml-2 text-red-600 hover:text-red-800 text-xs font-medium">✖</button>
                                                </div>
                                                <div class="flex justify-between items-center mt-2">
                                                    <span class="text-gray-600"
                                                        x-text="formatCurrency(item.price)"></span>
                                                    <div class="flex items-center space-x-1">
                                                        <button @click="updateQuantity(item.id, item.quantity - 1)"
                                                            class="px-2 py-1 bg-gray-200 rounded-l-md hover:bg-gray-300 transition">-</button>
                                                        <input type="number" x-model.number="item.quantity"
                                                            @change="updateQuantity(item.id, item.quantity)"
                                                            min="1" :max="item.max_stock"
                                                            class="w-12 text-center border-t border-b border-gray-300 py-1 focus:ring-1 focus:ring-indigo-500">
                                                        <button @click="updateQuantity(item.id, item.quantity + 1)"
                                                            class="px-2 py-1 bg-gray-200 rounded-r-md hover:bg-gray-300 transition">+</button>
                                                    </div>
                                                    <span class="font-medium"
                                                        x-text="formatCurrency(item.price * item.quantity)"></span>
                                                </div>
                                            </div>
                                        </li>
                                    </template>
                                </ul>
                                <div x-show="cart.length > 0" class="border-t pt-3">
                                    <div class="flex justify-between font-semibold text-lg">
                                        <span>Total:</span>
                                        <span class="text-indigo-600" x-text="formatCurrency(totalPrice)"></span>
                                    </div>
                                </div>
                                <button @click="checkout" x-show="cart.length > 0" :disabled="isProcessing"
                                    class="mt-4 w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2.5 rounded-lg transition flex items-center justify-center">
                                    <span x-show="!isProcessing">Checkout</span>
                                    <span x-show="isProcessing" class="flex items-center"><svg
                                            class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>Processing...</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function pos() {
                return {
                    products: @json($products->items()),
                    currentPage: {{ $products->currentPage() }},
                    hasMoreProducts: {{ $products->hasMorePages() ? 'true' : 'false' }},
                    isLoadingMore: false,
                    search: '',
                    cart: [],
                    isProcessing: false,
                    init() {
                        this.$watch('search', (newValue, oldValue) => {
                            if (newValue !== oldValue) {
                                this.products = [];
                                this.currentPage = 1;
                                this.hasMoreProducts = true;
                                this.loadMoreProducts();
                            }
                        });

                        // The rest of your init function...
                        window.addEventListener('scroll', () => {
                            if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 100 && this.hasMoreProducts && !this.isLoadingMore) {
                                this.loadMoreProducts();
                            }
                        });
                    },
                    get itemCount() {
                        return this.cart.reduce((sum, item) => sum + item.quantity, 0);
                    },
                    get totalPrice() {
                        return this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                    },
                    async loadMoreProducts() {
                        if (!this.hasMoreProducts || this.isLoadingMore) return;

                        this.isLoadingMore = true;
                        try {
                            const response = await fetch(`{{ route('pos.products') }}?page=${this.currentPage}&search=${this.search}`);
                            const data = await response.json();

                            if (data.data.length > 0) {
                                this.products.push(...data.data);
                                this.currentPage++;
                                this.hasMoreProducts = data.next_page_url !== null;
                            } else {
                                this.hasMoreProducts = false;
                            }
                        } catch (error) {
                            console.error('Error loading more products:', error);
                            this.hasMoreProducts = false; // Stop trying on error
                        } finally {
                            this.isLoadingMore = false;
                        }
                    },
                    addToCart(product) {
                        const existingItem = this.cart.find(item => item.id === product.id);
                        if (existingItem) {
                            if (existingItem.quantity < product.stock) {
                                existingItem.quantity++;
                            }
                        } else {
                            this.cart.push({
                                id: product.id,
                                name: product.name,
                                price: product.price,
                                quantity: 1,
                                max_stock: product.stock
                            });
                        }
                    },
                    removeFromCart(productId) {
                        this.cart = this.cart.filter(item => item.id !== productId);
                    },
                    updateQuantity(productId, quantity) {
                        const item = this.cart.find(item => item.id === productId);
                        if (!item) return;

                        const newQuantity = parseInt(quantity);
                        if (isNaN(newQuantity) || newQuantity < 1) {
                            this.removeFromCart(productId);
                            return;
                        }

                        if (newQuantity > item.max_stock) {
                            item.quantity = item.max_stock;
                        } else {
                            item.quantity = newQuantity;
                        }
                    },
                    clearCart() {
                        this.cart = [];
                    },
                    checkout() {
                        this.isProcessing = true;
                        const cartData = this.cart.map(item => ({
                            id: item.id,
                            quantity: item.quantity
                        }));

                        console.log('Sending cart data:', cartData);

                        fetch('{{ route('pos.checkout') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                        'content'),
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                body: JSON.stringify({
                                    cart: cartData
                                })
                            })
                            .then(response => {
                                console.log('Raw response:', response);
                                if (!response.ok) {
                                    return response.json().then(errorData => {
                                        throw new Error(errorData.message || 'Server error');
                                    });
                                }
                                return response.json();
                            })
                            .then(data => {
                                console.log('Response data:', data);
                                if (data.redirect_url) {
                                    window.location.href = data.redirect_url;
                                } else {
                                    alert(data.message || 'Terjadi kesalahan.');
                                }
                            })
                            .catch(error => {
                                console.error('Error during checkout:', error);
                                alert('Checkout gagal: ' + error.message + '. Silakan coba lagi.');
                            })
                            .finally(() => {
                                this.isProcessing = false;
                            });
                    },
                    formatCurrency(amount) {
                        return new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR',
                            minimumFractionDigits: 0
                        }).format(amount);
                    }
                }
            }
        </script>
    @endpush
    </x-app-layout>
