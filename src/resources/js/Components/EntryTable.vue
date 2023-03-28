<script setup>
import { reactive, ref } from 'vue'
import BudgetEntry from './BudgetEntry.vue';

const state = reactive({entries: []});

function getEntries(apiUrl) {
    apiUrl = apiUrl || '/api/entries?sort=latest';
    axios.get(apiUrl)
        .then((response) => {
            console.log(response.data)
            state.entries = response.data;
        })
}


getEntries();


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
                <BudgetEntry v-for="entry in state.entries" :key="entry.id" :entry="entry" />
            </tbody>
        </table>
    </div>
</template>
