<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ProductForm from "@/Components/Product/ProductForm.vue";
import axios from "axios";
import {ref} from "vue";
import {Link, router, usePage} from "@inertiajs/vue3";

const { url } = usePage();
const product = ref({
    image: '',
    name: '',
    description: '',
    ingredients: '',
    price: '',
});
const productId = url.split('/').pop();

axios.get(`/api/v1/management/products/${productId}`)
    .then((response) => {
        product.value = response.data.data.product;
    }).catch((error) => {
        console.error(error);
    });

const onSubmit = (productData) => {
    let formData = new FormData();
    formData.append('name', productData.name);
    formData.append('description', productData.description);
    formData.append('ingredients', productData.ingredients);
    formData.append('price', productData.price);
    if (productData.image) {
        formData.append('image', productData.image);
    }

    axios.patch(`/api/v1/management/products/${productId}`, productData.image ? formData : productData)
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
            </Link>  / <strong>Editar</strong></p>
            <ProductForm
                @submit="onSubmit"
                :product="product"
            />
        </div>
    </AppLayout>
</template>
