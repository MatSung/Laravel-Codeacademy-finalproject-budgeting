<script setup>
import { reactive, ref } from 'vue'
import { computed } from '@vue/reactivity';
import { usePage, Link } from '@inertiajs/vue3';
import BudgetEntry from './BudgetEntry.vue';
import BudgetUtilityRow from '@/Components/BudgetUtilityRow.vue';
import DeleteModal from '@/Components/DeleteModal.vue';
import UpdateModal from '@/Components/EntryUpdateModal.vue';

const props = defineProps(['entries', 'categories']);
const entries = computed(() => usePage().props.entries);
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

const activateCreateModal = () => {
    updateState.type = 'Create';
    updateState.target = route('entries.store');
    updateState.show = true;
    updateState.prefill.value = {};
}

</script>

<template>
    <div>
        <table class="border-collapse table-auto w-full text-md mb-4">
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
                <BudgetUtilityRow :entries="entries" @show-create-modal="activateCreateModal" />
                <BudgetEntry v-for="entry in entries" :key="entry.id" :entry="entry"
                    @show-delete-modal="activateDeleteModal" @show-update-modal="activateUpdateModal" />
            </tbody>
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
                        {{updateState.type}}
                    </template>
                    <template #button>
                        {{ updateState.type }}
                    </template>
                </UpdateModal>
            </Teleport>
        </table>
    </div>
</template>
