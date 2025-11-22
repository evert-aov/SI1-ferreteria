<div>
<style>
    /* Estilos para inputs y selects en modo oscuro */
    .dark-input:focus,
    .dark-select:focus {
        background: #4b5563 !important;
        border-color: #f97316 !important;
        color: #e5e7eb !important;
        box-shadow: 0 0 0 0.25rem rgba(249, 115, 22, 0.25);
    }
    
    .dark-input::placeholder {
        color: #9ca3af;
    }
    
    select.dark-select option {
        background: #1f2937;
        color: #e5e7eb;
    }
    
    /* Checkbox personalizado */
    .custom-checkbox:checked {
        background-color: #f97316 !important;
        border-color: #f97316 !important;
    }
    
    .custom-checkbox:focus {
        box-shadow: 0 0 0 0.25rem rgba(249, 115, 22, 0.25);
    }
    
    /* Botones de vista */
    .view-btn {
        transition: all 0.3s ease;
    }
    
    .view-btn:hover {
        transform: scale(1.05);
    }
    
    /* Hover para botón limpiar */
    .hover-scale:hover {
        transform: scale(1.05);
        background: rgba(255, 255, 255, 0.2) !important;
    }
</style>

<div class="container-fluid py-4">
    <div class="row">
        <!-- SIDEBAR DE FILTROS -->
        <div class="col-lg-3 col-md-4 mb-4">
            <div class="card shadow-lg" style="background: #1f2937; border: 1px solid #374151;">
                <div class="card-header d-flex justify-content-between align-items-center" 
                     style="background: linear-gradient(135deg, #ea580c 0%, #f97316 100%); border: none;">
                    <h5 class="mb-0 text-white">
                        <i class="bi bi-funnel-fill"></i> Filtros
                    </h5>
                    <button wire:click="clearFilters" 
                            class="btn btn-sm btn-outline-light hover-scale"
                            style="border-color: white; transition: all 0.3s;">
                        <i class="bi bi-x-circle"></i> Limpiar
                    </button>
                </div>
                <div class="card-body">
                    <!-- Búsqueda -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-light">
                            <i class="bi bi-search"></i> Buscar
                        </label>
                        <input type="text" 
                               class="form-control dark-input" 
                               wire:model.live.debounce.300ms="search" 
                               placeholder="Nombre del producto..."
                               style="background: #374151; border-color: #4b5563; color: #e5e7eb;">
                    </div>

                    <hr style="border-color: #4b5563;">

                    <!-- Categorías -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-light">
                            <i class="bi bi-tag-fill"></i> Categoría
                        </label>
                        <select class="form-select dark-select" 
                                wire:model.live="selectedCategory"
                                style="background: #374151; border-color: #4b5563; color: #e5e7eb;">
                            <option value="">Todas las categorías</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }} ({{ $category->products_count }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Marcas -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-light">
                            <i class="bi bi-award-fill"></i> Marca
                        </label>
                        <select class="form-select dark-select" 
                                wire:model.live="selectedBrand"
                                style="background: #374151; border-color: #4b5563; color: #e5e7eb;">
                            <option value="">Todas las marcas</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Colores -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-light">
                            <i class="bi bi-palette-fill"></i> Color
                        </label>
                        <select class="form-select dark-select" 
                                wire:model.live="selectedColor"
                                style="background: #374151; border-color: #4b5563; color: #e5e7eb;">
                            <option value="">Todos los colores</option>
                            @foreach($colors as $color)
                                <option value="{{ $color->id }}">{{ $color->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <hr style="border-color: #4b5563;">

                    <!-- Rango de Precios -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-light">
                            <i class="bi bi-cash-stack"></i> Rango de Precio
                        </label>
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="number" 
                                       class="form-control form-control-sm dark-input" 
                                       wire:model.live.debounce.500ms="minPrice" 
                                       placeholder="Mínimo" 
                                       step="0.01"
                                       style="background: #374151; border-color: #4b5563; color: #e5e7eb;">
                            </div>
                            <div class="col-6">
                                <input type="number" 
                                       class="form-control form-control-sm dark-input" 
                                       wire:model.live.debounce.500ms="maxPrice" 
                                       placeholder="Máximo" 
                                       step="0.01"
                                       style="background: #374151; border-color: #4b5563; color: #e5e7eb;">
                            </div>
                        </div>
                    </div>

                    <hr style="border-color: #4b5563;">

                    <!-- Solo en Stock -->
                    <div class="form-check">
                        <input class="form-check-input custom-checkbox" 
                               type="checkbox" 
                               wire:model.live="onlyInStock" 
                               id="onlyInStock"
                               style="background: #374151; border-color: #f97316;">
                        <label class="form-check-label text-light" for="onlyInStock">
                            <i class="bi bi-box-seam-fill"></i> Solo productos en stock
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- ÁREA DE PRODUCTOS -->
        <div class="col-lg-9 col-md-8">
            <!-- Barra de herramientas -->
            <div class="card shadow-lg mb-3" style="background: #1f2937; border: 1px solid #374151;">
                <div class="card-body py-3">
                    <div class="row align-items-center">
                        <div class="col-md-6 mb-2 mb-md-0">
                            <span class="text-light">
                                <i class="bi bi-box2-fill"></i> Mostrando 
                                <strong style="color: #f97316;">{{ $products->count() }}</strong> de 
                                <strong style="color: #f97316;">{{ $products->total() }}</strong> productos
                            </span>
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="btn-group btn-group-sm me-2" role="group">
                                <button type="button" 
                                        class="btn view-btn {{ $viewMode === 'grid' ? 'active' : '' }}" 
                                        wire:click="setViewMode('grid')"
                                        style="border-color: #f97316; {{ $viewMode === 'grid' ? 'background: #f97316; color: white;' : 'background: #374151; color: #e5e7eb;' }}">
                                    <i class="bi bi-grid-3x3-gap-fill"></i>
                                </button>
                                <button type="button" 
                                        class="btn view-btn {{ $viewMode === 'list' ? 'active' : '' }}" 
                                        wire:click="setViewMode('list')"
                                        style="border-color: #f97316; {{ $viewMode === 'list' ? 'background: #f97316; color: white;' : 'background: #374151; color: #e5e7eb;' }}">
                                    <i class="bi bi-list-ul"></i>
                                </button>
                            </div>

                            <select class="form-select form-select-sm d-inline-block w-auto" 
                                    wire:model.live="sortBy"
                                    style="background: #374151; border-color: #4b5563; color: #e5e7eb;">
                                <option value="newest">Más recientes</option>
                                <option value="name">Nombre A-Z</option>
                                <option value="price_asc">Precio: Menor a Mayor</option>
                                <option value="price_desc">Precio: Mayor a Menor</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grid de Productos -->
            @if($products->count() > 0)
                @if($viewMode === 'grid')
                    <div class="row g-3">
                        @foreach($products as $product)
                            <div class="col-lg-4 col-md-6">
                                @include('livewire.ecommerce.catalog.partials.product-card')
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="list-group">
                        @foreach($products as $product)
                            @include('livewire.ecommerce.catalog.partials.product-list-item')
                        @endforeach
                    </div>
                @endif

                <!-- Paginación -->
                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            @else
                <div class="alert text-center" style="background: #374151; border: 2px solid #f97316; color: #e5e7eb; border-radius: 12px;">
                    <i class="bi bi-info-circle-fill fs-3 d-block mb-3" style="color: #f97316;"></i>
                    <h5 style="color: #e5e7eb;">No se encontraron productos</h5>
                    <p class="mb-0" style="color: #9ca3af;">
                        No hay productos que coincidan con los filtros seleccionados. Intenta ajustar tus criterios de búsqueda.
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
</div>