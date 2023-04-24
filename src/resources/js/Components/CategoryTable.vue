<script setup>
import DeleteModal from '@/Components/DeleteModal.vue';
import CategoryUpdateModal from '@/Components/CategoryUpdateModal.vue';
import BudgetCategoryEntry from '@/Components/BudgetCategoryEntry.vue';
import CategoryAdd from '@/Components/CategoryAdd.vue';
import { usePage } from '@inertiajs/vue3';
import { computed } from '@vue/reactivity';
import { ref, reactive } from 'vue';


const props = defineProps(['categories']);
const categories = computed(() => usePage().props.categories);

const deletionState = reactive({
    show: false,
    target: '#',
    blocked: false,
});

const msgs = {
    'subcategory-delete-msg': 'Are you sure you want to delete this subcategory? This will remove it from any associated entries.',
    'category-delete-msg': 'Are you sure you want to delete this category?',
    'cannot-delete-category': 'Unable to delete category due to existing entries.',
    'also-delete-subcategories': 'This category still has subcategories which will be deleted as well!',
    'categories': 'category',
    'subcategories': 'subcategory'
};

const msg = ref(msgs['category-delete-msg']);

const activateDeleteModal = (item, isSubcategory = false) => {
    let type = 'categories';
    deletionState.blocked = false;

    if (isSubcategory) {
        type = 'subcategories';
        msg.value = msgs['subcategory-delete-msg'];
    } else {
        if (item.entries_count > 0) {
            msg.value = msgs['cannot-delete-category'];
            deletionState.blocked = true;
        } else if (item.subcategories.length === 0) {
            msg.value = msgs['category-delete-msg'];
        } else {
            msg.value = msgs['also-delete-subcategories'];
        }
    }
    deletionState.target = route(type + '.destroy', item.id);
    deletionState.show = true;
}

const updateState = reactive({
    show: false,
    target: '#',
    prefill: '',
    type: 'categories',
});

const activateUpdateModal = (item, isSubcategory = false) => {
    updateState.type = isSubcategory ? 'subcategories' : 'categories';
    updateState.prefill = item.name;
    updateState.target = route(updateState.type + '.update', item.id);
    updateState.show = true
}

</script>

<template>
    <div>
        <div class="w-full bg-gray-200 flex flex-col gap-0">
            <CategoryAdd />
            <BudgetCategoryEntry v-for="category in categories" :key="category.id" :category="category" :subcategories="category.subcategories"
                @show-delete-modal="activateDeleteModal" @show-update-modal="activateUpdateModal"/>
        </div>
        <Teleport to="body">
            <DeleteModal :show="deletionState.show" :is-blocked="deletionState.blocked" :target="deletionState.target"
                @close="deletionState.show = false">
                <template #header>
                    <h3>Delete?</h3>
                </template>
                <template #body>
                    <p>{{ msg }}</p>
                </template>
            </DeleteModal>
            <CategoryUpdateModal v-bind="updateState" @close="updateState.show = false">
                <template #header>
                    Update {{ msgs[updateState.type] }}.
                </template>
            </CategoryUpdateModal>
        </Teleport>
    </div>
</template>