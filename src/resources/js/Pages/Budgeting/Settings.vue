<script setup>

import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import ImportExport from '@/Components/ImportExport.vue';
import PurgeButton from '@/Components/PurgeButton.vue';
import { Head } from '@inertiajs/vue3';






</script>

<template>
    <Head title="Settings" />
    <DefaultLayout>
        <div class="container max-w-7xl mx-auto mt-8 rounded-lg overflow-hidden">
            <div class="bg-white rounded-lg p-5">
                
                <ImportExport />
                <PurgeButton />
            </div>
        </div>
    </DefaultLayout>
</template>