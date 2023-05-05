<script setup>
import PieChart from '@/Components/PieChart.vue';
import { computed, reactive, ref } from 'vue';

const props = defineProps(['stats']);

const stats = props.stats;
stats.expense.reverse();


const style = {
    height: '500px',
    width: '500px',
    position: 'relative'
};

const isIncome = ref(true);
const indexOfCategory = ref(0);
const reactiveStatObject = computed(()=>isIncome.value ? stats.income : stats.expense);

</script>

<template>
    <div v-if="stats.expense.length > 0">
        <div class="grid grid-cols-4 gap-2">
            <div class="col-span-1 border flex flex-col">
                <template v-for="(category, index) in reactiveStatObject">
                    <div class="p-4 border font-bold text-white text-left bg-slate-800" :class="index == indexOfCategory ? 'bg-slate-500' : ''" >
                        <button type="button" class="" @click="indexOfCategory=index">
                            {{ category.name }}
                        </button>
                    </div>
                    <div v-if="index == indexOfCategory" class="px-4 pb-4 pt-2 flex flex-col">
                        <p>
                            Total: {{ category.amount }}
                        </p>
                        <p>
                            Subcategories: {{ category.subcategories.length }}
                        </p>
                    </div>
                </template>
            </div>
            <div  class="col-span-3 border min-h-[600px] flex justify-center bg-gray-50 relative">
                <div class="absolute py-2">
                    <button type="button" @click="$event => {isIncome = !isIncome}">
                        <span :class="isIncome ? 'font-bold' : ''">Income</span> / <span :class="isIncome ? '' : 'font-bold'">Expense</span>
                    </button>
                </div>
                <div v-if="reactiveStatObject[indexOfCategory].subcategories.length > 0" class="my-auto relative">
                    <PieChart :stats="reactiveStatObject[indexOfCategory].subcategories" :position="'bottom'" :style="style"/>
                </div>
                <div v-if="reactiveStatObject[indexOfCategory].subcategories.length == 0" class="my-auto text-center">
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