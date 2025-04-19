@extends('layouts.app')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-1 gap-6">
    <div class="bg-white p-4 shadow rounded-2xl">
        <h2 class="text-center">
            Selamat Datang,
            @if($toko)
                Di {{ $toko->nama_toko }}!
            @else
                di Aplikasi!
            @endif
        </h2>
        <br>
        <h4 class="font-semibold mb-2">Product Stocks</h4>
        <div class="w-full h-48">
            <canvas id="productChart" class="w-full h-full"></canvas>
        </div>
    </div>

    <div class="bg-white p-4 shadow rounded-2xl">
        <h4 class="font-semibold mb-2">Total Orders per Hari</h4>
        <div class="w-full h-48">
            <canvas id="dailyOrderChart" class="w-full h-full"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Doughnut Chart: Product Stocks
        const productCtx = document.getElementById('productChart').getContext('2d');
        const productNames = @json($products->pluck('name'));
        const productStocks = @json($products->pluck('stock'));

        new Chart(productCtx, {
            type: 'doughnut',
            data: {
                labels: productNames,
                datasets: [{
                    label: 'Stok Produk',
                    data: productStocks,
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(153, 102, 255, 0.6)',
                        'rgba(255, 159, 64, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 205, 86, 0.6)',
                    ],
                    borderColor: '#fff',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });

        // Bar Chart: Daily Orders
        const dailyOrderCtx = document.getElementById('dailyOrderChart').getContext('2d');
        new Chart(dailyOrderCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($days) !!}, // Tanggal-tanggal dalam bulan ini
                datasets: [{
                    label: 'Jumlah Order',
                    data: {!! json_encode($totals) !!}, // Jumlah order tiap hari
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            }
        });
    });
</script>
@endsection
