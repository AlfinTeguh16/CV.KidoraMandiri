@extends('layouts.master')
@section('title', 'Turnover Chart')
@section('content')


<div class="max-w-7xl mx-auto px-4 py-6">
    <h1 class="text-2xl font-semibold mb-6 text-gray-800">Turnover</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow p-4 overflow-hidden">
            <h2 class="text-lg font-medium mb-2 text-gray-700">Jumlah Turnover per Bulan per Tahun</h2>
            <canvas id="barPerBulan"></canvas>
        </div>

        <div class="bg-white rounded-lg shadow p-4 overflow-hidden">
            <h2 class="text-lg font-medium mb-2 text-gray-700">Turnover Bulanan</h2>
            <canvas id="lineBulanan"></canvas>
        </div>

        <div class="bg-white rounded-lg shadow p-4 overflow-hidden">
            <h2 class="text-lg font-medium mb-2 text-gray-700">Alasan Turnover</h2>
            <canvas id="pieAlasan"></canvas>
        </div>

        <div class="bg-white rounded-lg shadow p-4 overflow-hidden">
            <h2 class="text-lg font-medium mb-2 text-gray-700">Status Resign dan PHK per Bulan</h2>
            <canvas id="stackedStatus"></canvas>
        </div>
    </div>
</div>

<script>
fetch('/api/chart/turnover')
    .then(res => res.json())
    .then(data => {
        const MONTHS = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        // Helper agar data urut bulannya
        function sortBulanTahun(keys) {
            return keys.sort((a, b) => {
                let [bulanA, tahunA] = a.split(' ');
                let [bulanB, tahunB] = b.split(' ');
                let idxA = MONTHS.indexOf(bulanA);
                let idxB = MONTHS.indexOf(bulanB);
                if (tahunA !== tahunB) return tahunA - tahunB;
                return idxA - idxB;
            });
        }

        // Kumpulan data
        const bulanTahun = {}, lineBulanan = {}, alasanCount = {}, statusBulan = {};

        data.forEach(item => {
            const label = `${item.bulan} ${item.tahun}`;
            const alasan = item.alasan;
            const resign = item.status_resign === 'YES' ? 1 : 0;
            const phk = item.status_phk === 'YES' ? 1 : 0;

            // Bar Chart Bulanan
            bulanTahun[label] = (bulanTahun[label] || 0) + 1;

            // Line Chart Bulanan
            lineBulanan[label] = (lineBulanan[label] || 0) + 1;

            // Pie Alasan
            alasanCount[alasan] = (alasanCount[alasan] || 0) + 1;

            // Stacked Resign vs PHK
            if (!statusBulan[label]) statusBulan[label] = { resign: 0, phk: 0 };
            statusBulan[label].resign += resign;
            statusBulan[label].phk += phk;
        });

        // Urutkan label bulanan
        const sortedBulanTahun = sortBulanTahun(Object.keys(bulanTahun));

        // 1. Bar Chart: Jumlah Turnover per Bulan per Tahun
        new Chart(document.getElementById('barPerBulan'), {
            type: 'bar',
            data: {
                labels: sortedBulanTahun,
                datasets: [{
                    label: 'Jumlah Turnover',
                    data: sortedBulanTahun.map(l => bulanTahun[l]),
                    backgroundColor: 'rgba(54, 162, 235, 0.6)'
                }]
            },
            options: {
                plugins: {
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        font: { weight: 'bold' },
                        formatter: (value) => value,
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

        // 2. Line Chart: Tren Turnover per Bulan dari Tahun 2023–2024
        new Chart(document.getElementById('lineBulanan'), {
            type: 'line',
            data: {
                labels: sortedBulanTahun,
                datasets: [{
                    label: 'Jumlah Turnover per Bulan',
                    data: sortedBulanTahun.map(l => lineBulanan[l]),
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
                        formatter: (value) => value,
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

        // 3. Pie Chart: Proporsi Alasan Turnover
        new Chart(document.getElementById('pieAlasan'), {
            type: 'pie',
            data: {
                labels: Object.keys(alasanCount),
                datasets: [{
                    label: 'Alasan Turnover',
                    data: Object.values(alasanCount),
                    backgroundColor: [
                        '#36A2EB', '#FF6384', '#FFCE56', '#4BC0C0', '#9966FF'
                    ]
                }]
            },
            options: {
                plugins: {
                    datalabels: {
                        color: '#fff',
                        font: { weight: 'bold', size: 14 },
                        formatter: (value, context) => {
                            let total = context.chart.data.datasets[0].data.reduce((a,b) => a + b, 0);
                            let percent = (value / total * 100).toFixed(1);
                            return value + ' (' + percent + '%)';
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });

        // 4. Stacked Bar Chart: Resign vs PHK per Bulan
        const stackedLabels = sortBulanTahun(Object.keys(statusBulan));
        const resignData = stackedLabels.map(l => statusBulan[l].resign);
        const phkData = stackedLabels.map(l => statusBulan[l].phk);

        new Chart(document.getElementById('stackedStatus'), {
            type: 'bar',
            data: {
                labels: stackedLabels,
                datasets: [
                    {
                        label: 'Resign',
                        data: resignData,
                        backgroundColor: 'rgba(255, 159, 64, 0.7)'
                    },
                    {
                        label: 'PHK',
                        data: phkData,
                        backgroundColor: 'rgba(153, 102, 255, 0.7)'
                    }
                ]
            },
            options: {
                plugins: {
                    datalabels: {
                        anchor: 'center',
                        align: 'center',
                        font: { weight: 'bold' },
                        formatter: (value) => value === 0 ? '' : value,
                        color: '#222'
                    }
                },
                responsive: true,
                scales: {
                    x: { stacked: true },
                    y: { stacked: true, beginAtZero: true }
                }
            },
            plugins: [ChartDataLabels]
        });
    });
</script>
@endsection
