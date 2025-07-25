<div class="w-full">
    <div class="bg-white shadow-xl rounded-xl p-8 space-y-6 border border-gray-200">
        <h1 class="text-3xl font-bold text-gray-800">📂 Category Management</h1>

        {{-- Alert Message --}}
        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded relative">
                {{ session('message') }}
            </div>
        @endif

        {{-- Form --}}
        <form wire:submit.prevent="submit" class="space-y-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Category Name</label>
                <input wire:key="{{ $selectedCategoryId ?? 'new' }}" wire:model="name" type="text"
                    class="w-full border border-gray-300 bg-white text-gray-800 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 transition" />
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow transition">
                    {{ $selectedCategoryId ? 'Update Category' : 'Add Category' }}
                </button>

                @if ($selectedCategoryId)
                    <button type="button" wire:click="resetInput"
                        class="bg-gray-400 hover:bg-gray-500 text-white px-5 py-2 rounded-lg shadow transition">
                        Cancel
                    </button>
                @endif
            </div>
        </form>

        <hr class="border-gray-300" />

        {{-- Table --}}
        <div class="overflow-x-auto">
            <h2 class="text-xl font-semibold text-gray-800 mb-3">📋 Existing Categories</h2>
            <table class="min-w-full table-auto border-collapse rounded-lg overflow-hidden">
                <thead>
                    <tr class="bg-gray-100 text-gray-800 text-left">
                        <th class="px-4 py-2">#</th>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white text-gray-800 divide-y divide-gray-200">
                    @forelse ($categories as $category)
                        <tr>
                            <td class="px-4 py-2">{{ $category->id }}</td>
                            <td class="px-4 py-2">{{ $category->name }}</td>
                            <td class="px-4 py-2">
                                <button wire:click="editCategory({{ $category->id }})"
                                    class="text-blue-600 hover:text-blue-800 transition font-medium mr-2">
                                    ✏️ Edit
                                </button>
                                <button wire:click="deleteCategory({{ $category->id }})"
                                    class="text-red-600 hover:text-red-800 transition font-medium">
                                    🗑️ Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-4 text-center text-gray-500">No categories found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
