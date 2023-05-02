<script setup>

import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import Socials from '@/Components/Socials.vue';
import ImportExport from '@/Components/ImportExport.vue';
import { Head, usePage, useForm, Link } from '@inertiajs/vue3';
import { computed } from '@vue/reactivity';
import { ref } from 'vue';





</script>

<template>
    <Head title="Settings" />
    <DefaultLayout>
        <div class="container max-w-7xl mx-auto mt-8 rounded-lg overflow-hidden">
            <div class="bg-white rounded-lg p-5">
                
                <ImportExport />
            </div>
        </div>
    </DefaultLayout>
</template>