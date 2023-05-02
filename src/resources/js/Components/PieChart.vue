<script setup>
import { Pie } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, ArcElement, CategoryScale, LinearScale, Colors } from 'chart.js'
import { computed } from 'vue';

const props = defineProps(['stats', 'position']);

ChartJS.register(Title, Tooltip, Legend, ArcElement, CategoryScale, LinearScale, Colors);

// prop template {[name: string, amount: float], [name: string, amount: float], ...} and it will change it to whatever is needed

const chartData = computed(() => {
  let data = props.stats;
  return {
    labels: data.map(row => row.name),
    datasets: [
      {
        label: 'Total',
        data: data.map(row => row.amount)
      }
    ]
  }
})

const chartOptions = computed(() => {
  return {
    responsive: true,
    maintainAspectRatio: false,
    layout: {
      padding: 0,
    },
    plugins: {
      legend: {
        display: true,
        position: props.position
      }
    }

  };
});
</script>

<template>
  <div>
    <Pie :data="chartData" :options="chartOptions" />
  </div>
</template>