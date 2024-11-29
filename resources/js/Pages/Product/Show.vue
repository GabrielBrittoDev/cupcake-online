<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {ref} from "vue";
import {router, usePage, useRemember} from "@inertiajs/vue3";
import { addToCart } from "@/Helpers/Cart";

const product = ref({});
const { url } = usePage();
const productId = url.split('/').pop();
const response = axios.get(`/api/v1/products/${productId}`)
    .then((response) => {
        product.value = response.data.data.product;
    }).catch((error) => {
        console.error(error);
    });

const addCart = () => {
    addToCart(product.value);
    router.visit(route('home'))
}
</script>

<template>
    <AppLayout title="Produto">
        <div class="py-12 max-w-3xl mx-auto sm:px-6 lg:px-8">
            <p class="text-2xl mb-5 font-extrabold leading-none tracking-tight">{{ product.name }}</p>
            <img
                :src="product.imageLink"
                alt="Foto do Produto"
                class="w-full h-64 object-cover rounded-t-lg">
            <p class="py-3">{{ product.description }}</p>
            <div class="flex">
                <div class="py-3">
                    <p class="font-bold">Ingredientes</p>
                    <p>{{ product.ingredients }}</p>
                </div>
            </div>
            <div class="border rounded-lg p-4 mx-w-3">
                <p>Valor</p>
                <p class="text-xl font-semibold">R$ {{ product.price?.toLocaleString() }}</p>
            </div>

            <PrimaryButton class="mt-4" @click="addCart">Adicionar ao carrinho</PrimaryButton>
        </div>
    </AppLayout>
</template>
