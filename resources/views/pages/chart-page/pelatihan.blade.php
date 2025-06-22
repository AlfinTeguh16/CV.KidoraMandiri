@extends('layouts.master')
@section('title', 'Chart Pelatihan')
@section('content')

<div class="max-w-7xl mx-auto px-4 py-6">
    <h1 class="text-2xl font-semibold mb-6 text-gray-800">Pelatihan Karyawan</h1>

    <div class="flex flex-col md:flex-row gap-6">
        <div class="bg-white rounded-lg w-full shadow p-4">
            <h2 class="text-lg font-medium mb-2 text-gray-700">Distribusi Status Kelulusan</h2>
            <canvas id="pieKelulusan"></canvas>
        </div>

        <div class="bg-white rounded-lg w-full shadow p-4">
            <h2 class="text-lg font-medium mb-2 text-gray-700">Distribusi Nilai Pelatihan</h2>
            <canvas id="barDistribusiNilai"></canvas>
        </div>
    </div>
</div>

<script>
fetch('/api/chart/pelatihan')
    .then(res => res.json())
    .then(data => {
        const statusKelulusan = { Lulus: 0, Tidak: 0 };
        const distribusiNilai = {};

        data.forEach(item => {
            // Hitung status kelulusan jika tidak null
            if (item.status_kelulusan) {
                const status = item.status_kelulusan === 'Lulus' ? 'Lulus' : 'Tidak';
                statusKelulusan[status]++;
            }

            // Hitung distribusi nilai
            const nilai = parseFloat(item.nilai);
            if (!isNaN(nilai)) {
                const nilaiBulat = Math.round(nilai);
                distribusiNilai[nilaiBulat] = (distribusiNilai[nilaiBulat] || 0) + 1;
            }
        });

        // Pie Chart Kelulusan
        new Chart(document.getElementById('pieKelulusan'), {
            type: 'pie',
            data: {
                labels: Object.keys(statusKelulusan),
                datasets: [{
                    label: 'Status Kelulusan',
                    data: Object.values(statusKelulusan),
                    backgroundColor: ['#4BC0C0', '#FF6384']
                }]
            },
            options: {
                plugins: {
                    datalabels: {
                        color: '#fff',
                        font: { weight: 'bold' },
                        formatter: v => v
                    }
                }
            },
            plugins: [ChartDataLabels]
        });

        // Sort distribusi nilai dari terbesar ke terkecil
        const sortedNilai = Object.keys(distribusiNilai)
            .map(k => parseInt(k))
            .sort((a, b) => b - a);

        const labels = sortedNilai.map(v => v.toString());
        const dataCount = sortedNilai.map(v => distribusiNilai[v]);

        new Chart(document.getElementById('barDistribusiNilai'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Record Count',
                    data: dataCount,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        formatter: v => v
                    }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            },
            plugins: [ChartDataLabels]
        });
    });
</script>
@endsection
