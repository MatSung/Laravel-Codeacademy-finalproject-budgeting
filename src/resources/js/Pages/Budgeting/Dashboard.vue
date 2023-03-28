<script setup>

import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import EntryTable from '@/Components/EntryTable.vue';
import { useForm, Head } from '@inertiajs/vue3';

defineProps(['entries']);

</script>

<template>
    <Head title="Index" />

    <DefaultLayout>
        <div class="container max-w-7xl mx-auto mt-8 rounded overflow-hidden">
            <EntryTable />
        </div>
    </DefaultLayout>


</template>