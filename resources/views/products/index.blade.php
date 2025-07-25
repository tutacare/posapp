<x-app-layout>
    <div class="bg-white min-h-screen py-10 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
                <h1 class="text-3xl font-semibold text-gray-800">📦 Product List</h1>
                <a href="{{ route('products.create') }}"
                    class="mt-4 sm:mt-0 inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded shadow transition">
                    + Add Product
                </a>
            </div>

            @if (session('success'))
                <div class="bg-green-100 text-green-800 border border-green-300 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto rounded-lg shadow border border-gray-200 bg-white">
                <table id="productsTable" class="min-w-full table-auto">
                    <thead class="bg-gray-100 text-gray-700 text-sm uppercase">
                        <tr>
                            <th class="px-6 py-3 text-left">Name</th>
                            <th class="px-6 py-3 text-left">Category</th>
                            <th class="px-6 py-3 text-left">Price</th>
                            <th class="px-6 py-3 text-left">Stock</th>
                            <th class="px-6 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800">
                        @forelse ($products as $product)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="px-6 py-4">{{ $product->name }}</td>
                                <td class="px-6 py-4">{{ $product->category->name }}</td>
                                <td class="px-6 py-4">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">{{ $product->stock }}</td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('products.edit', $product) }}"
                                        class="text-blue-600 hover:text-blue-800 transition font-medium">Edit</a>

                                    <form action="{{ route('products.destroy', $product) }}" method="POST"
                                        class="inline-block ml-2">
                                        @csrf @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure?')"
                                            class="text-red-600 hover:text-red-800 transition font-medium">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-6 text-center text-gray-500">No products found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                if (window.$) {
                    $('#productsTable').DataTable();
                }
            });
        </script>
    @endpush
</x-app-layout>
