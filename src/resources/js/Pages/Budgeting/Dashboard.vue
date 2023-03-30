<script setup>

import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import BudgetEntryAddForm from '@/Components/BudgetEntryAddForm.vue';
import EntryTable from '@/Components/EntryTable.vue';
import { useForm, Head } from '@inertiajs/vue3';
import { toRaw } from 'vue';

const props = defineProps(['entries','categories']);

const entries = toRaw(props.entries);
const categories = toRaw(props.categories);

// console.log(categories);

</script>

<template>
    <Head title="Index" />

    <DefaultLayout>
        <BudgetEntryAddForm :entries="entries" :categories="categories"/>
        <div class="container max-w-7xl mx-auto mt-8 rounded overflow-hidden">
            <EntryTable :entries="entries" />
        </div>
    </DefaultLayout>


</template>