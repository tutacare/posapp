<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Laba Rugi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Ringkasan Laba Rugi</h3>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-gray-100 p-4 rounded-lg shadow">
            <p class="text-sm text-gray-600">Total Pendapatan</p>
            <p class="text-2xl font-bold text-green-600">Rp {{ number_format($totalRevenue, 2, ',', '.') }}</p>
        </div>
        <div class="bg-gray-100 p-4 rounded-lg shadow">
            <p class="text-sm text-gray-600">Total Biaya</p>
            <p class="text-2xl font-bold text-red-600">Rp {{ number_format($totalCost, 2, ',', '.') }}</p>
        </div>
        <div class="bg-gray-100 p-4 rounded-lg shadow">
            <p class="text-sm text-gray-600">Laba / Rugi</p>
            <p class="text-2xl font-bold {{ $profitOrLoss >= 0 ? 'text-blue-600' : 'text-red-600' }}">Rp {{ number_format($profitOrLoss, 2, ',', '.') }}</p>
        </div>
    </div>
</div>
            </div>
        </div>
    </div>
</x-app-layout>
