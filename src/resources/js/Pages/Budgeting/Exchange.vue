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

const exchange = computed(()=>usePage().props.exchange)

</script>

<template>
    <Head title="Exchange" />
    <DefaultLayout>
        <div class="container max-w-7xl mx-auto mt-8 rounded-lg overflow-hidden">
            Tool to use exchangerate providers
            {{ exchange.rates }}
        </div>
    </DefaultLayout>
</template>