<script setup>
import { reactive } from 'vue';

const props = defineProps(['category']);

const category = props.category;

//amount of entries with such category
</script>

<template>
    <div class="w-full border p-4">
        <div>
            <h1 class="text-lg">
                {{ category.name }}
            </h1>
        </div>
        <div v-if="category.subcategories.length">
            <div class="flex gap-1" v-for="subcategory in category.subcategories">
                <div class="ml-4">{{ subcategory.name }}</div>
            </div>
        </div>
    </div>
</template>