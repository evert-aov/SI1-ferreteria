<?php

namespace App\Livewire\Catalog;

use App\Models\Inventory\Product;
use Livewire\Component;

class ProductDetail extends Component
{
    public Product $product;
    public $relatedProducts = [];

    public function mount($id)
    {
        $this->product = Product::with([
            'category',
            'brand',
            'color',
            'measure',
            'volume',
            'technicalSpecifications'
        ])->findOrFail($id);

        // Productos relacionados (misma categoría)
        $this->relatedProducts = Product::active()
            ->where('category_id', $this->product->category_id)
            ->where('id', '!=', $this->product->id)
            ->inRandomOrder()
            ->limit(4)
            ->get();
    }

    public function render()
    {
        return view('livewire.catalog.product-detail')
            ->layout('layouts.catalog'); // ← AGREGA ESTA LÍNEA
    }
}