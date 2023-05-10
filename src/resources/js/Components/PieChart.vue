<script setup>
import { Pie, Doughnut } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, ArcElement, CategoryScale, LinearScale, Colors } from 'chart.js'
import ChartDataLabels from 'chartjs-plugin-datalabels';
import { SetOne9 } from 'chartjs-plugin-colorschemes/src/colorschemes/colorschemes.brewer';
import { computed } from 'vue';
import { omitBy } from 'lodash';
import {filter} from 'lodash';

const props = defineProps(['stats', 'position', 'style']);

ChartJS.register(Title, Tooltip, Legend, ArcElement, CategoryScale, LinearScale,  ChartDataLabels);

// prop template {[name: string, amount: float], [name: string, amount: float], ...} and it will change it to whatever is needed

const chartData = computed(() => {
  let data = filter(props.stats, v => v.amount !== 0);
  return {
    labels: data.map(row => row.name),
    datasets: [
      {
        label: 'Total',
        data: data.map(row => row.amount),
        backgroundColor: ['#66c2a5', '#fc8d62', '#8da0cb', '#e78ac3', '#a6d854', '#ffd92f', '#e5c494', '#b3b3b3']
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
      },
      datalabels:{
        anchor: 'center',
        align: 'start',
        offset: -40,
        backgroundColor: 'white',
        borderColor: 'black',
        borderRadius: 25,
        borderWidth: 1,
        color: 'black',
        display: 'auto',
        clip: true
      }
    }

  };
});

const style = props.style;
</script>

<template>
  <div v-if="chartData.labels.length > 0">
    <Doughnut :data="chartData" :options="chartOptions" :style="style" />
  </div>
  <div v-else>
    <div class="text-center m-5">
      No data provided for the chart
    </div>
  </div>
</template>