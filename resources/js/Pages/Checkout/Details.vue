<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import CounterInput from "@/Components/CounterInput.vue";
import {ref} from "vue";
import {calculateTotal, listProducts, updateCart} from "@/Helpers/cart.js";
import {Link, router} from '@inertiajs/vue3';

const products = ref(listProducts() || []);
const total = ref(calculateTotal() || 0);

const clearCart = () => {
    localStorage.removeItem('cart');
    products.value = [];
    total.value = 0;
    router.visit(route('home'))
};

const updateProduct = (product, quantity) => {
    updateCart(product, quantity);
    products.value = listProducts();
    total.value = calculateTotal();
};

</script>

<template>
    <AppLayout title="Products">
        <div class="py-12 max-w-4xl mx-auto sm:px-6 lg:px-8">
            <p class="text-2xl my-auto font-extrabold leading-none tracking-tight mb-5">Seu Pedido</p>
            <div>
                <div class="flex justify-between" v-for="product in products" :key="product.id">
                    <div class="flex">
                        <img
                            :src="product.imageLink"
                            alt="Cupcake photo"
                            class="rounded-t-lg h-12 w-12"
                        >
                        <p class="my-auto ml-3">{{products.name}}</p>
                    </div>
                    <div>
                        <CounterInput
                            class="w-16"
                            v-model="product.quantity"
                            @update:model-value="updateProduct(product, $event)"
                        />
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <div class="flex justify-between">
                    <p>Subtotal ({{ products.length }} item{{ products.length > 1 ? 's' : ''}} )</p>
                    <p>R$ {{ total.toLocaleString() }}</p>
                </div>
                <div class="flex justify-between">
                    <p>Entrega</p>
                    <p>Grátis</p>
                </div>
                <div class="flex justify-between">
                    <p>Total</p>
                    <p>R$ {{ total.toLocaleString() }}</p>
                </div>
            </div>
            <div class="flex justify-between">
                <Link :href="route('checkout.form')" v-if="products.length > 0">
                    <PrimaryButton class="mt-4">Finalizar Pedido</PrimaryButton>
                </Link>
                <PrimaryButton class="mt-4" @click="clearCart">Limpar carrinho</PrimaryButton>
            </div>
        </div>
    </AppLayout>
</template>
