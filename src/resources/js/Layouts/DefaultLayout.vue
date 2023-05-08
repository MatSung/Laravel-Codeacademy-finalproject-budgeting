<script setup>

import NavLink from '@/Components/NavLink.vue';
import { Link } from '@inertiajs/vue3';


</script>

<template>
    <div class="bg-gray-100 min-h-screen">
        <nav class="bg-slate-800">
            <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
                <div class="relative flex h-16 items-center justify-between">
                    <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                        <!-- Mobile menu button-->
                        <button type="button"
                            class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                            aria-controls="mobile-menu" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <!--
                  Icon when menu is closed.
      
                  Menu open: "hidden", Menu closed: "block"
                -->
                            <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                            <!--
                  Icon when menu is open.
      
                  Menu open: "block", Menu closed: "hidden"
                -->
                            <svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                        <div class="flex flex-shrink-0 items-center">
                            <img class="block h-8 w-auto lg:hidden" src="favicon.ico" alt="Your Company">
                            <img class="hidden h-8 w-auto lg:block" src="favicon.ico" alt="Your Company">
                        </div>
                        <div class="hidden w-full sm:ml-6 sm:block">
                            <div class="flex justify-between w-full">
                                <div class="flex space-x-4">
                                    <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                                    <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                        Dashboard
                                    </NavLink>
                                    <NavLink :href="route('categories.index')"
                                        :active="route().current('categories.index')">
                                        Categories
                                    </NavLink>
                                    <NavLink :href="route('entries.index')" :active="route().current('entries.index')">
                                        Transactions
                                    </NavLink>

                                    <NavLink :href="route('statistics')" :active="route().current('statistics')">
                                        Statistics
                                    </NavLink>
                                </div>
                                <div class="flex justify-end space-x-4">
                                    <NavLink :href="route('exchange')" :active="route().current('exchange')">
                                        Exchange
                                    </NavLink>

                                    <NavLink :href="route('about')" :active="route().current('about')">
                                        About
                                    </NavLink>

                                    <NavLink :href="route('settings')" :active="route().current('settings')">
                                        Settings
                                    </NavLink>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">

                    </div>
                </div>
            </div>

            <!-- Mobile menu, show/hide based on menu state. -->
            <div class="sm:hidden" id="mobile-menu">
                <div class="space-y-1 px-2 pt-2 pb-3">
                    <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                    <a href="#" class="bg-gray-900 text-white block rounded-md px-3 py-2 text-base font-medium"
                        aria-current="page">Dashboard</a>

                    <a href="#"
                        class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Statistics</a>

                    <a href="#"
                        class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Settings</a>

                    <a href="#"
                        class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">About</a>
                </div>
            </div>
        </nav>
        <main>
            <slot />
        </main>
    </div>
</template>
