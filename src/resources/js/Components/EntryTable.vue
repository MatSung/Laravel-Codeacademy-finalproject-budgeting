<script setup>
import { reactive, ref } from 'vue'
import { computed } from '@vue/reactivity';
import { usePage, Link } from '@inertiajs/vue3';
import BudgetEntry from './BudgetEntry.vue';
import BudgetUtilityRow from '@/Components/BudgetUtilityRow.vue';
import DeleteModal from '@/Components/DeleteModal.vue';
import UpdateModal from '@/Components/UpdateModal.vue';

const props = defineProps(['entries', 'categories']);
const entries = computed(() => usePage().props.entries);
const categories = props.categories;

const showDeleteModal = ref(false);
const deleteModalTarget = ref('#');

const activateDeleteModal = (id) => {
    deleteModalTarget.value = route('entries.destroy', id);
    showDeleteModal.value = true;
}

const showUpdateModal = ref(false);
const updateModalTarget = ref('#');
const updateModalPrefill = reactive({});

const activateUpdateModal = (entry) => {
    updateModalTarget.value = route('entries.update', entry.id);
    showUpdateModal.value = true;
    updateModalPrefill.value = entry;

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
                <BudgetUtilityRow :entries="entries" />
                <BudgetEntry v-for="entry in entries" :key="entry.id" :entry="entry"
                    @show-delete-modal="activateDeleteModal" @show-update-modal="activateUpdateModal" />
            </tbody>
            <Teleport to="body">
                <DeleteModal :show="showDeleteModal" :target="deleteModalTarget" @close="showDeleteModal = false">
                    <template #header>
                        <h3>Delete?</h3>
                    </template>
                    <template #body>
                        <p>Are you sure you want to delete this entry?</p>
                    </template>
                </DeleteModal>
                <UpdateModal :categories="categories" :entry="updateModalPrefill" :show="showUpdateModal"
                    :target="updateModalTarget" @close="showUpdateModal = false">
                    <template #header>
                        Update
                    </template>
                </UpdateModal>
            </Teleport>
        </table>
    </div>
</template>
