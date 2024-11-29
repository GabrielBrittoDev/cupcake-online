<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <button :type="type" class="text-center inline-flex items-center px-4 py-2 border border-transparent rounded-md font-extrabold text-xs text-white tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150 btn">
        <slot class="mx-auto"/>
    </button>
</template>

<style scoped>
.btn {
    background-color: #e52c4c;
}
</style>
