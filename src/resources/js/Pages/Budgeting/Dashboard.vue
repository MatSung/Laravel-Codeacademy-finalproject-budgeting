<script setup>

import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import EntryTable from '@/Components/EntryTable.vue';
import PieChart from '@/Components/PieChart.vue';
import { useForm, Head, usePage } from '@inertiajs/vue3';
import { computed, reactive } from '@vue/reactivity';
import { watch } from 'vue';

const props = defineProps(['data', 'categories', 'stats', 'filters']);
const stats = computed(() => usePage().props.stats);
const data = computed(() => usePage().props.data);
const entries = computed(() => props.data.data);
const filters = computed(() => props.filters);


</script>

<template>
    <Head title="Dashboard" />
    <DefaultLayout>
        <div class="container max-w-7xl mx-auto mt-8 rounded overflow-hidden">
            <div class="bg-white pt-4 rounded-lg flex justify-center flex-row gap-8">
                <div>
                    <h1 class="text-center mb-3 text-lg">Income</h1>
                    <PieChart :stats="stats.income" :position="'left'"/>
                    <!-- <p>total = this</p> -->
                </div>
                <div>
                    <h1 class="text-center mb-3 text-lg">Expenses</h1>
                    <PieChart :stats="stats.expense" :position="'right'" />
                    <!-- <p>total = this</p> -->
                </div>
            </div>
        </div>
        <div class="container max-w-7xl mx-auto mt-8 rounded overflow-hidden">
            <EntryTable :categories="categories" :entries="entries" :grouping="filters.group_by == 'day'"
                :pagination="data.links" :filters="filters"/>
        </div>
    </DefaultLayout>
</template>