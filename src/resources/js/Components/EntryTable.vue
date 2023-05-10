<script setup>
import { reactive, ref, watch } from 'vue'
import { computed } from '@vue/reactivity';
import { usePage, Link, useForm, router } from '@inertiajs/vue3';
import mapValues from 'lodash/mapValues'
import pickBy from 'lodash/pickBy'
import BudgetEntry from './BudgetEntry.vue';
import DeleteModal from '@/Components/DeleteModal.vue';
import UpdateModal from '@/Components/EntryUpdateModal.vue';
import BudgetEntryDayDivider from '@/Components/BudgetEntryDayDivider.vue';
import Pagination from '@/Components/Pagination.vue';
import EmptyTableOverlay from '@/Components/EmptyTableOverlay.vue';


const props = defineProps(['entries', 'categories', 'grouping', 'pagination', 'filters']);

const pagination = computed(() => props.pagination);
const entries = computed(() => props.entries);
const categories = props.categories;
const filters = computed(() => props.filters);


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

const form = reactive({
    order: filters.value.order,
    order_by: filters.value.order_by,
    group_by: filters.value.group_by,
    category: filters.value.category,
    income: filters.value.income,
    subcategory: filters.value.subcategory,
});


watch(form, () => {
    router.get(usePage().url.split('?').shift(), pickBy(form), { preserveState: true });
});

const sum = computed(() => {
    return Object.values(props.entries)
        .reduce((total, obj) => obj.amount + total, 0)
        .toFixed(2);
});

const symbol = computed(() => {
    return sum.value < 0 ? '-' : (sum.value == 0) ? '±' : '+';
});

const isFiltered = computed(()=>{
    return Object.values(form).every(value=>value == null);
});

// console.log(Object.values(form).every(value=>value == null));

</script>

<template>
    <div>
        <template name="empty" v-if="entries.length == 0 && isFiltered">
                    <EmptyTableOverlay>
                        <p>Your database is empty, </p><button @click="activateCreateModal" class="btn-primary">Add a new entry?</button>
                    </EmptyTableOverlay>
        </template>
        <table v-else class="border-collapse table-fixed w-full text-md mb-4">
            <thead>
                <tr>
                    <th class=" font-bold pl-2 pt-2 pb-3 text-white text-left bg-slate-800 lg:w-44 sm:w-28">
                        Date/Time
                        <button type="button" @click="form.group_by = null"
                            v-if="$page.url.includes('group_by')">📆</button>
                        <button type="button" @click="form.group_by = 'day'"
                            v-if="!$page.url.includes('group_by=day')">⏰</button>
                    </th>
                    <th class=" font-bold pt-2 pb-3 text-white text-left bg-slate-800 w-28">Inc/Exp</th>
                    <th class=" font-bold pt-2 pb-3 text-white text-left bg-slate-800 w-44">Category</th>
                    <th class=" font-bold pt-2 pb-3 text-white text-left bg-slate-800 w-44">Subcategory</th>
                    <th class=" font-bold pt-2 pb-3 text-white text-left bg-slate-800 w-32">Amount</th>
                    <th class=" font-bold pt-2 pb-3 text-white text-left bg-slate-800">Note</th>
                    <th class=" font-bold pt-2 pb-3 text-white text-left bg-slate-800 w-20">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-slate-300 border-b-2 text-gray-500">
                    <td class=""></td>
                    <td class="">
                        <select class="w-full" v-model="form.income">
                            <option value=""></option>
                            <option value="income">Income</option>
                            <option value="expense">Expense</option>
                        </select>
                    </td>
                    <td class="">
                        <select class="w-full" name="category" v-model="form.category" @change="form.subcategory=null">
                            <option value=""></option>
                            <option v-for="category in categories" :value="category.id">{{ category.name }}</option>
                        </select>
                    </td>
                    <td class="">
                        <select class="w-full" v-if="categories[form.category]?.subcategories.length" v-model="form.subcategory" id="">
                            <option value=""></option>
                            <option v-for="subcategory in categories[form.category]?.subcategories" :value="subcategory.id">{{ subcategory.name }}</option>

                        </select>
                    </td>
                    <td class="pt-2 pl-1">{{ symbol + Math.abs(sum) }}</td>
                    <td class="pt-2"></td>
                    <td class="">
                        <div class="flex gap-4 justify-end pr-4">
                            <a href="#" class="w-4 inline-block" @click="activateCreateModal">➕</a>
                        </div>
                    </td>
                </tr>
                <template v-if="!grouping">
                    <BudgetEntry v-for="entry in entries" :key="entry.id" :entry="entry"
                        @show-delete-modal="activateDeleteModal" @show-update-modal="activateUpdateModal" />
                </template>
                <template v-else>
                    <BudgetEntryDayDivider v-for="(item, key) in datesByDay">
                        <template #date>
                            {{ key }}
                        </template>
                        <template #items>
                            <BudgetEntry v-for="subEntry in item" :key="subEntry.id" :entry="subEntry"
                                @show-delete-modal="activateDeleteModal" @show-update-modal="activateUpdateModal" />
                        </template>
                    </BudgetEntryDayDivider>
                </template>
                
            </tbody>
        </table>
        <div v-if="entries.length == 0 && !isFiltered" class="text-center font-bold bg-gray-200 -mt-4 p-3 uppercase">No results...</div>
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
    </div>
</template>
