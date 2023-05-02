<script setup>

import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import BudgetEntryAddForm from '@/Components/BudgetEntryAddForm.vue';
import EntryTable from '@/Components/EntryTable.vue';
import { useForm, Head, usePage } from '@inertiajs/vue3';
import { computed, reactive } from '@vue/reactivity';

const props = defineProps(['data','categories', 'filters']);

const data = computed(() => usePage().props.data);
const entries = computed(() => props.data.data);
const filters = computed(() => props.filters);
const categories = computed(()=> props.categories);

</script>

<template>
    <Head title="Entries" />
    <DefaultLayout>
        <BudgetEntryAddForm :categories="categories"/>
        <div class="container max-w-7xl mx-auto mt-8 rounded overflow-hidden">
            <EntryTable :categories="categories" :entries="entries" :grouping="filters.group_by == 'day'"
                :pagination="data.links" :filters="filters"/>
        </div>
    </DefaultLayout>

</template>