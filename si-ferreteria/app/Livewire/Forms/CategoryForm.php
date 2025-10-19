<?php

namespace App\Livewire\Forms;

use App\Models\Category;
use Livewire\Form;

class CategoryForm extends Form
{
    public $name = '';
    public $category_id = null;
    public $level = 1;
    public $is_active = 1;

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'category_id' => 'nullable|integer|exists:categories,id',
            'level' => 'required|integer|min:1|max:5',
            'is_active' => 'required|boolean',
        ];
    }

    public function updated($propertyName): void
    {
        if ($propertyName === 'category_id') {
            $this->calculateLevel();
        }
    }

    public function calculateLevel(): void
    {
        if (empty($this->category_id)) {
            $this->level = 1;
        } else {
            $parent = Category::find($this->category_id);
            $this->level = $parent ? $parent->level + 1 : 1;
        }
    }

    public function set($category): void
    {
        $this->calculateLevel();
        $this->name = $category->name;
        $this->category_id = $category->category_id;
        $this->level = $category->level;
        $this->is_active = (int)$category->is_active;
    }

    public function getData(): array
    {
        return [
            'name' => $this->name,
            'category_id' => $this->category_id,
            'level' => $this->level,
            'is_active' => (int)$this->is_active,
        ];
    }

    public function reset(...$properties): void
    {
        $this->name = '';
        $this->category_id = null;
        $this->level = 1;
        $this->is_active = 1;
    }
}
