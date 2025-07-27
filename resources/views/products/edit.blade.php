<x-app-layout>
    <div class="max-w-2xl mx-auto py-10 px-4">
        <h2 class="text-xl font-bold mb-4">{{ isset($product) ? 'Edit Product' : 'Add New Product' }}</h2>

        <form action="{{ isset($product) ? route('products.update', $product) : route('products.store') }}" method="POST"
            class="space-y-4">
            @csrf
            @if (isset($product))
                @method('PUT')
            @endif

            <div>
                <label class="block text-sm font-medium">Product Name</label>
                <input name="name" value="{{ old('name', $product->name ?? '') }}" class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block text-sm font-medium">Description</label>
                <textarea name="description" class="w-full border rounded p-2">{{ old('description', $product->description ?? '') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium">Barcode</label>
                <input name="barcode" value="{{ old('barcode', $product->barcode ?? '') }}"
                    class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block text-sm font-medium">Cost Price</label>
                <input name="cost_price" type="number" step="0.01"
                    value="{{ old('cost_price', $product->cost_price ?? '') }}" class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block text-sm font-medium">Price</label>
                <input name="price" type="number" step="0.01" value="{{ old('price', $product->price ?? '') }}"
                    class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block text-sm font-medium">Stock</label>
                <input name="stock" type="number" value="{{ old('stock', $product->stock ?? '') }}"
                    class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block text-sm font-medium">Category</label>
                <select name="category_id" class="w-full border rounded p-2">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <button class="bg-blue-600 text-white px-4 py-2 rounded" type="submit">
                    {{ isset($product) ? 'Update' : 'Create' }}
                </button>
            </div>
        </form>

    </div>
</x-app-layout>
