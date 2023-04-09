<script setup>
import { reactive, ref } from 'vue'
import { computed } from '@vue/reactivity';
import { usePage } from '@inertiajs/vue3';
import BudgetEntry from './BudgetEntry.vue';
import BudgetUtilityRow from './BudgetUtilityRow.vue';

const props = defineProps(['entries']);
const entries = computed(() => usePage().props.entries);

</script>

<template>
    <div>
        <table class="border-collapse table-auto w-full text-md ">
            <thead>
                <tr>
                    <th class=" font-bold pl-2 pt-2 pb-3 text-white text-left bg-slate-800">Date/Time</th>
                    <th class=" font-bold pt-2 pb-3 text-white text-left bg-slate-800">Income/Expense</th>
                    <th class=" font-bold pt-2 pb-3 text-white text-left bg-slate-800">Category</th>
                    <th class=" font-bold pt-2 pb-3 text-white text-left bg-slate-800">Subcategory</th>
                    <th class=" font-bold pt-2 pb-3 text-white text-left bg-slate-800">Amount</th>
                    <th class=" font-bold pt-2 pb-3 text-white text-left bg-slate-800">Note</th>
                    <th class=" font-bold pt-2 pb-3 text-white text-left bg-slate-800">Actions</th>
                </tr>
            </thead>
            <tbody>
                <BudgetUtilityRow :entries="entries" />
                <BudgetEntry v-for="entry in entries" :key="entry.id" :entry="entry" />
            </tbody>
        </table>
    </div>
</template>
