<script setup lang="ts">
import ToastItem from './ToastItem.vue';  
import { ref } from 'vue';
import useToast from '@/store/toast';

const toast = useToast();
const items = ref(toast.toasts);

function remove(index: number) {
    items.value.splice(index, 1);
}
</script>

<template>

<div class="fixed top-4 right-4 z-50">
    <ToastItem 
    v-for="(item, index) in items" 
    :key="index" 
    :message="item.message"
    :type="item.type"
    @remove="remove(index)"
    />
</div>
</template>

