@extends('layouts.master')
@section('title', 'Chart Promosi')
@section('content')

<div class="max-w-7xl mx-auto px-4 py-6">
    <h1 class="text-2xl font-semibold mb-6 text-gray-800">Promosi Karyawan</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow p-4">
            <h2 class="text-lg font-medium mb-2 text-gray-700">Jumlah Promosi per Jabatan Sebelum</h2>
            <canvas id="barJabatanSebelum"></canvas>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <h2 class="text-lg font-medium mb-2 text-gray-700">Jumlah Promosi per Departemen</h2>
            <canvas id="barDepartemen"></canvas>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <h2 class="text-lg font-medium mb-2 text-gray-700">Jabatan Tujuan Promosi</h2>
            <canvas id="donutJabatanSesudah"></canvas>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <h2 class="text-lg font-medium mb-2 text-gray-700">Perbandingan Jabatan Sebelum ke Tiap Jabatan Tujuan</h2>
            <canvas id="barGroupedPromosi"></canvas>
        </div>
    </div>
</div>

<script>
fetch('/api/chart/promosi')
    .then(res => res.json())
    .then(data => {
        const jabatanSebelum = {}, jabatanSesudah = {}, departemen = {}, masaKategori = {
            '0–6 bulan': 0,
            '7–12 bulan': 0,
            '13–24 bulan': 0,
            '>24 bulan': 0
        }, jabatanGroup = {};

        data.forEach(item => {
            jabatanSebelum[item.jabatan_sebelum] = (jabatanSebelum[item.jabatan_sebelum] || 0) + 1;
            jabatanSesudah[item.jabatan_sesudah] = (jabatanSesudah[item.jabatan_sesudah] || 0) + 1;
            departemen[item.departemen] = (departemen[item.departemen] || 0) + 1;

            const mj = item.masa_jabatan;
            if (mj <= 6) masaKategori['0–6 bulan']++;
            else if (mj <= 12) masaKategori['7–12 bulan']++;
            else if (mj <= 24) masaKategori['13–24 bulan']++;
            else masaKategori['>24 bulan']++;

            // Grouped bar logic
            const before = item.jabatan_sebelum;
            const after = item.jabatan_sesudah;
            if (!jabatanGroup[before]) jabatanGroup[before] = {};
            jabatanGroup[before][after] = (jabatanGroup[before][after] || 0) + 1;
        });

        new Chart(barJabatanSebelum, {
            type: 'bar',
            data: {
                labels: Object.keys(jabatanSebelum),
                datasets: [{
                    label: 'Jumlah Promosi',
                    data: Object.values(jabatanSebelum),
                    backgroundColor: 'rgba(75, 192, 192, 0.7)'
                }]
            },
            options: {
                responsive: true,
                plugins: { datalabels: { anchor: 'end', align: 'top', formatter: val => val } },
                scales: { y: { beginAtZero: true } }
            },
            plugins: [ChartDataLabels]
        });

        new Chart(barDepartemen, {
            type: 'bar',
            data: {
                labels: Object.keys(departemen),
                datasets: [{
                    label: 'Jumlah Promosi',
                    data: Object.values(departemen),
                    backgroundColor: 'rgba(153, 102, 255, 0.7)'
                }]
            },
            options: {
                responsive: true,
                plugins: { datalabels: { anchor: 'end', align: 'top', formatter: val => val } },
                scales: { y: { beginAtZero: true } }
            },
            plugins: [ChartDataLabels]
        });


        new Chart(donutJabatanSesudah, {
            type: 'doughnut',
            data: {
                labels: Object.keys(jabatanSesudah),
                datasets: [{
                    label: 'Tujuan Promosi',
                    data: Object.values(jabatanSesudah),
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0']
                }]
            },
            options: {
                plugins: {
                    datalabels: {
                        color: '#fff',
                        font: { weight: 'bold' },
                        formatter: value => value
                    }
                }
            },
            plugins: [ChartDataLabels]
        });

        // Grouped bar chart: Jabatan Sebelum dan Sesudah
        const beforeLabels = Object.keys(jabatanGroup);
        const allAfterLabels = [...new Set(data.map(d => d.jabatan_sesudah))];
        const groupedDatasets = allAfterLabels.map((jab, i) => ({
            label: jab,
            data: beforeLabels.map(before => jabatanGroup[before][jab] || 0),
            backgroundColor: `hsl(${i * 60}, 70%, 60%)`
        }));

        new Chart(barGroupedPromosi, {
            type: 'bar',
            data: {
                labels: beforeLabels,
                datasets: groupedDatasets
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    datalabels: {
                        anchor: 'end',
                        align: 'right',
                        font: { weight: 'bold' },
                        formatter: value => value,
                        color: '#444'
                    }
                },
                scales: {
                    x: { beginAtZero: true }
                }
            },
            plugins: [ChartDataLabels]
        });
    });
</script>
@endsection
