<script setup>
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import { Link } from '@inertiajs/vue3';
import { computed } from '@vue/reactivity';




const props = defineProps({
  show: Boolean,
  message: String,
  target: String,
  isBlocked: {
    type: Boolean,
    default: false
  }
})

const blockedClass = computed(()=>{
  return props.isBlocked ? 'btn-disabled' : 'btn-danger';
});

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
            <Link :href="target" :disabled="isBlocked" @click="$emit('close')" as="button" :class="blockedClass" method="delete">Delete</Link>
            <PrimaryButton @click="$emit('close')">Cancel</PrimaryButton>
          </slot>
        </div>
      </div>
    </div>
  </Transition>
</template>
