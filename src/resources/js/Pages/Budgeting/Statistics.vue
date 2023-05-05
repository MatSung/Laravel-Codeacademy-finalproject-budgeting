<script setup>

import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import PieChart from '@/Components/PieChart.vue';
import Socials from '@/Components/Socials.vue';
import ImportExport from '@/Components/ImportExport.vue';
import PurgeButton from '@/Components/PurgeButton.vue';
import StatisticsTable from '@/Components/StatisticsTable.vue';
import { Head, usePage, useForm, Link } from '@inertiajs/vue3';
import { computed } from '@vue/reactivity';
import { ref } from 'vue';

const props = defineProps(['stats']);

const stats = props.stats;

const style = {
    position: 'relative',
    width: '500px'
};

</script>

<template>
    <Head title="Settings" />
    <DefaultLayout>
        <div class="container max-w-7xl mx-auto mt-8 rounded-lg overflow-hidden">
            <div class="bg-white pt-4 mb-5 rounded-lg flex justify-center flex-row gap-8">
                <div>
                    <h1 class="text-center mb-3 text-lg">Income</h1>
                    <PieChart :stats="stats.income" :position="'left'" :style="style" />
                </div>
                <div>
                    <h1 class="text-center mb-3 text-lg">Expenses</h1>
                    <PieChart :stats="stats.expense" :position="'right'" :style="style"/>
                </div>
            </div>
            <div class="bg-white rounded-lg p-5 mb-5">
                <StatisticsTable :stats="stats" />
            </div>
        </div>
    </DefaultLayout>
</template>