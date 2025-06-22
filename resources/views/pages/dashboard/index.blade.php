@extends('layouts.master')

@section('title')
    PT. Kidora Mandiri | Dashboard
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <h1 class="text-2xl font-semibold mb-6 text-gray-800">Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Pelatihan --}}
        <div class="bg-white rounded-lg shadow p-4 overflow-hidden">
            <h2 class="text-lg font-medium mb-2 text-gray-700">Pelatihan</h2>
            <canvas id="chartPelatihan" class="w-full h-64"></canvas>
        </div>

        {{-- Promosi --}}
        <div class="bg-white rounded-lg shadow p-4 overflow-hidden">
            <h2 class="text-lg font-medium mb-2 text-gray-700">Promosi</h2>
            <canvas id="chartPromosi" class="w-full h-64"></canvas>
        </div>

        {{-- Insiden --}}
        <div class="bg-white rounded-lg shadow p-4 overflow-hidden">
            <h2 class="text-lg font-medium mb-2 text-gray-700">Insiden</h2>
            <canvas id="chartInsiden" class="w-full h-64"></canvas>
        </div>

        {{-- Turnover --}}
        <div class="bg-white rounded-lg shadow p-4 overflow-hidden">
            <h2 class="text-lg font-medium mb-2 text-gray-700">Turnover</h2>
            <canvas id="chartTurnover" class="w-full h-64"></canvas>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Fungsi bantu untuk mengurutkan bulan secara benar
    const bulanOrder = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

    // Pelatihan Chart (ambil nilai rata-rata per materi)
    fetch('/api/chart/pelatihan')
    .then(res => res.json())
    .then(data => {
        const materiMap = {};
        data.forEach(item => {
            if (!materiMap[item.materi]) materiMap[item.materi] = [];
            materiMap[item.materi].push(item.nilai);
        });

        const rata2 = Object.entries(materiMap).map(([materi, nilai]) => {
            const avg = nilai.reduce((a, b) => a + b, 0) / nilai.length;
            return { materi, avg };
        });

        // Ambil 5 nilai tertinggi
        const top5 = rata2.sort((a, b) => b.avg - a.avg).slice(0, 5);

        new Chart(document.getElementById('chartPelatihan'), {
            type: 'bar',
            data: {
                labels: top5.map(x => x.materi),
                datasets: [{
                    label: 'Nilai Rata-rata (%)',
                    data: top5.map(x => x.avg),
                    backgroundColor: '#3b82f6'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.parsed.y.toFixed(2) + '%';
                            }
                        }
                    },
                    datalabels: {
                        color: '#111827',
                        font: {
                            weight: 'bold'
                        },
                        anchor: 'end',
                        align: 'top',
                        formatter: function(value) {
                            return value.toFixed(2) + '%';
                        }
                    }
                },
                scales: {
                    y: {
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        },
                        suggestedMin: 0,
                        suggestedMax: 100
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    });


    // Promosi Chart (jumlah promosi per jabatan sesudah)
    fetch('/api/chart/promosi')
        .then(res => res.json())
        .then(data => {
            const jabatanMap = {};
            data.forEach(item => {
                const j = item.jabatan_sesudah;
                jabatanMap[j] = (jabatanMap[j] || 0) + 1;
            });

            const labels = Object.keys(jabatanMap);
            const values = Object.values(jabatanMap);

            new Chart(document.getElementById('chartPromosi'), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Promosi',
                        data: values,
                        backgroundColor: '#10b981'
                    }]
                },
                options: {
                    responsive: true,
                    indexAxis: 'y',
                    plugins: { legend: { display: false } }
                }
            });
        });

    // Insiden Chart (jumlah per jenis insiden)
    fetch('/api/chart/insiden')
        .then(res => res.json())
        .then(data => {
            const jenisMap = {};
            data.forEach(item => {
                const j = item.jenis_insiden;
                jenisMap[j] = (jenisMap[j] || 0) + 1;
            });

            const labels = Object.keys(jenisMap);
            const values = Object.values(jenisMap);

            new Chart(document.getElementById('chartInsiden'), {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: values,
                        backgroundColor: ['#f87171', '#facc15', '#34d399', '#60a5fa', '#a78bfa']
                    }]
                },
                options: {
                    responsive: true
                }
            });
        });

    // Turnover Chart (jumlah per bulan-tahun)
    fetch('/api/chart/turnover')
        .then(res => res.json())
        .then(data => {
            const groupMap = {};
            data.forEach(item => {
                const key = item.bulan + ' ' + item.tahun;
                groupMap[key] = (groupMap[key] || 0) + 1;
            });

            const sortedLabels = Object.keys(groupMap).sort((a, b) => {
                const [ba, ta] = a.split(' ');
                const [bb, tb] = b.split(' ');
                return (parseInt(ta) - parseInt(tb)) || (bulanOrder.indexOf(ba) - bulanOrder.indexOf(bb));
            });

            const values = sortedLabels.map(label => groupMap[label]);

            new Chart(document.getElementById('chartTurnover'), {
                type: 'line',
                data: {
                    labels: sortedLabels,
                    datasets: [{
                        label: 'Jumlah Turnover',
                        data: values,
                        borderColor: '#ef4444',
                        tension: 0.4,
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } }
                }
            });
        });
</script>

@endsection
