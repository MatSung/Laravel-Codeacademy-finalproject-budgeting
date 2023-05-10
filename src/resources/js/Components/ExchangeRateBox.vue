<script setup>
import axios from 'axios';
import { ref, watch } from 'vue';
import BlueLoadingSpinner from '@/Components/BlueLoadingSpinner.vue';

const url = 'https://api.exchangerate.host/latest';

const getTasks = async () => {
    loading.value = true;
    const response = await axios.get(url + '?base=' + currency.value).catch(() => console.log('failed api call'));
    rates.value = response.data?.rates;
    loading.value = false;
};

const rates = ref(null)
const loading = ref(true)
const currency = ref('EUR')

watch(currency, ()=>getTasks());

getTasks();

</script>

<template>
    <div class="bg-white p-2 flex flex-row items-center justify-center gap-2">
        <div>
            <select v-model="currency" name="currency">
                <option value="EUR">EUR</option>
                <option value="USD">USD</option>
                <option value="GBP">GBP</option>
                <option value="BTC">BTC</option>
            </select>
        </div>
        <div>
            <div class="flex justify-between w-36 gap-2 bg-slate-300 py-2 px-3 rounded-xl">
                <div class="font-bold">
                    EUR:
                </div>
                <BlueLoadingSpinner v-if="loading" :classes="'w-4 h-4'" />
                <div v-else class="">
                    {{ rates?.EUR ?? 'Api down.' }}
                </div>
            </div>
        </div>
        <div>
            <div class="flex justify-between w-36 gap-2 bg-slate-300 py-2 px-3 rounded-xl">
                <div class="font-bold">
                    USD:
                </div>
                <BlueLoadingSpinner v-if="loading" :classes="'w-4 h-4'" />
                <div v-else class="">
                    {{ rates?.USD ?? 'Api down.' }}
                </div>
            </div>
        </div>
        <div>
            <div class="flex justify-between w-36 gap-2 bg-slate-300 py-2 px-3 rounded-xl">
                <div class="font-bold">
                    GBP:
                </div>
                <BlueLoadingSpinner v-if="loading" :classes="'w-4 h-4'" />
                <div v-else class="">
                    {{ rates?.GBP ?? 'Api down.' }}
                </div>
            </div>
        </div>
        <div>
            <div class="flex justify-between w-36 gap-2 bg-slate-300 py-2 px-3 rounded-xl">
                <div class="font-bold">
                    BTC:
                </div>
                <BlueLoadingSpinner v-if="loading" :classes="'w-4 h-4'" />
                <div v-else class="">
                    {{ rates?.BTC ?? 'Api down.' }}
                </div>
            </div>
        </div>
    </div>
</template>