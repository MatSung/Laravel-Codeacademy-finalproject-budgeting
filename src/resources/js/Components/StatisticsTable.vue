<script setup>
import PieChart from '@/Components/PieChart.vue';
import StatisticsDateSelector from '@/Components/StatisticsDateSelector.vue';
import { computed, reactive, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { omitBy } from 'lodash'

const props = defineProps(['stats']);

const stats = computed(() => {
    const propStats = props.stats;
    propStats.expense.reverse();
    return propStats;
});

const style = {
    height: '500px',
    width: '500px',
    position: 'relative'
};

const isIncome = ref(true);
const indexOfCategory = ref(0);
const reactiveStatObject = computed(() => isIncome.value ? stats.value.income : stats.value.expense);

</script>

<template>
    <div v-if="stats.expense.length > 0">
        <div class="grid grid-cols-4 gap-2">
            <div class="col-span-1 border flex flex-col gap-2">
                <template v-for="(category, index) in reactiveStatObject">
                    <div class="p-4 border font-bold text-white text-left rounded-lg"
                        :class="index == indexOfCategory ? 'bg-slate-500' : 'bg-slate-800'">
                        <button type="button" class="flex flex-row w-full justify-between " @click="indexOfCategory = index">
                            <div>
                                {{ category.name }}
                            </div>
                            <div>
                                {{ category.amount.toFixed(2) }}
                            </div>

                        </button>
                    </div>
                    <!-- <div v-if="index == indexOfCategory" class="px-4 pb-4 pt-2 flex flex-col">
                        <p>
                            Subcategories: {{ category.subcategories.length }}
                        </p>
                    </div> -->
                </template>
            </div>
            <div class="col-span-3 border min-h-[600px] flex justify-center bg-gray-50 relative">
                <div class="absolute py-2 grid grid-cols-5">
                    <StatisticsDateSelector class="col-span-2" />
                    <button type="button" @click="$event => { isIncome = !isIncome }">
                        <span :class="isIncome ? 'font-bold' : ''">Income</span> / <span
                            :class="isIncome ? '' : 'font-bold'">Expense</span>
                    </button>
                </div>
                <div v-if="reactiveStatObject[indexOfCategory]?.subcategories.length > 0" class="my-auto relative">
                    <PieChart :stats="reactiveStatObject[indexOfCategory]?.subcategories" :position="'bottom'"
                        :style="style" />
                </div>
                <div v-if="reactiveStatObject[indexOfCategory]?.subcategories.length == 0" class="my-auto text-center">
                    <p>Please select a category with more than one subcategory with data to display a chart.</p>
                </div>
            </div>
        </div>

    </div>
    <div v-else>
        <div class="text-center">
            No data in the database.
        </div>

    </div>
</template>