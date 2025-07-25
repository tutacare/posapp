<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;

class CategoryManagement extends Component
{
    public $name;
    public $selectedCategoryId = null;
    public $categories;

    public function mount()
    {
        $this->loadCategories();
    }

    public function render()
    {
        return view('livewire.category-management')->layout('layouts.app');
    }

    public function loadCategories()
    {
        $this->categories = Category::all();
    }

    public function submit()
    {
        if ($this->selectedCategoryId) {
            $this->updateCategory();
        } else {
            $this->createCategory();
        }
    }

    public function createCategory()
    {
        $this->validate([
            'name' => 'required|unique:categories,name',
        ]);

        Category::create(['name' => $this->name]);
        $this->resetInput();
        $this->loadCategories();
        session()->flash('message', 'Category created successfully.');
    }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        $this->selectedCategoryId = $category->id;
        $this->name = $category->name;
    }

    public function updateCategory()
    {
        $this->validate([
            'name' => 'required|unique:categories,name,' . $this->selectedCategoryId,
        ]);

        $category = Category::findOrFail($this->selectedCategoryId);
        $category->update(['name' => $this->name]);
        $this->resetInput();
        $this->loadCategories();
        session()->flash('message', 'Category updated successfully.');
    }

    public function deleteCategory($id)
    {
        Category::destroy($id);
        $this->loadCategories();
        session()->flash('message', 'Category deleted successfully.');
    }

    public function resetInput()
    {
        $this->name = '';
        $this->selectedCategoryId = null;
    }
}
