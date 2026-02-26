import './bootstrap';
import Alpine from 'alpinejs';
import {
    ArcElement,
    BarElement,
    CategoryScale,
    Chart,
    Legend,
    LinearScale,
    Tooltip,
} from 'chart.js';

window.Alpine = Alpine;
Alpine.start();

Chart.register(ArcElement, BarElement, CategoryScale, LinearScale, Tooltip, Legend);

const defaultPalette = ['#eab308', '#16a34a', '#2563eb', '#dc2626', '#7c3aed', '#0891b2'];

const parseChartConfig = (raw) => {
    if (!raw) {
        return null;
    }

    try {
        return JSON.parse(raw);
    } catch (error) {
        console.error('Invalid chart config:', error);
        return null;
    }
};

const initEkakuCharts = () => {
    const chartNodes = document.querySelectorAll('[data-ekaku-chart]');
    chartNodes.forEach((canvas) => {
        const config = parseChartConfig(canvas.getAttribute('data-ekaku-chart'));
        if (!config || !Array.isArray(config.labels) || !Array.isArray(config.values)) {
            return;
        }

        const chartType = canvas.getAttribute('data-chart-type') || 'doughnut';
        const colors = Array.isArray(config.colors) && config.colors.length > 0
            ? config.colors
            : defaultPalette.slice(0, config.values.length);

        const chartInstance = Chart.getChart(canvas);
        if (chartInstance) {
            chartInstance.destroy();
        }

        new Chart(canvas, {
            type: chartType,
            data: {
                labels: config.labels,
                datasets: [
                    {
                        data: config.values,
                        backgroundColor: colors,
                        borderColor: '#ffffff',
                        borderWidth: 2,
                        borderRadius: chartType === 'bar' ? 8 : 0,
                        maxBarThickness: chartType === 'bar' ? 42 : undefined,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            boxHeight: 12,
                            usePointStyle: true,
                            pointStyle: 'circle',
                        },
                    },
                },
                scales: chartType === 'bar'
                    ? {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                            },
                        },
                    }
                    : undefined,
            },
        });
    });
};

document.addEventListener('DOMContentLoaded', initEkakuCharts);
