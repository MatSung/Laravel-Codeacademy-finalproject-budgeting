<script setup>

import { router, useForm, usePage } from '@inertiajs/vue3';
import pickBy from 'lodash/pickBy';
import { computed, reactive, watch } from 'vue';

const props = defineProps(['filters', 'availableDates']);

const filters = computed(() => usePage().props.filters);
const availableDates = computed(()=>usePage().props.availableDates);

const form = reactive({
    year: filters.value.year,
    month: filters.value.month,
});


watch(form, () => {
    router.get(usePage().url.split('?').shift(), pickBy(form), { preserveState: true, preserveScroll: true }, {only: ['stats']});
})

</script>

<template>
    <div class="flex gap-3">
        <div>
            <select v-model="form.year" @change="form.month = ''" name="year" id="yearSelect" class="rounded-lg">
                <option value="">Year</option>
                <option v-for="(year, key) in availableDates">{{ key }}</option>
            </select>
        </div>
        <div>
            <select v-model="form.month" name="month" id="monthSelect" class="rounded-lg">
                <option value="">Month</option>
                <option v-for="(month) in availableDates[form.year]">{{ month }}</option>
            </select>
        </div>
    </div>
</template>