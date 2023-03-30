<script setup>

import { reactive, computed } from 'vue'

const props = defineProps(['entries']);
const entries = props.entries;

const sum = computed(() => {
    return Object.values(entries)
        .reduce((total, obj) => obj.amount + total, 0)
        .toFixed(2);
});

const symbol = computed(()=>{
    return sum < 0 ? '-' : (sum == 0) ? '±' : '+';
});

</script>

<template>
    <tr class="bg-slate-300 border-b-2 text-gray-500">
        <td class="pt-2"></td>
        <td class="pt-2"></td>
        <td class="pt-2"></td>
        <td class="pt-2"></td>
        <td class="pt-2">{{ symbol + sum }}</td>
        <td class="pt-2"></td>
        <td class="">
            <div class="flex gap-4 justify-end pr-4">
                <a href="#" class="w-4 inline-block">➕</a>
            </div>
        </td>
    </tr>
</template>