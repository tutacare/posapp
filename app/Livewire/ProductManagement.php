<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;

class ProductManagement extends Component
{
    public $products, $categories;
    public $name, $description, $price, $stock, $category_id, $selectedProductId;

    public function mount()
    {
        $this->categories = Category::all();
        $this->loadProducts();
    }

    public function render()
    {
        return view('livewire.product-management')->layout('layouts.app');
    }

    public function loadProducts()
    {
        $this->products = Product::with('category')->latest()->get();
    }

    public function resetInput()
    {
        $this->name = '';
        $this->description = '';
        $this->price = '';
        $this->stock = '';
        $this->category_id = '';
        $this->selectedProductId = null;
    }

    public function createProduct()
    {
        $this->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
        ]);

        Product::create([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
            'category_id' => $this->category_id
        ]);

        $this->resetInput();
        $this->loadProducts();
        session()->flash('message', 'Product added successfully.');
    }

    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $this->selectedProductId = $product->id;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->stock = $product->stock;
        $this->category_id = $product->category_id;
    }

    public function updateProduct()
    {
        $this->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
        ]);

        Product::findOrFail($this->selectedProductId)->update([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
            'category_id' => $this->category_id
        ]);

        $this->resetInput();
        $this->loadProducts();
        session()->flash('message', 'Product updated.');
    }

    public function deleteProduct($id)
    {
        Product::findOrFail($id)->delete();
        $this->loadProducts();
        session()->flash('message', 'Product deleted.');
    }
}
