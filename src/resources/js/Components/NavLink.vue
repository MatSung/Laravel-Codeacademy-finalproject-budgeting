<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps(['href', 'active']);

const classes = computed(() =>
    props.active
        ? 'bg-gray-900 text-white rounded-md px-3 py-2 text-sm font-medium'
        : 'text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium'
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
