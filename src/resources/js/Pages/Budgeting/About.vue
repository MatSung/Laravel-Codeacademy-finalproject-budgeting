<script setup>

import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import Socials from '@/Components/Socials.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from '@vue/reactivity';
import { ref } from 'vue';




</script>

<template>
    <Head title="Categories" />
    <DefaultLayout>
        <div class="container max-w-7xl mx-auto mt-8 rounded-lg overflow-hidden">
            <div class="bg-white p-8">
                <div class=" grid grid-cols-3 bg-white ">
                    <div class="col-span-2">
                        <h1 class="text-lg font-bold ">
                            Laravel Budgeting App
                        </h1>
                        <p class="my-5 pl-3">
                            Made as a final project for codeacademy.lt full-stack course
                        </p>
                        <p class="my-5 pl-3">
                            Made by Matas Sungaila
                        </p>

                    </div>
                    <div class="bg-gray-200 p-4 rounded-lg col-span-1">
                        <p class="font-bold">Stack:</p>
                        <ul class="list-disc ml-2 list-inside">
                            <li><a target="_blank" class="text-blue-600" href="https://laravel.com">Laravel</a></li>
                            <li><a target="_blank" class="text-blue-600" href="https://vuejs.org/">Vuejs</a></li>
                            <li><a target="_blank" class="text-blue-600" href="https://inertiajs.com/">Inertiajs</a></li>
                            <li><a target="_blank" class="text-blue-600" href="https://www.mysql.com/">Mysql</a></li>
                        </ul>
                    </div>
                </div>
                <Socials />
            </div>
        </div>
    </DefaultLayout>
</template>