<script setup>
import { reactive, ref, watch } from 'vue'
import { computed } from '@vue/reactivity';
import { usePage, Link } from '@inertiajs/vue3';
import BudgetEntry from './BudgetEntry.vue';
import BudgetUtilityRow from '@/Components/BudgetUtilityRow.vue';
import DeleteModal from '@/Components/DeleteModal.vue';
import UpdateModal from '@/Components/EntryUpdateModal.vue';
import BudgetEntryDayDivider from '@/Components/BudgetEntryDayDivider.vue';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps(['entries' ,'categories', 'grouping', 'pagination']);

const pagination = computed(()=>props.pagination);
const entries = computed(()=>props.entries);
const categories = props.categories;


// Delete modal
const deletionState = reactive({
    show: false,
    target: '#'
});

const activateDeleteModal = (id) => {
    deletionState.target = route('entries.destroy', id);
    deletionState.show = true;
}

// Update modal
const updateState = reactive({
    show: false,
    target: '#',
    prefill: reactive({}),
    type: 'Update'
})

const activateUpdateModal = (entry) => {
    updateState.type = 'Update'
    updateState.target = route('entries.update', entry.id);
    updateState.show = true;
    updateState.prefill.value = entry;
}

// Create modal
const activateCreateModal = () => {
    updateState.type = 'Create';
    updateState.target = route('entries.store');
    updateState.show = true;
    updateState.prefill.value = {};
}

// Grouped by days
const datesByDay = computed(() => {
    return entries.value.reduce((acc, obj) => {
        const date = new Date(obj.transaction_date);
        const dateKey = date.toISOString().substring(0, 10);
        if (!acc[dateKey]) {
            acc[dateKey] = [];
        }
        acc[dateKey].push(obj);
        return acc;
    }, {})
});


</script>

<template>
    <div>
        <table class="border-collapse table-auto w-full text-md mb-4">
            <thead>
                <tr>
                    <th class=" font-bold pl-2 pt-2 pb-3 text-white text-left bg-slate-800">
                        Date/Time <a href="?group_by">📆</a><a href="?group_by=day">⏰</a>
                    </th>
                    <th class=" font-bold pt-2 pb-3 text-white text-left bg-slate-800">Income/Expense</th>
                    <th class=" font-bold pt-2 pb-3 text-white text-left bg-slate-800">Category</th>
                    <th class=" font-bold pt-2 pb-3 text-white text-left bg-slate-800">Subcategory</th>
                    <th class=" font-bold pt-2 pb-3 text-white text-left bg-slate-800">Amount</th>
                    <th class=" font-bold pt-2 pb-3 text-white text-left bg-slate-800">Note</th>
                    <th class=" font-bold pt-2 pb-3 text-white text-left bg-slate-800">Actions</th>
                </tr>
            </thead>
            <tbody v-if="!grouping">
                <BudgetUtilityRow :entries="entries" @show-create-modal="activateCreateModal" />
                <BudgetEntry v-for="entry in entries" :key="entry.id" :entry="entry"
                    @show-delete-modal="activateDeleteModal" @show-update-modal="activateUpdateModal" />
            </tbody>
            <tbody v-if="grouping">
                <BudgetUtilityRow :entries="entries" @show-create-modal="activateCreateModal" />
                <BudgetEntryDayDivider v-for="(item, key) in datesByDay">
                    <template #date>
                        {{ key }}
                    </template>
                    <template #items>
                        <BudgetEntry v-for="subEntry in item" :key="subEntry.id" :entry="subEntry"
                            @show-delete-modal="activateDeleteModal" @show-update-modal="activateUpdateModal" />
                    </template>
                </BudgetEntryDayDivider>
            </tbody>
            <Pagination :links="pagination" />
            <Teleport to="body">
                <DeleteModal :show="deletionState.show" :target="deletionState.target" @close="deletionState.show = false">
                    <template #header>
                        <h3>Delete?</h3>
                    </template>
                    <template #body>
                        <p>Are you sure you want to delete this entry?</p>
                    </template>
                </DeleteModal>
                <UpdateModal :categories="categories" :entry="updateState.prefill" :show="updateState.show"
                    :target="updateState.target" @close="updateState.show = false">
                    <template #header>
                        {{ updateState.type }}
                    </template>
                    <template #button>
                        {{ updateState.type }}
                    </template>
                </UpdateModal>
            </Teleport>
        </table>
    </div>
</template>
