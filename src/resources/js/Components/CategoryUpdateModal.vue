<script setup>
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { computed, ref } from '@vue/reactivity';
import { watch, reactive, toRefs } from 'vue';


const props = defineProps({
    show: Boolean,
    prefill: String,
    target: String,
})

let form = useForm({
    name: ''
});

watch(()=>props.prefill, ()=>{
    form = useForm({
        name: props.prefill
    });
});

</script>

<template>
    <Transition name="modal">
        <div v-if="show" class="fixed z-50 top-0 left-0 w-full h-full bg-black bg-opacity-50 flex transition-opacity"
            @click="(event) => { if (!form.processing) $emit('close') }">
            <div @click.stop class="px-8 py-5 m-auto rounded-lg max-w-sm bg-white transition-all duration-300 ease-out">
                <div class="text-black font-bold text-lg mt-0">
                    <slot name="header">Update item</slot>
                </div>
                <form
                    @submit.prevent="form.patch(target, { onSuccess: () => { form.reset(); $emit('close') }, preserveScroll: true }, { resetOnSuccess: false })">
                    <div>
                        <div>
                            <label for="name" class="block text-md font-medium leading-6 mb-2 text-gray-900">Name</label>
                            <input name="name" required maxlength="20" type="text" :placeholder="prefill" v-model="form.name">
                        </div>
                        <InputError v-for="error in form.errors" :message="error" class="mt-2 col-span-full" />
                        <div class="flex justify-center mt-2 gap-2">
                            <PrimaryButton :disabled="form.processing">Update</PrimaryButton>
                            <PrimaryButton :disabled="form.processing" :type="'button'" @click="$emit('close')">Cancel</PrimaryButton>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </Transition>
</template>
