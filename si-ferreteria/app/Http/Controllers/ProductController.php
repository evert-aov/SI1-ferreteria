<?php

namespace App\Http\Controllers;

use App\Models\Inventory\Product;
use App\Models\Inventory\Category;
use App\Models\Inventory\Brand;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand', 'color'])
            ->active();

        // Búsqueda
        if ($request->filled('search'))
            $query->search($request->search);

        // Filtro por categoría
        if ($request->filled('category_id'))
            $query->where('category_id', $request->category_id);

        // Filtro por marca
        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        // Filtro por rango de precio
        if ($request->filled('min_price')) {
            $query->where('sale_price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('sale_price', '<=', $request->max_price);
        }

        // Ordenamiento
        $sortBy = $request->get('sort', 'relevance');
        switch ($sortBy) {
            case 'price_asc':
                $query->orderBy('sale_price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('sale_price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('id', 'desc');
        }

        $products = $query->paginate(12)->withQueryString();

        // Para los filtros
        $categories = Category::where('level', 3)->orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();

        // Rango de precios
        $priceRange = Product::active()
            ->selectRaw('MIN(sale_price) as min_price, MAX(sale_price) as max_price')
            ->first();

        return view('products.index', compact(
            'products',
            'categories',
            'brands',
            'priceRange'
        ));
    }

    public function show($id)
    {
        $product = Product::with([
            'category',
            'brand',
            'color',
            'measure',
            'volume',
            'technicalSpecifications'
        ])->findOrFail($id);

        // Productos relacionados (misma categoría)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->active()
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
