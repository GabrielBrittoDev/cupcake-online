<script setup>
import { ref } from 'vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";

const emit = defineEmits(['file-selected']);
defineProps({
    label: String,
    modelValue: File,
});
const fileInput = ref(null);
const fileName = ref(null);

const handleFileChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        fileName.value = file.name;
        emit('update:modelValue', file);
        return;
    }

    fileName.value = null;
    emit('update:modelValue', null);
};

const triggerFileInput = () => {
    fileInput.value.click();
};
</script>

<template>
    <div class="mb-4">
        <label v-if="label" for="fileInput" class="text-sm font-bold text-gray-700 mb-2">
            {{ label }}
        </label>
        <br>
        <input
            type="file"
            ref="fileInput"
            class="hidden"
            accept="image/*"
            @change="handleFileChange"
        />
        <PrimaryButton
            type="button"
            class="bg-blue-500 text-white px-4 py-1 rounded mb-0.5"
            @click="triggerFileInput"
        >
            Selecionar arquivo
        </PrimaryButton>
        <p v-if="fileName">{{ fileName }}</p>
    </div>
</template>

<style scoped>
.hidden {
    display: none;
}
</style>
