<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Link } from '@inertiajs/vue3';
import {ref, watch} from "vue";
import { listProducts } from "@/Helpers/cart.js";
import {debounce} from "@/Helpers/utils.js";

const originalProducts = ref([]);
const products = ref([]);
const search = ref('');
const summaryProducts = ref(listProducts());

const response = axios.get('/api/v1/products')
    .then((response) => {
        products.value = response.data.data.products;
        originalProducts.value = response.data.data.products;
    }).catch((error) => {
        console.error(error);
    });

watch(search, debounce((value) => {
    const search = value.toLowerCase();
    return products.value = originalProducts.value.filter((product) => {
        return product.name.toLowerCase().includes(search)
            || product.description.toLowerCase().includes(search);
    });
}, 500));

</script>

<template>
    <AppLayout title="Home">
        <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-12 gap-12">
                <div class="col-span-7">
                    <div class="mb-8 flex">
                        <p class="text-2xl text-center mb-1 font-extrabold leading-none tracking-tight">Produtos</p>
                        <TextInput
                            class="w-full ml-5"
                            placeholder="Buscar cupcakes"
                            v-model="search"
                        />
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <Link :href="`products/${product.id}`" class="mx-w-3" v-for="product in products" :key="product.id">
                            <img :src="product.imageLink" alt="Foto do Produto" class="w-full h-32 object-cover rounded-lg">
                            <p class="mt-2 text-lg font-semibold">{{ product.name }}</p>
                            <p class="mt-1 text-gray-600">{{ product.description }}</p>
                            <p class="mt-4 text-xl font-bold">{{`R$ ${product.price?.toLocaleString()}` }}</p>
                        </Link>
                    </div>
                </div>
                <div class="col-start-8 col-span-4">
                    <p class="text-2xl mb-2 font-extrabold leading-none tracking-tight">Sumário</p>
                    <div>
                        <div class="flex items-center mb-3" v-for="product in summaryProducts" :key="product?.id">
                            <img
                                :src="product?.imageLink"
                                alt="Foto do produto"
                                class="w-16 h-16 object-cover rounded-lg mr-2"
                            >
                            <p>{{ product?.name }}</p>
                        </div>
                    </div>
                    <p class="text-gray-500 mt-3">{{ summaryProducts.length }} item{{ summaryProducts.length > 1 ? 's' : ''}}</p>
                    <Link :href="route('checkout.details')">
                        <PrimaryButton class="mt-3">Checkout</PrimaryButton>
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
