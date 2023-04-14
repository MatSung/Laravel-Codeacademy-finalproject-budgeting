<script setup>
import DeleteModal from '@/Components/DeleteModal.vue';
import BudgetCategoryEntry from '@/Components/BudgetCategoryEntry.vue';
import { usePage } from '@inertiajs/vue3';
import { computed } from '@vue/reactivity';


const props = defineProps(['categories']);

const categories = computed(() => usePage().props.categories);


</script>

<template>
    <div>
        <div class="w-full border bg-red-100 flex flex-col gap-0">
            <BudgetCategoryEntry v-for="category in categories" :key="category.id" :category="category" />
        </div>
    </div>
</template>