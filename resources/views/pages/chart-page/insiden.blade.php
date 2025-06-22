@extends('layouts.master')
@section('title', 'Insiden Chart')
@section('content')

<div class="max-w-7xl mx-auto px-4 py-6">
    <h1 class="text-2xl font-semibold mb-6 text-gray-800">Insiden</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Bar Chart: Insiden per Bulan -->
        <div class="bg-white rounded-lg shadow p-4 overflow-hidden col-span-2">
            <h2 class="text-lg font-medium mb-2 text-gray-700">Jumlah Insiden per Bulan</h2>
            <canvas id="barInsidenBulan"></canvas>
        </div>

        <!-- Line Chart: Heatmap Kalender (Tren Waktu) -->
        <div class="bg-white rounded-lg shadow p-4 overflow-hidden col-span-2">
            <h2 class="text-lg font-medium mb-2 text-gray-700">Kapan Insiden Terjadi</h2>
            <canvas id="lineHeatmapInsiden"></canvas>
        </div>

        <!-- Horizontal Bar: Lokasi -->
        <div class="bg-white rounded-lg shadow p-4 overflow-hidden">
            <h2 class="text-lg font-medium mb-2 text-gray-700">Lokasi Insiden</h2>
            <canvas id="barLokasiInsiden"></canvas>
        </div>

        <!-- Pie Chart: Jenis Insiden -->
        <div class="bg-white rounded-lg shadow p-4 overflow-hidden">
            <h2 class="text-lg font-medium mb-2 text-gray-700">Proporsi Jenis Insiden</h2>
            <canvas id="pieJenisInsiden"></canvas>
        </div>

        <!-- Pie Chart: Proporsi Insiden per Departemen -->
        <div class="bg-white rounded-lg shadow p-4 overflow-hidden col-span-2">
            <h2 class="text-lg font-medium mb-2 text-gray-700">Proporsi Insiden per Departemen</h2>
            <canvas id="pieDepartemen"></canvas>
        </div>

    </div>
</div>

<script>
fetch('/api/chart/insiden')
    .then(res => res.json())
    .then(data => {
        const MONTHS = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        function sortBulanTahun(keys) {
            return keys.sort((a, b) => {
                const [bulanA, tahunA] = a.split(' ');
                const [bulanB, tahunB] = b.split(' ');
                return tahunA - tahunB || MONTHS.indexOf(bulanA) - MONTHS.indexOf(bulanB);
            });
        }

        const perBulan = {}, perJenis = {}, perKalender = {}, perLokasi = {}, perDepartemen = {};

        data.forEach(item => {
            const label = `${item.bulan} ${item.tahun}`;
            const dep = item.departemen;

            perBulan[label] = (perBulan[label] || 0) + 1;
            perJenis[item.jenis_insiden] = (perJenis[item.jenis_insiden] || 0) + 1;
            perKalender[label] = (perKalender[label] || 0) + 1;
            perLokasi[item.lokasi] = (perLokasi[item.lokasi] || 0) + 1;
            perDepartemen[dep] = (perDepartemen[dep] || 0) + 1;
        });

        const sortedLabels = sortBulanTahun(Object.keys(perBulan));

        // 📊 Bar Chart
        new Chart(barInsidenBulan, {
            type: 'bar',
            data: {
                labels: sortedLabels,
                datasets: [{
                    label: 'Jumlah Insiden',
                    data: sortedLabels.map(k => perBulan[k]),
                    backgroundColor: 'rgba(255, 99, 132, 0.6)'
                }]
            },
            options: {
                plugins: {
                    datalabels: {
                        anchor: 'end', align: 'top',
                        font: { weight: 'bold' },
                        formatter: v => v,
                        color: '#333'
                    }
                },
                scales: { y: { beginAtZero: true } },
                responsive: true
            },
            plugins: [ChartDataLabels]
        });

        // 🎯 Pie Chart Jenis Insiden
        new Chart(pieJenisInsiden, {
            type: 'pie',
            data: {
                labels: Object.keys(perJenis),
                datasets: [{
                    data: Object.values(perJenis),
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56']
                }]
            },
            options: {
                plugins: {
                    datalabels: {
                        color: '#fff',
                        font: { weight: 'bold' },
                        formatter: (value, context) => {
                            const total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                            return `${value} (${(value / total * 100).toFixed(1)}%)`;
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });

        // 🔥 Line Chart (Tren Kalender / Heatmap)
        const heatLabels = sortBulanTahun(Object.keys(perKalender));
        new Chart(lineHeatmapInsiden, {
            type: 'line',
            data: {
                labels: heatLabels,
                datasets: [{
                    label: 'Tren Insiden',
                    data: heatLabels.map(k => perKalender[k]),
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.15)',
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                plugins: {
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        font: { weight: 'bold' },
                        formatter: v => v,
                        color: '#333'
                    }
                },
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            },
            plugins: [ChartDataLabels]
        });

        // 📍 Lokasi Insiden Horizontal Bar
        const lokasiLabels = Object.keys(perLokasi);
        new Chart(barLokasiInsiden, {
            type: 'bar',
            data: {
                labels: lokasiLabels,
                datasets: [{
                    label: 'Jumlah Insiden',
                    data: lokasiLabels.map(k => perLokasi[k]),
                    backgroundColor: 'rgba(75, 192, 192, 0.6)'
                }]
            },
            options: {
                indexAxis: 'y',
                plugins: {
                    datalabels: {
                        anchor: 'center',
                        align: 'right',
                        font: { weight: 'bold' },
                        formatter: v => v,
                        color: '#000'
                    }
                },
                scales: { x: { beginAtZero: true } },
                responsive: true
            },
            plugins: [ChartDataLabels]
        });

       // 📈 Bar Chart Departemen
        new Chart(pieDepartemen, {
            type: 'bar',
            data: {
                labels: Object.keys(perDepartemen),
                datasets: [{
                    label: 'Jumlah Insiden',
                    data: Object.values(perDepartemen),
                    backgroundColor: [
                        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                        '#9966FF', '#F77825', '#00A65A'
                    ]
                }]
            },
            options: {
                plugins: {
                    datalabels: {
                        color: '#000',
                        font: { weight: 'bold' },
                        formatter: (value) => value
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                responsive: true
            },
            plugins: [ChartDataLabels]
        });


    });
</script>

@endsection
