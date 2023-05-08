<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import mapValues from 'lodash/mapValues';


const props = defineProps({
  show: Boolean,
  target: String,
  categories: Object,
  entry: {
    type: Object,
    default: {}
  }
});

const emit = defineEmits(['close']);

const categories = props.categories;
const entry = props.entry;

let form = useForm({
  transaction_date: '',
  category_id: null,
  subcategory_id: null,
  amount: 0,
  note: ''
});

watch(entry, () => {
  if (!Object.keys(entry.value).length) {
    form = useForm({
      transaction_date: '',
      category_id: null,
      subcategory_id: null,
      amount: 0,
      note: ''
    });
  } else {
    form = useForm({
      transaction_date: entry.value.transaction_date,
      category_id: entry.value.category ? entry.value.category.id : null,
      subcategory_id: entry.value.subcategory ? entry.value.subcategory.id : null,
      amount: entry.value.amount,
      note: entry.value.note,
    });
  }
});

const reset = () => {
  form = mapValues(form, () => null);
};

const submitForm = () => {
  if (!Object.keys(entry.value).length) {
    form.post(props.target, { onSuccess: () => { form.reset(); emit('close'); }, preserveScroll: true }, { resetOnSuccess: false })
  } else {
    form.patch(props.target, { onSuccess: () => { form.reset(); emit('close'); }, preserveScroll: true }, { resetOnSuccess: false })
  }
}

</script>

<template>
  <Transition name="modal">
    <div v-if="show" class="fixed z-50 top-0 left-0 w-full h-full bg-black bg-opacity-50 flex transition-opacity"
      @mousedown="(event) => { if (!form.processing) $emit('close') }">
      <div @mousedown.stop class="px-8 py-5 m-auto rounded-lg max-w-xl bg-white transition-all duration-300 ease-out">
        <div class="text-black font-bold text-lg mt-0">
          <slot name="header">Update entry</slot>
        </div>
        <!-- PATCH OR POST -->
        <form @submit.prevent="submitForm">
          <div class="mx-auto bg-white py-8">
            <div class="mx-auto grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-4">

              <div class="col-span-2">
                <label for="transaction_date" class="block text-md font-medium leading-6 mb-2 text-gray-900">Transaction
                  Date</label>
                <input name="transaction_date" type="datetime-local" v-model="form.transaction_date"
                  max="2100-01-01T00:00" min="2000-01-01T00:00" step="1"
                  class="block w-full rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
              </div>
              <div class="col-span-1">
                <label for="category_id" class="block text-md font-medium leading-6 mb-2 text-gray-900">Category - <a
                    class="text-blue-400" :href="route('categories.index')">Edit</a></label>
                <select required ref="categorySelect" @change="form.subcategory_id = null" name="category_id"
                  v-model="form.category_id"
                  class="block w-full rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                  <option value="0" selected disabled>Please select a category</option>
                  <option v-for="category in categories" :value="category.id">{{ category.name }}</option>
                </select>
              </div>
              <div v-if="categories[form.category_id]?.subcategories.length" class="col-span-1">
                <label for="subcategory_id"
                  class="block text-md font-medium leading-6 mb-2 text-gray-900">Subcategory</label>
                <select name="subcategory_id" v-model="form.subcategory_id"
                  class="block w-full rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                  <option value=""></option>
                  <option v-for="subcategory in categories[form.category_id]?.subcategories" :value="subcategory.id">{{
                    subcategory.name }}
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
              <div class="col-span-2">
                <label for="note" class="block text-md font-medium leading-6 mb-2 text-gray-900">Note</label>
                <input name="note" maxlength="50" type="text" v-model="form.note"
                  class="block w-full rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">

              </div>
              <InputError v-for="error in form.errors" :message="error" class="mt-2 col-span-full" />
            </div>
          </div>

          <div class="flex-row gap-x-2 flex">
            <PrimaryButton :processing="form.processing">
              <template #text>
                <slot name="button">
                  Update
                </slot>
              </template>
            </PrimaryButton>
            <PrimaryButton :type="'button'" :disabled="form.processing" @click="$emit('close')">
              <template #text>Cancel</template>
            </PrimaryButton>
          </div>

        </form>
      </div>
    </div>
  </Transition>
</template>
