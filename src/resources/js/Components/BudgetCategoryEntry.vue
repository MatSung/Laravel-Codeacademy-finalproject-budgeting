<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import { reactive, ref, watch } from 'vue';
import { computed } from '@vue/reactivity';

const props = defineProps(['category', 'subcategories']);

const category = props.category;

//subcategory does not reload
 
const adding = ref(false);

const form = useForm({
    name: '',
    parent_id: category.id
});
//amount of entries with such category
</script>

<template>
    <div class="border border-black p-4 my-1">
        <div class="flex gap-3">
            <button class="w-4 inline-block" @click="$emit('show-delete-modal', category)">✖</button>
            <h1 class="text-lg">
                {{ category.name }} <span class="text-gray-600 text-sm"> - {{ category.entries_count }} entries</span>
            </h1>
        </div>
        <!-- am going to add editing, adding and whatever bro -->
        <div>
            <div class="flex gap-1" v-for="subcategory in props.subcategories">
                <button class="ml-4 w-4 inline-block" @click="$emit('show-delete-modal', subcategory, true)">✖</button>
                <div class="ml-1">{{ subcategory.name }}</div>
            </div>
            <div v-if="!adding" class="flex gap-1 my-2">

                <button class="ml-4  inline-block border border-black p-1 rounded-lg" @click="adding = true">➕ Add
                    Subcategory</button>
            </div>
            <div v-if="adding" class="flex gap-1 ml-4 my-2">
                <div class="relative">
                    <form
                        @submit.prevent="form.post(route('subcategories.store'), { onSuccess: () => { form.reset(); }, preserveScroll: true }, { resetOnSuccess: false })">
                        <button :disabled="form.processing" type="submit" @click=""
                            class="absolute inset-y-0 rounded-lg bg-white border-gray-500 border w-8">
                            ➕
                        </button>
                        <input type="text" v-model="form.name" class="rounded-lg pl-10 py-1 " maxlength="20"
                            placeholder="New Subcategory">
                        <button @click="adding = false"
                            class="absolute inset-y-0 right-0 rounded-lg bg-white border-gray-500 border w-8">
                            ✖
                        </button>
                    </form>
                </div>
                <InputError v-for="error in form.errors" :message="error" class="mt-2 col-span-full" />
            </div>
        </div>
    </div>
</template>