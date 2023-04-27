<script setup>

import { reactive, computed } from 'vue'

const props = defineProps(['entries']);
// const entries = props.entries;

const sum = computed(() => {
    return Object.values(props.entries)
        .reduce((total, obj) => obj.amount + total, 0)
        .toFixed(2);
});

const symbol = computed(()=>{
    return sum.value < 0 ? '-' : (sum.value == 0) ? '±' : '+';
});

</script>

<template>
    <tr class="bg-slate-300 border-b-2 text-gray-500">
        <td class="pt-2"></td>
        <td class="pt-2"></td>
        <td class="pt-2"></td>
        <td class="pt-2"></td>
        <td class="pt-2 pl-1">{{ symbol + Math.abs(sum) }}</td>
        <td class="pt-2"></td>
        <td class="">
            <div class="flex gap-4 justify-end pr-4">
                <a href="#" class="w-4 inline-block" @click="$emit('show-create-modal')">➕</a>
            </div>
        </td>
    </tr>
</template>