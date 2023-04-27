<script setup>
import { Pie } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, ArcElement, CategoryScale, LinearScale, Colors } from 'chart.js'
import { computed } from 'vue';

const props = defineProps(['stats']);

ChartJS.register(Title, Tooltip, Legend, ArcElement, CategoryScale, LinearScale, Colors);

// prop template {string: float, string: float} and it will change it to whatever is needed

const chartData = computed(()=>{
    let data = Object.entries(props.stats).map(([key, value]) => ({name: key, amount: value}));
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

const chartOptions = {
  responsive: true,
  maintainAspectRatio: false,
    plugins: {
        legend: {
            display: false,
            position: 'right'
        }
    }
  
}
</script>

<template>
    <div>
        <Pie :data="chartData" :options="chartOptions" />
    </div>
</template>