<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" />
    @livewireStyles
</head>

<div class="min-h-screen bg-gray-100 flex" x-data="{ sidebarOpen: window.innerWidth >= 1024 }"
    @resize.window="sidebarOpen = window.innerWidth >= 1024">
    <!-- Overlay -->
    <div x-show="sidebarOpen && window.innerWidth < 1024" x-transition.opacity.duration.300ms
        class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden" @click="sidebarOpen = false"></div>

    <!-- Sidebar -->
    <aside
        class="bg-gradient-to-br from-gray-800 to-gray-900 text-white flex-shrink-0 shadow-lg print:hidden transition-all duration-300 ease-in-out fixed inset-y-0 left-0 z-40 lg:static"
        :class="sidebarOpen ? 'w-64' : 'w-0 lg:w-20'">
        <div class="p-6 border-b border-gray-700 flex items-center justify-between"
            :class="sidebarOpen ? '' : 'justify-center'">
            <h1 class="text-3xl font-extrabold text-indigo-400" x-show="sidebarOpen">POS App</h1>
            <button @click="sidebarOpen = !sidebarOpen" class="text-white focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>
        </div>
        <nav class="mt-8 space-y-2">
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                class="flex items-center px-6 py-3 text-lg font-medium text-white hover:bg-gray-700 hover:text-white transition duration-200 ease-in-out rounded-md mx-3">
                <svg class="w-5 h-5" :class="sidebarOpen ? 'mr-3' : ''" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m0 0l7 7m-2 2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                    </path>
                </svg>
                <span x-show="sidebarOpen">{{ __('Dashboard') }}</span>
            </x-nav-link>

            @role('Admin')
                <x-nav-link :href="route('category.management')" :active="request()->routeIs('category.management')"
                    class="flex items-center px-6 py-3 text-lg font-medium text-white hover:bg-gray-700 hover:text-white transition duration-200 ease-in-out rounded-md mx-3">
                    <svg class="w-5 h-5" :class="sidebarOpen ? 'mr-3' : ''" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2H7a2 2 0 00-2 2v2m7-7V3m0 0V3a2 2 0 012-2h2a2 2 0 012 2v2m-6 0h6">
                        </path>
                    </svg>
                    <span x-show="sidebarOpen">{{ __('Category Management') }}</span>
                </x-nav-link>

                <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.index')"
                    class="flex items-center px-6 py-3 text-lg font-medium text-white hover:bg-gray-700 hover:text-white transition duration-200 ease-in-out rounded-md mx-3">
                    <svg class="w-5 h-5" :class="sidebarOpen ? 'mr-3' : ''" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4">
                        </path>
                    </svg>
                    <span x-show="sidebarOpen">{{ __('Product Management') }}</span>
                </x-nav-link>

                <x-nav-link :href="route('reports.profit-loss')" :active="request()->routeIs('reports.profit-loss')"
                    class="flex items-center px-6 py-3 text-lg font-medium text-white hover:bg-gray-700 hover:text-white transition duration-200 ease-in-out rounded-md mx-3">
                    <svg class="w-5 h-5" :class="sidebarOpen ? 'mr-3' : ''" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4">
                        </path>
                    </svg>
                    <span x-show="sidebarOpen">{{ __('Laporan Laba Rugi') }}</span>
                </x-nav-link>
            @endrole
            @hasanyrole(['Admin', 'Cashier'])
                <x-nav-link :href="route('pos.index')" :active="request()->routeIs('pos.index')"
                    class="flex items-center px-6 py-3 text-lg font-medium text-white hover:bg-gray-700 hover:text-white transition duration-200 ease-in-out rounded-md mx-3">
                    <svg class="w-5 h-5" :class="sidebarOpen ? 'mr-3' : ''" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                    <span x-show="sidebarOpen">{{ __('POS') }}</span>
                </x-nav-link>

                <x-nav-link :href="route('orders.completed')" :active="request()->routeIs('orders.completed')"
                    class="flex items-center px-6 py-3 text-lg font-medium text-white hover:bg-gray-700 hover:text-white transition duration-200 ease-in-out rounded-md mx-3">
                    <svg class="w-5 h-5" :class="sidebarOpen ? 'mr-3' : ''" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 4H7a2 2 0 01-2-2V6a2 2 0 012-2h4l2 2h6a2 2 0 012 2v12a2 2 0 01-2 2z" />
                    </svg>
                    <span x-show="sidebarOpen">{{ __('Completed Orders') }}</span>
                </x-nav-link>
            @endhasanyrole
        </nav>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden" :class="sidebarOpen ? 'ml-0' : 'ml-0'">
        @include('layouts.navigation', ['header' => $header ?? null])



        <!-- Page Content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
            {{ $slot }}
        </main>
    </div>
</div>
@livewireScripts
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@stack('scripts')
</body>

</html>
