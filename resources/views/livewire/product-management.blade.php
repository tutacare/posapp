<div class="max-w-6xl mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-4">🛒 Product Management</h2>

    @if (session()->has('message'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-800 px-4 py-2 rounded">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="{{ $selectedProductId ? 'updateProduct' : 'createProduct' }}"
        class="grid md:grid-cols-2 gap-4 mb-8">
        <div>
            <label>Product Name</label>
            <input type="text" wire:model="name" class="w-full border px-3 py-2 rounded">
            @error('name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label>Category</label>
            <select wire:model="category_id" class="w-full border px-3 py-2 rounded">
                <option value="">-- Select Category --</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label>Price</label>
            <input type="number" wire:model="price" class="w-full border px-3 py-2 rounded">
            @error('price')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label>Stock</label>
            <input type="number" wire:model="stock" class="w-full border px-3 py-2 rounded">
            @error('stock')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="md:col-span-2">
            <label>Description</label>
            <textarea wire:model="description" class="w-full border px-3 py-2 rounded"></textarea>
        </div>

        <div class="md:col-span-2 flex gap-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                {{ $selectedProductId ? 'Update' : 'Add' }} Product
            </button>
            @if ($selectedProductId)
                <button type="button" wire:click="resetInput" class="bg-gray-500 text-white px-4 py-2 rounded">
                    Cancel
                </button>
            @endif
        </div>
    </form>

    <table class="w-full border">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-3 py-2 text-left">#</th>
                <th class="px-3 py-2 text-left">Name</th>
                <th class="px-3 py-2 text-left">Category</th>
                <th class="px-3 py-2 text-left">Price</th>
                <th class="px-3 py-2 text-left">Stock</th>
                <th class="px-3 py-2 text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr class="border-t">
                    <td class="px-3 py-2">{{ $product->id }}</td>
                    <td class="px-3 py-2">{{ $product->name }}</td>
                    <td class="px-3 py-2">{{ $product->category->name }}</td>
                    <td class="px-3 py-2">Rp{{ number_format($product->price, 2, ',', '.') }}</td>
                    <td class="px-3 py-2">{{ $product->stock }}</td>
                    <td class="px-3 py-2 space-x-2">
                        <button wire:click="editProduct({{ $product->id }})"
                            class="text-yellow-600 font-semibold">✏️</button>
                        <button wire:click="deleteProduct({{ $product->id }})"
                            class="text-red-600 font-semibold">🗑️</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
