<script setup>
import { reactive, computed, ref } from 'vue';

const props = defineProps(['entry']);


const entryTypeClass = computed(() => {
    return props.entry.amount > 0 ? 'text-positive' : 'text-negative';
});

const entryTypeName = computed(()=>{
    return props.entry.amount > 0 ? 'Income' : 'Expense';
});

const emit = defineEmits(['show-delete-modal', 'show-update-modal']);


</script>

<template>
    <tr 
    class="border-b-2 border-gray-300 bg-gray-200"
    
    >
        <td class="p-2">{{ entry.transaction_date }}</td>
        <td>{{ entryTypeName }}</td>
        <td>{{ entry.category.name }}</td>
        <td>{{ !entry.subcategory ? '' : entry.subcategory.name }}</td>
        <td class="pl-3 font-bold" :class="entryTypeClass">{{ Math.abs(entry.amount).toFixed(2) }}</td>
        <td class="overflow-hidden text-ellipsis">{{ entry.note }}</td>
        <td>
            <div class="flex gap-4 justify-end pr-4">
                <button class="w-4 inline-block" @click="$emit('show-update-modal', entry)">✏</button>
                <button class="w-4 inline-block" @click="$emit('show-delete-modal', entry.id)">✖</button>
            </div>
        </td>
    </tr>
    
    
</template>