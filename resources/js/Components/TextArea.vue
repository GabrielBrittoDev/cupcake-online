<script setup>
import {onMounted, ref} from 'vue';

defineProps({
    modelValue: String,
    label: String,
    placeholder: String,
    rows: {
        type: Number,
        default: 3,
    },
    cols: {
        type: Number,
        default: 20,
    },
    type: {
        type: String,
        default: 'text',
    },
});

defineEmits(['update:modelValue']);

const textArea = ref(null);

onMounted(() => {
    if (textArea.value?.hasAttribute('autofocus')) {
        textArea.value?.focus();
    }
});

defineExpose({focus: () => textArea.value?.focus()});
</script>

<template>
    <div class="flex flex-col space-y-1">
        <label for="input" v-if="label" class="text-sm font-bold text-gray-700">
            {{ label }}
        </label>
        <div class="flex items-center py-2">
            <textarea
                :cols="cols"
                :rows="rows"
                type="text"
                id="input"
                class="w-full text-sm text-gray-700 placeholder-gray-400 border border-gray-300 rounded-md hover:border-gray-500 focus:border-gray-500 focus:ring-1 focus:ring-gray-500 focus:outline-none"
                :placeholder="placeholder"
                :value="modelValue"
                @input="$emit('update:modelValue', $event.target.value)"
            />
        </div>
    </div>
</template>
