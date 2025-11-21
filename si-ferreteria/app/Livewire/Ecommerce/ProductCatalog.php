<?php

namespace App\Livewire\Ecommerce;

use App\Models\Inventory\Brand;
use App\Models\Inventory\Category;
use App\Models\Inventory\Color;
use App\Models\Inventory\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class ProductCatalog extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Usar atributos URL de Livewire 3 (más robusto)
    #[Url(as: 's', except: '')]
    public $search = '';
    
    #[Url(as: 'cat', except: null)]
    public $selectedCategory = null;
    
    #[Url(as: 'brand', except: null)]
    public $selectedBrand = null;
    
    #[Url(as: 'color', except: null)]
    public $selectedColor = null;
    
    #[Url(as: 'sort', except: 'newest')]
    public $sortBy = 'newest';
    
    public $minPrice = null;
    public $maxPrice = null;
    public $viewMode = 'grid';
    public $perPage = 12;
    public $onlyInStock = false;

    // Método para resetear página en cualquier cambio
    public function updated($propertyName)
    {
        // No resetear página en cambios de vista
        if (!in_array($propertyName, ['viewMode', 'perPage'])) {
            $this->resetPage();
        }
    }

    public function clearFilters()
    {
        $this->reset([
            'search',
            'selectedCategory',
            'selectedBrand',
            'selectedColor',
            'minPrice',
            'maxPrice',
            'onlyInStock',
            'sortBy'
        ]);
        $this->resetPage();
    }

    public function setViewMode($mode)
    {
        $this->viewMode = $mode;
    }

    public function render()
    {
        $products = Product::query()
            ->with(['category', 'brand', 'color', 'measure', 'volume'])
            ->active()
            ->when($this->search, fn($q) => $q->search($this->search))
            ->when($this->selectedCategory, fn($q) => $q->where('category_id', $this->selectedCategory))
            ->when($this->selectedBrand, fn($q) => $q->where('brand_id', $this->selectedBrand))
            ->when($this->selectedColor, fn($q) => $q->where('color_id', $this->selectedColor))
            ->when($this->minPrice, fn($q) => $q->where('sale_price', '>=', $this->minPrice))
            ->when($this->maxPrice, fn($q) => $q->where('sale_price', '<=', $this->maxPrice))
            ->when($this->onlyInStock, fn($q) => $q->where('stock', '>', 0))
            ->when($this->sortBy === 'price_asc', fn($q) => $q->orderBy('sale_price', 'asc'))
            ->when($this->sortBy === 'price_desc', fn($q) => $q->orderBy('sale_price', 'desc'))
            ->when($this->sortBy === 'name', fn($q) => $q->orderBy('name', 'asc'))
            ->when($this->sortBy === 'newest', fn($q) => $q->latest())
            ->paginate($this->perPage);

        $categories = Category::withCount('products')->get();
        $brands = Brand::has('products')->get();
        $colors = Color::has('products')->get();

        return view('livewire.ecommerce.catalog.product-catalog', [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
            'colors' => $colors,
        ])->layout('layouts.catalog');
    }
}