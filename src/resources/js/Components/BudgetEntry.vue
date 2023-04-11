<script setup>
import { reactive, computed, ref, defineEmits } from 'vue'

const props = defineProps(['entry']);


const entryTypeClass = computed(() => {
    return props.entry.amount > 0 ? 'bg-income' : 'bg-expense';
});

const entryTypeName = computed(()=>{
    return props.entry.amount > 0 ? 'Income' : 'Expense';
});

const emit = defineEmits(['show-delete-modal', 'show-update-modal']);


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
                <button class="w-4 inline-block" @click="$emit('show-update-modal', entry)">✏</button>
                <button class="w-4 inline-block" @click="$emit('show-delete-modal', entry.id)">✖</button>
            </div>
        </td>
    </tr>
    
    
</template>