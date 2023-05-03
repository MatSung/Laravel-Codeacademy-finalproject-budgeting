<script setup>
import InputSuccess from './InputSuccess.vue';
import { computed, ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';


const successMessage = computed(() => {
    return usePage().props.flash.notification;
});

const confirming = ref(false);

</script>

<template>
    <div>
        <h1 class="text-xl font-bold my-4">
            Purge
        </h1>
        <h2 class="text-lg font-semibold mb-3 pl-2">
            Purge all user data
        </h2>
        <div class="pl-3 mb-3">
            <p class="mb-2">Click to purge </p>
            <button v-if="!confirming" @click="confirming = true" type="button" class="btn-danger">Purge</button>
            <Link v-if="confirming" :href="route('purge')" class="btn-danger">ARE YOU SURE?</Link>
            <InputSuccess v-if="successMessage" :message="successMessage" />
        </div>
    </div>
</template>