<x-app-layout>
    <div class="py-12 bg-gray-50 print:bg-white print:py-0">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 print:max-w-full print:px-8">
            <div class="bg-white shadow-lg rounded-2xl overflow-hidden print:shadow-none print:rounded-none">
                <div class="p-8 print:p-4" id="receipt-details">
                    {{-- Jangan tampilkan ikon sukses dan pesan saat mencetak --}}
                    <div class="text-center mb-8 print:hidden">
                        <svg class="w-16 h-16 mx-auto text-green-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h2 class="text-3xl font-bold text-gray-800 mt-4">Transaksi Berhasil!</h2>
                        <p class="text-gray-600 mt-2">Pesanan Anda telah berhasil diproses.</p>
                    </div>

                    <div
                        class="bg-gray-100 rounded-xl p-6 mb-6 print:bg-white print:p-0 print:mb-4 print:border-b print:border-dashed print:border-gray-400">
                        <h3 class="text-xl font-semibold text-gray-700 mb-4 print:text-base">Detail Pesanan</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-800 print:grid-cols-1 print:gap-2">
                            <div>
                                <p><strong>No. Order:</strong> #{{ $order->id }}</p>
                                <p><strong>Tanggal:</strong> {{ $order->created_at->format('d F Y, H:i') }}</p>
                            </div>
                            <div class="text-right print:text-left">
                                <p><strong>Total Pembayaran:</strong></p>
                                <p class="text-2xl font-bold text-indigo-600 print:text-base print:font-semibold">
                                    Rp{{ number_format($order->total_price, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-semibold text-gray-700 mb-3 print:text-base">Item yang Dibeli</h4>
                        <ul class="space-y-3 print:space-y-1">
                            @foreach ($order->items as $item)
                                <li
                                    class="flex justify-between items-center bg-white p-3 rounded-lg shadow-sm print:p-0 print:shadow-none print:border-b print:border-dashed print:border-gray-400">
                                    <div>
                                        <p class="font-semibold print:font-normal print:text-sm">
                                            {{ $item->product->name }}</p>
                                        <p class="text-sm text-gray-600 print:text-xs">{{ $item->quantity }} x
                                            Rp{{ number_format($item->price, 0, ',', '.') }}</p>
                                    </div>
                                    <p class="font-semibold text-gray-800 print:text-sm">
                                        Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                                    </p>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Tombol tidak ikut tercetak --}}
                    <div class="mt-8 text-center print:hidden">
                        <button onclick="printReceipt()"
                            class="inline-block px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition mr-4">
                            Cetak Struk
                        </button>
                        <a href="{{ route('dashboard') }}"
                            class="inline-block px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition">
                            Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function printReceipt() {
                window.print();
            }
        </script>
    @endpush
</x-app-layout>
