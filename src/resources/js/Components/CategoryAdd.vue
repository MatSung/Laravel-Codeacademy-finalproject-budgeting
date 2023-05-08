<script setup>
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';

const props = defineProps({
    target: {
        type: String,
        default: route('categories.store')
    }
});

const form = useForm({
    name: ''
});

</script>

<template>
    <div class="border border-black p-4 flex justify-center">
        <form
            @submit.prevent="form.post(target, { onSuccess: () => { form.reset() }, preserveScroll: true }, { resetOnSuccess: false })">
            <div>
                <div>
                    <label for="name" class="block text-md font-medium leading-6 mb-2 text-gray-900">Create a new
                        category</label>
                    <input name="name" required maxlength="20" type="text" v-model="form.name" placeholder="New Category">
                </div>
                <InputError v-for="error in form.errors" :message="error" class="mt-2 col-span-full" />
                <div class="flex justify-center mt-2">
                    <PrimaryButton :processing="form.processing">
                        <template #text>Create</template>
                    </PrimaryButton>
                </div>
            </div>
        </form>
    </div>
</template>