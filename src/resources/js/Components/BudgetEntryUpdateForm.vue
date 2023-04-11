<script setup>

const categories = props.categories;




const subcategorySelect = ref(null);


onMounted(() => {
    categorySelect.value.value = 0;
});

</script>

<template>
    <form @submit.prevent="form.post(route('entries.store'), { onSuccess: () => form.reset() }, { resetOnSuccess: false })">
        <div class="mx-auto bg-white p-8">
            <div class="mx-auto grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-4">

                <div class="col-span-2">
                    <label for="transaction_date" class="block text-md font-medium leading-6 mb-2 text-gray-900">Transaction
                        Date</label>
                    <input name="transaction_date" type="datetime-local" v-model="form.transaction_date"
                        max="2100-01-01T00:00" min="2000-01-01T00:00"
                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
                <div class="col-span-1">
                    <label for="category_id" class="block text-md font-medium leading-6 mb-2 text-gray-900">Category</label>

                    <select ref="categorySelect" @change="checkSubcategories" name="category_id" v-model="form.category_id"
                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        <option value="0" selected disabled>Please select a category</option>
                        <option v-for="category in categories" :value="category.id">{{ category.name }}</option>

                    </select>
                </div>
                <!-- reset the subcategory on selection of a different thing -->
                <div v-if="currentSubcategories.length" class="col-span-1">
                    <label for="subcategory_id"
                        class="block text-md font-medium leading-6 mb-2 text-gray-900">Subcategory</label>
                    <select name="subcategory_id" v-model="form.subcategory_id"
                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        <option value="" disabled>none</option>
                        <option v-for="subcategory in currentSubcategories" :value="subcategory.id">{{ subcategory.name }}
                        </option>
                    </select>
                </div>

                <div class="col-span-2">
                    <label for="amount" class="block text-md font-medium leading-6 mb-2 text-gray-900">Amount</label>
                    <div class="cursor-pointer relative mt-2 rounded-md shadow-sm">
                        <div @click="form.amount *= -1"
                            class="absolute inset-y-0 left-0 flex items-center px-2 bg-gray-900 rounded-sm">
                            <span class="cursor-pointer text-gray-100 text-lg sm:text-sm">±</span>
                        </div>
                        <input type="number" name="amount" step="0.01" v-model="form.amount"
                            class="block w-full rounded-md border-0 py-1.5 pl-9 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            placeholder="0.00" />
                    </div>
                </div>

                <!-- <input type="number" step=".01" v-model="form.amount"> -->
                <div class="col-span-2">
                    <label for="note" class="block text-md font-medium leading-6 mb-2 text-gray-900">Note</label>
                    <input name="note" type="text" v-model="form.note"
                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">

                </div>
                <InputError v-for="error in form.errors" :message="error" class="mt-2 col-span-full" />
                <slot>
                    <PrimaryButton class="col-span-full text-center py-3 px-8 mx-auto">Add</PrimaryButton>
                </slot>
            </div>
        </div>

    </form>
</template>