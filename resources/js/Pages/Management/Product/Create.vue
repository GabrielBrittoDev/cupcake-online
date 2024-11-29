<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ProductForm from "@/Components/Product/ProductForm.vue";
import axios from "axios";
import {Link, router} from "@inertiajs/vue3";

const onSubmit = (product) => {
    const formData = new FormData();
    formData.append('name', product.name);
    formData.append('description', product.description);
    formData.append('ingredients', product.ingredients);
    formData.append('price', product.price);
    if (product.image) {
        formData.append('image', product.image);
    }

    axios.post('/api/v1/management/products', formData)
        .then((response) => {
            router.visit(route('management.products.list'));
        }).catch((error) => {
        console.error(error);
    });
};
</script>

<template>
    <AppLayout title="Editar Produto">
        <div class="py-12 max-w-2xl mx-auto sm:px-6 lg:px-8">
            <p class="pb-7"><Link
                :href="route('management.products.list')"
                class="text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
                Produtos
            </Link>  / <strong>Novo</strong></p>
            <ProductForm
                @submit="onSubmit"
            />
        </div>
    </AppLayout>
</template>
