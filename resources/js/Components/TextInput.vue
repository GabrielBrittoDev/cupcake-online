<script setup>
import {onMounted, ref} from 'vue';
import InputError from "@/Components/InputError.vue";

defineProps({
    modelValue: String,
    icon: String,
    label: String,
    error: String,
    placeholder: String,
    type: {
        type: String,
        default: 'text',
    },
});

defineEmits(['update:modelValue']);
const input = ref(null);

onMounted(() => {
    if (input.value?.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({focus: () => input.value?.focus()});
</script>

<template>
    <div class="flex flex-col space-y-1">
        <label for="input" v-if="label" class="text-sm font-bold text-gray-700">
            {{ label }}
        </label>
        <div class="flex items-center pb-3">
            <span v-if="icon" class="mr-2 text-gray-500">
                <slot name="icon">
                  <i :class="icon" class="text-lg"></i>
                </slot>
            </span>
            <input
                :type="type"
                id="input"
                class="w-full text-sm text-gray-700 placeholder-gray-400 border border-gray-300 rounded-md hover:border-gray-500 focus:border-gray-500 focus:ring-1 focus:ring-gray-500 focus:outline-none"
                :placeholder="placeholder"
                :value="modelValue"
                @input="$emit('update:modelValue', $event.target.value)"
            />
            <InputError class="mt-2" :message="error" />
        </div>
    </div>
</template>
