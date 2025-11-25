<div class="min-h-screen py-8 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        {{-- Header con Título y Filtro de Fecha --}}
        <div class="flex flex-col items-start justify-between gap-4 mb-8 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-3xl font-bold text-white">Dashboard Analítico</h1>
                <p class="mt-1 text-sm text-gray-400">Análisis de rendimiento y métricas clave del negocio</p>
            </div>

            {{-- Filtro de Fecha --}}
            <div class="w-full sm:w-auto">
                <select wire:model.live="dateFilter"
                        class="w-full px-4 py-2 text-gray-200 bg-gray-800 border border-gray-600 rounded-lg shadow-sm sm:w-auto focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    @foreach($filterOptions as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- KPIs Cards --}}
        <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2 lg:grid-cols-4">
            {{-- Ingresos Totales --}}
            <div class="relative p-8 overflow-hidden shadow-lg rounded-2xl" style="background: linear-gradient(135deg, #10B981 0%, #059669 100%);">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <p class="mb-3 text-sm font-medium text-white/90">INGRESOS TOTALES</p>
                        <p class="text-5xl font-bold text-white">
                            ${{ number_format($kpis['total_revenue'], 0) }}
                        </p>
                    </div>
                    <div class="ml-4">
                        <div class="p-4 rounded-full bg-white/20 backdrop-blur-sm">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Ticket Promedio --}}
            <div class="relative p-8 overflow-hidden shadow-lg rounded-2xl" style="background: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%);">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <p class="mb-3 text-sm font-medium text-white/90">TICKET PROMEDIO</p>
                        <p class="text-5xl font-bold text-white">
                            ${{ number_format($kpis['average_ticket'], 0) }}
                        </p>
                    </div>
                    <div class="ml-4">
                        <div class="p-4 rounded-full bg-white/20 backdrop-blur-sm">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Stock Crítico --}}
            <div class="relative p-8 overflow-hidden shadow-lg rounded-2xl" style="background: linear-gradient(135deg, {{ $kpis['critical_stock'] > 0 ? '#EF4444 0%, #DC2626 100%' : '#A855F7 0%, #9333EA 100%' }});">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <p class="mb-3 text-sm font-medium text-white/90">STOCK CRÍTICO</p>
                        <p class="mb-2 text-5xl font-bold text-white">
                            {{ $kpis['critical_stock'] }}
                        </p>
                        @if($kpis['critical_stock'] > 0)
                            <p class="text-xs text-white/80">¡Acción requerida!</p>
                        @else
                            <p class="text-xs text-white/80">Todo en orden</p>
                        @endif
                    </div>
                    <div class="ml-4">
                        <div class="p-4 rounded-full bg-white/20 backdrop-blur-sm">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Egresos/Compras --}}
            <div class="relative p-8 overflow-hidden shadow-lg rounded-2xl" style="background: linear-gradient(135deg, #F97316 0%, #EA580C 100%);">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <p class="mb-3 text-sm font-medium text-white/90">EGRESOS/COMPRAS</p>
                        <p class="text-5xl font-bold text-white">
                            ${{ number_format($kpis['total_expenses'], 0) }}
                        </p>
                    </div>
                    <div class="ml-4">
                        <div class="p-4 rounded-full bg-white/20 backdrop-blur-sm">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Gráfico de Tendencia de Ventas --}}
        <div class="p-6 mb-8 bg-gray-800 border border-gray-700 shadow-md rounded-xl">
            <h2 class="mb-6 text-xl font-bold text-white">Tendencia de Ventas</h2>
            <div wire:key="chart-{{ $dateFilter }}"
                 id="sales-chart"
                 class="w-full"
                 style="min-height: 350px;"
                 data-categories='@json($salesChartData["categories"])'
                 data-sales='@json($salesChartData["data"])'></div>
        </div>

        {{-- Tablas de Ranking --}}
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
            {{-- Top 5 Productos Más Vendidos --}}
            <div class="p-6 bg-gray-800 border border-gray-700 shadow-md rounded-xl">
                <h2 class="flex items-center mb-6 text-xl font-bold text-white">
                    <svg class="w-6 h-6 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    Top 5 Productos Más Vendidos
                </h2>

                @if(count($topProducts) > 0)
                    <div class="space-y-4">
                        @foreach($topProducts as $index => $product)
                            <div class="flex items-center justify-between p-4 transition-colors duration-200 bg-gray-700 rounded-lg hover:bg-gray-600">
                                <div class="flex items-center flex-1 gap-4">
                                    <div class="flex-shrink-0">
                                        <span class="inline-flex items-center justify-center w-8 h-8 text-sm font-bold text-white bg-blue-500 rounded-full">
                                            {{ $index + 1 }}
                                        </span>
                                    </div>
                                    @if($product['image'])
                                        <img src="{{ Storage::url($product['image']) }}"
                                             alt="{{ $product['name'] }}"
                                             class="object-cover w-12 h-12 border border-gray-600 rounded-lg">
                                    @else
                                        <div class="flex items-center justify-center w-12 h-12 bg-gray-600 rounded-lg">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-200 truncate">{{ $product['name'] }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold text-blue-400">{{ number_format($product['quantity']) }}</p>
                                    <p class="text-xs text-gray-400">unidades</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-8 text-center text-gray-400">
                        <svg class="w-16 h-16 mx-auto mb-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <p>No hay datos disponibles</p>
                    </div>
                @endif
            </div>

            {{-- Top 5 Productos Mejor Calificados --}}
            <div class="p-6 bg-gray-800 border border-gray-700 shadow-md rounded-xl">
                <h2 class="flex items-center mb-6 text-xl font-bold text-white">
                    <svg class="w-6 h-6 mr-2 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                    </svg>
                    Top 5 Productos Mejor Calificados
                </h2>

                @if(count($topRatedProducts) > 0)
                    <div class="space-y-4">
                        @foreach($topRatedProducts as $index => $product)
                            <div class="flex items-center justify-between p-4 transition-colors duration-200 bg-gray-700 rounded-lg hover:bg-gray-600">
                                <div class="flex items-center flex-1 gap-4">
                                    <div class="flex-shrink-0">
                                        <span class="inline-flex items-center justify-center w-8 h-8 text-sm font-bold text-white bg-yellow-500 rounded-full">
                                            {{ $index + 1 }}
                                        </span>
                                    </div>
                                    @if($product['image'])
                                        <img src="{{ Storage::url($product['image']) }}"
                                             alt="{{ $product['name'] }}"
                                             class="object-cover w-12 h-12 border border-gray-600 rounded-lg">
                                    @else
                                        <div class="flex items-center justify-center w-12 h-12 bg-gray-600 rounded-lg">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-200 truncate">{{ $product['name'] }}</p>
                                        <p class="text-xs text-gray-400">{{ $product['review_count'] }} reseñas</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="flex items-center gap-1 mb-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= floor($product['rating']))
                                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                                </svg>
                                            @elseif($i - 0.5 <= $product['rating'])
                                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                                                    <defs>
                                                        <linearGradient id="half-{{ $index }}-{{ $i }}">
                                                            <stop offset="50%" stop-color="currentColor"/>
                                                            <stop offset="50%" stop-color="#D1D5DB"/>
                                                        </linearGradient>
                                                    </defs>
                                                    <path fill="url(#half-{{ $index }}-{{ $i }})" d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                                </svg>
                                            @else
                                                <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                                </svg>
                                            @endif
                                        @endfor
                                    </div>
                                    <p class="text-sm font-bold text-gray-200">{{ number_format($product['rating'], 1) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-8 text-center text-gray-400">
                        <svg class="w-16 h-16 mx-auto mb-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                        <p>No hay datos disponibles</p>

                    </div>
                @endif
            </div>
        </div>

        {{-- Productos con Stock Crítico --}}
        @if(count($criticalStockProducts) > 0)
            <div class="mt-8">
                <div class="p-6 bg-gray-800 border border-gray-700 shadow-md rounded-xl">
                    <h2 class="flex items-center mb-6 text-xl font-bold text-white">
                        <svg class="w-6 h-6 mr-2 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        Productos con Stock Crítico
                        <span class="px-3 py-1 ml-3 text-sm font-bold text-white bg-red-500 rounded-full">
                            {{ count($criticalStockProducts) }}
                        </span>
                    </h2>

                    <div class="space-y-3">
                        @foreach($criticalStockProducts as $product)
                            <div class="flex items-center justify-between p-4 transition-colors duration-200 rounded-lg {{ $product['status'] === 'sin_stock' ? 'bg-red-900/30 border border-red-700/50' : 'bg-orange-900/30 border border-orange-700/50' }}">
                                <div class="flex items-center flex-1 gap-4">
                                    @if($product['image'])
                                        <img src="{{ Storage::url($product['image']) }}"
                                             alt="{{ $product['name'] }}"
                                             class="object-cover w-12 h-12 border border-gray-600 rounded-lg">
                                    @else
                                        <div class="flex items-center justify-center w-12 h-12 bg-gray-700 rounded-lg">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-200 truncate">{{ $product['name'] }}</p>
                                        <p class="text-xs text-gray-400">Stock mínimo: {{ $product['min_stock'] }} unidades</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    @if($product['status'] === 'sin_stock')
                                        <p class="text-lg font-bold text-red-400">{{ $product['stock'] }}</p>
                                        <p class="text-xs font-semibold text-red-300">SIN STOCK</p>
                                    @else
                                        <p class="text-lg font-bold text-orange-400">{{ $product['stock'] }}</p>
                                        <p class="text-xs font-semibold text-orange-300">BAJO STOCK</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="p-4 mt-6 border border-yellow-700 rounded-lg bg-yellow-900/20">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 mt-0.5 mr-3 text-yellow-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            <div>
                                <h3 class="text-sm font-semibold text-yellow-200">Acción requerida</h3>
                                <p class="mt-1 text-xs text-yellow-300">Estos productos requieren atención inmediata. Considera realizar un pedido de reabastecimiento.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

{{-- ApexCharts CDN y Script de Inicialización --}}
@assets
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@endassets

<script>
    // Observador para detectar cuando se crea/recrea el elemento del gráfico
    const observer = new MutationObserver(function(mutations) {
        const chartElement = document.querySelector('#sales-chart');
        if (chartElement && !chartElement.hasAttribute('data-initialized')) {
            initializeChart(chartElement);
        }
    });

    // Observar cambios en el documento
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });

    // Función para inicializar el gráfico
    function initializeChart(chartElement) {
        // Marcar como inicializado
        chartElement.setAttribute('data-initialized', 'true');

        // Leer datos de los atributos
        const categories = JSON.parse(chartElement.getAttribute('data-categories') || '[]');
        const data = JSON.parse(chartElement.getAttribute('data-sales') || '[]');

        console.log('📊 Inicializando gráfico:', {
            categoriesCount: categories.length,
            dataCount: data.length,
            firstCategory: categories[0],
            lastCategory: categories[categories.length - 1]
        });

        const options = {
            series: [{
                name: 'Ventas',
                data: data
            }],
            chart: {
                type: 'area',
                height: 350,
                background: '#1F2937',
                toolbar: {
                    show: true,
                    tools: {
                        download: true,
                        selection: false,
                        zoom: false,
                        zoomin: false,
                        zoomout: false,
                        pan: false,
                        reset: false
                    }
                },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800
                }
            },
            colors: ['#10B981'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.2,
                    stops: [0, 90, 100]
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            xaxis: {
                categories: categories,
                labels: {
                    style: {
                        fontSize: '12px',
                        fontWeight: 500,
                        colors: '#9CA3AF'
                    }
                },
                axisBorder: {
                    color: '#374151'
                },
                axisTicks: {
                    color: '#374151'
                }
            },
            yaxis: {
                labels: {
                    formatter: function (value) {
                        return '$' + value.toLocaleString('es-ES', {minimumFractionDigits: 0, maximumFractionDigits: 0});
                    },
                    style: {
                        fontSize: '12px',
                        fontWeight: 500,
                        colors: '#9CA3AF'
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: function (value) {
                        return '$' + value.toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    }
                },
                theme: 'dark'
            },
            grid: {
                borderColor: '#374151',
                strokeDashArray: 4
            }
        };

        try {
            const chart = new ApexCharts(chartElement, options);
            chart.render();
            console.log('✅ Gráfico renderizado exitosamente con', categories.length, 'puntos');
        } catch (error) {
            console.error('❌ Error al renderizar gráfico:', error);
        }
    }

    // Inicializar si el elemento ya existe
    document.addEventListener('DOMContentLoaded', function() {
        const chartElement = document.querySelector('#sales-chart');
        if (chartElement) {
            initializeChart(chartElement);
        }
    });
</script>
