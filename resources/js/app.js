import './bootstrap';
import Chart from 'chart.js/auto';
import ChartDataLabels from 'chartjs-plugin-datalabels';

Chart.register(ChartDataLabels); // ini penting agar plugin aktif

// Bisa diakses dari window jika perlu dipakai di file lain
window.Chart = Chart;
window.ChartDataLabels = ChartDataLabels;
