<script setup>

import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { useForm, Head, usePage } from '@inertiajs/vue3';
import { computed } from '@vue/reactivity';
import { ref } from 'vue';

import CategoryTable from '@/Components/CategoryTable.vue';
import Modal from '@/Components/DeleteModal.vue';



const props = defineProps(['categories']);

const categories = computed(() => usePage().props.categories);


const showModal = ref(false);
</script>

<template>
    <Head title="Categories" />
    <DefaultLayout>
        <div class="container max-w-7xl mx-auto mt-8 rounded overflow-hidden">
            <CategoryTable :categories="categories" />
        </div>
    </DefaultLayout>
</template>