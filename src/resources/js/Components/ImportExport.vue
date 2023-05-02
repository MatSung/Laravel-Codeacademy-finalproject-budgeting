<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import PrimaryButton from './Buttons/PrimaryButton.vue';

const form = useForm({
    importFile: File,
});

</script>

<template>
    <div>
        <h1 class="text-xl font-bold mb-4">
            Import/Export database data
        </h1>
        <h2 class="text-lg font-semibold mb-3 pl-2">
            Export data
        </h2>
        <div class="pl-3 mb-3">
            <p class="mb-2">Click to download: </p>
            <a :href="route('export')" class="btn-primary" target="_blank">Export data</a>
        </div>
        <h2 class="text-lg font-semibold mb-3 pl-2">
            Import data
        </h2>
        <div class="pl-3">
            <form @submit.prevent="form.post(route('import'))">
                <input type="file" accept=".json" name="file" id="" @change="form.importFile = $event.target.files[0]">
                <PrimaryButton :disabled="form.processing">Import</PrimaryButton>
            </form>
        </div>
    </div>
</template>