<x-app-layout>
    <div class="max-w-6xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Completed Orders</h1>

        <form method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
            <input type="text" name="order_id" placeholder="Order ID" value="{{ request('order_id') }}"
                class="border border-gray-300 rounded px-4 py-2 w-full">

            <input type="date" name="from_date" value="{{ request('from_date') }}"
                class="border border-gray-300 rounded px-4 py-2 w-full">

            <input type="date" name="to_date" value="{{ request('to_date') }}"
                class="border border-gray-300 rounded px-4 py-2 w-full">

            <button class="bg-blue-600 text-white rounded px-4 py-2 hover:bg-blue-700">Filter</button>
        </form>

        @foreach ($orders as $order)
            <div class="mb-4 border-b pb-4">
                <h2 class="text-lg font-semibold">Order #{{ $order->id }}</h2>
                <p class="text-sm text-gray-600">Date: {{ $order->created_at->format('Y-m-d H:i') }}</p>

                <ul class="mt-2 text-sm text-gray-800 list-disc list-inside">
                    @foreach ($order->items as $item)
                        <li>{{ $item->product->name }} - Qty: {{ $item->quantity }}</li>
                    @endforeach
                </ul>
            </div>
        @endforeach

        <div class="mt-6">
            {{ $orders->withQueryString()->links() }}
        </div>
    </div>
</x-app-layout>
