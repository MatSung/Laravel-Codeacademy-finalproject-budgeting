<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Link } from '@inertiajs/vue3';



const props = defineProps({
  show: Boolean,
  message: String,
  target: String
})

</script>

<template>
  <Transition name="modal">
    <div v-if="show" class="fixed z-50 top-0 left-0 w-full h-full bg-black bg-opacity-50 flex transition-opacity" @click="$emit('close')">
      <div @click.stop class="px-8 py-5 m-auto rounded-lg max-w-sm bg-white transition-all duration-300 ease-out">
        <div class="text-red-600 font-bold text-lg mt-0">
          <slot name="header">Are you sure?</slot>
        </div>

        <div class="my-5 mx-0">
          <slot name="body"></slot>
        </div>

        <div class="flex-row gap-x-2 flex">
          <slot name="footer">
            <Link :href="target" as="button" class="btn-danger" method="delete">Delete</Link>
            <PrimaryButton @click="$emit('close')">Cancel</PrimaryButton>
            
          </slot>
        </div>
      </div>
    </div>
  </Transition>
</template>

<style>

.modal-container {
  /* box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33); */
  transition: all 0.3s ease;
}

.modal-header h3 {
  margin-top: 0;
}

.modal-body {
  margin: 20px 0;
}


/*
 * The following styles are auto-applied to elements with
 * transition="modal" when their visibility is toggled
 * by Vue.js.
 *
 * You can easily play with the modal transition by editing
 * these styles.
 */

.modal-enter-from {
  opacity: 0;
}

.modal-leave-to {
  opacity: 0;
}

.modal-enter-from .modal-container,
.modal-leave-to .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}
</style>