<script setup>
import { useForm, Link, usePage } from '@inertiajs/vue3';
import PrimaryButton from './Buttons/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import InputSuccess from '@/Components/InputSuccess.vue';
import { computed } from 'vue';

const successMessage = computed(() => {
    return usePage().props.flash.notification;
});

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
            <form @submit.prevent="form.post(route('import'), { onSuccess: () => { } })">
                <input required type="file" accept=".json" name="file" id=""
                    @change="form.importFile = $event.target.files[0]">
                <PrimaryButton :disabled="form.processing"><template #text>Import</template></PrimaryButton>
                <InputError v-for="error in form.errors" :message="error" class="mt-2 col-span-full" />
                <InputSuccess v-if="successMessage" :message="successMessage" />
            </form>
        </div>
    </div>
</template>