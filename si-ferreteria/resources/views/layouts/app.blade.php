<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }} ">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Ferreteria Nando'  }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-900 ">
    @include('layouts.navigation')
    @include('layouts.sidebar')

    <div class="ml-0 sm:ml-64  dark:bg-gray-900">

        <!-- Page Heading -->
        @isset($header)
            <header class="dark:bg-gray-800 shadow">
                {{ $header }}
            </header>
        @endisset
        <x-gradient-div>
            <x-container-div>

                <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main>
            </x-container-div>
        </x-gradient-div>
    </div>

    <!-- Componente de alertas de productos -->
    @auth
        <livewire:toast-manager />
    @endauth
</div>
@livewireScripts
</body>
</html>
