<script setup>
import Chart from 'chart.js/auto';
import { onMounted, ref } from 'vue';

const props = defineProps({
    entries: Object,
    categories: Object
})

const entries = props.entries;
const categories = props.categories;

const canvas = ref(null);

const chart = () => {
    const data = [
    { year: 2010, count: 10 },
    { year: 2011, count: 20 },
    { year: 2012, count: 15 },
    { year: 2013, count: 25 },
    { year: 2014, count: 22 },
    { year: 2015, count: 30 },
    { year: 2016, count: 28 },
  ];

  new Chart(
    canvas.value,
    {
      type: 'bar',
      data: {
        labels: data.map(row => row.year),
        datasets: [
          {
            label: 'Acquisitions by year',
            data: data.map(row => row.count)
          }
        ]
      }
    }
  );
}

// get sums of categories, some math
onMounted(()=>{
    chart();
});


</script>

<template>
    <div>
        <canvas ref="canvas"></canvas>
    </div>
</template>