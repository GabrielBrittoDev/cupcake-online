<script setup>
import {onMounted, ref} from 'vue';

const props = defineProps({
    modelValue: {
        type: Number,
        default: 1,
    },
});
const emits = defineEmits(['update:modelValue']);

function increment() {
    const newValue = parseInt(props.modelValue) + 1;
    emits('update:modelValue', newValue);
}

function decrement() {
    const newValue = parseInt(props.modelValue) - 1;
    emits('update:modelValue', newValue);
}

const input = ref(null);

onMounted(() => {
    if (input.value?.hasAttribute('autofocus')) {
        input.value?.focus();
    }
});

defineExpose({focus: () => input.value?.focus()});
</script>

<template>
    <div class="flex items-center space-x-2">
        <button
            @click="decrement"
            class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200"
        >
            -
        </button>
        <span class="text-gray-700 font-bold">{{ modelValue }}</span>
        <button
            @click="increment"
            class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200"
        >
            +
        </button>
    </div>
</template>
