<x-app-layout>
    <div class="py-12">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-3">
            <div class="p-6 text-gray-900">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Grafik Penjualan</h3>
                <div class="flex justify-end mb-4">
                    <button id="dailyBtn"
                        class="px-4 py-2 mr-2 rounded-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Harian</button>
                    <button id="monthlyBtn"
                        class="px-4 py-2 rounded-md text-sm font-medium text-gray-700 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">Bulanan</button>
                </div>
                <div id="salesChart"></div>
            </div>
        </div>
    </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var options = {
                    chart: {
                        type: 'line',
                        height: 350
                    },
                    series: [],
                    xaxis: {
                        categories: []
                    },
                    noData: {
                        text: 'Loading...'
                    }
                };

                var chart = new ApexCharts(document.querySelector("#salesChart"), options);
                chart.render();

                function loadSalesData(period) {
                    fetch(`/dashboard/sales-data?period=${period}`)
                        .then(response => response.json())
                        .then(data => {
                            chart.updateOptions({
                                xaxis: {
                                    categories: data.categories
                                },
                                noData: {
                                    text: 'Tidak ada data penjualan.'
                                }
                            });
                            chart.updateSeries(data.series);
                        })
                        .catch(error => {
                            console.error('Error fetching sales data:', error);
                            chart.updateOptions({
                                noData: {
                                    text: 'Gagal memuat data penjualan.'
                                }
                            });
                        });
                }

                // Load daily data by default
                loadSalesData('daily');

                // Event listeners for buttons
                document.getElementById('dailyBtn').addEventListener('click', function() {
                    loadSalesData('daily');
                    this.classList.remove('bg-gray-200', 'text-gray-700');
                    this.classList.add('bg-blue-600', 'text-white');
                    document.getElementById('monthlyBtn').classList.remove('bg-blue-600', 'text-white');
                    document.getElementById('monthlyBtn').classList.add('bg-gray-200', 'text-gray-700');
                });

                document.getElementById('monthlyBtn').addEventListener('click', function() {
                    loadSalesData('monthly');
                    this.classList.remove('bg-gray-200', 'text-gray-700');
                    this.classList.add('bg-blue-600', 'text-white');
                    document.getElementById('dailyBtn').classList.remove('bg-blue-600', 'text-white');
                    document.getElementById('dailyBtn').classList.add('bg-gray-200', 'text-gray-700');
                });
            });
        </script>
    @endpush
</x-app-layout>
