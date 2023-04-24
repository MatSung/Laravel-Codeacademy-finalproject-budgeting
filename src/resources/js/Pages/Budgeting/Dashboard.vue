<script setup>

import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import EntryTable from '@/Components/EntryTable.vue';
import EntryChart from '@/Components/EntryChart.vue';
import { useForm, Head, usePage } from '@inertiajs/vue3';
import { computed, reactive } from '@vue/reactivity';

const props = defineProps(['entries','categories']);

const entries = computed(() => usePage().props.entries);

</script>

<template>
    <Head title="Index" />
    <DefaultLayout> 
        <div class="container max-w-7xl mx-auto mt-8 rounded overflow-hidden">
            <EntryChart :entries="entries" :categories="categories" />
        </div>
        <div class="container max-w-7xl mx-auto mt-8 rounded overflow-hidden">
            <EntryTable :categories="categories" :entries="entries" />
        </div>
    </DefaultLayout>

</template>