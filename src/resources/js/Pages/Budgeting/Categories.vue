<script setup>

import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import BudgetEntryAddForm from '@/Components/BudgetEntryAddForm.vue';
import EntryTable from '@/Components/EntryTable.vue';
import { useForm, Head, usePage } from '@inertiajs/vue3';
import { computed } from '@vue/reactivity';
import { ref } from 'vue';

import Modal from '@/Components/DeleteModal.vue';



const props = defineProps(['categories']);

const entries = computed(() => usePage().props.entries);


const showModal = ref(false);
</script>

<script setup>

</script>

<template>
    <button id="show-modal" @click="showModal = true">Show Modal</button>

    <Teleport to="body">
        <modal :show="showModal" @close="showModal = false">
            <template #header>
                <h3>Delete?</h3>
            </template>
            <template #body>
                <p>Are you sure you want to delete category</p>
            </template>
        </modal>
    </Teleport>
</template>