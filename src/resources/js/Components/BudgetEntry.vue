<script setup>
import { reactive, computed, ref } from 'vue'
import DeleteModal from './DeleteModal.vue';

const props = defineProps(['entry']);

const entryTypeClass = computed(() => {
    return props.entry.amount > 0 ? 'bg-income' : 'bg-expense';
});

const entryTypeName = computed(()=>{
    return props.entry.amount > 0 ? 'Income' : 'Expense';
});

const showModal = ref(false);


</script>

<template>
    <tr 
    class="border-b-2"
    :class="entryTypeClass"
    >
        <td class="p-2">{{ entry.transaction_date }}</td>
        <td>{{ entryTypeName }}</td>
        <td>{{ entry.category.name }}</td>
        <td>{{ !entry.subcategory ? '' : entry.subcategory.name }}</td>
        <td class="pl-3">{{ Math.abs(entry.amount).toFixed(2) }}</td>
        <td>{{ entry.note }}</td>
        <td>
            <div class="flex gap-4 justify-end pr-4">
                <a class="w-4 inline-block" >✏</a>
                <button class="w-4 inline-block" @click="showModal = true" >✖</button>
            </div>
        </td>
    </tr>
    <Teleport to="body">
        <DeleteModal :show="showModal" :target="route('entries.destroy', entry.id)" @close="showModal = false">
            <template #header>
                <h3>Delete?</h3>
            </template>
            <template #body>
                <p>Are you sure you want to delete entry {{ entry.id }}</p>
            </template>
        </DeleteModal>
    </Teleport>
    
</template>