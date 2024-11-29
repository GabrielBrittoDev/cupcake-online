<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {Link, router, usePage} from "@inertiajs/vue3";
import {ref} from "vue";
import axios from "axios";

const {url} = usePage();
const orderId = url.split('/').pop();

const order = ref({});

axios.get(`/api/v1/orders/${orderId}`)
    .then((response) => {
        order.value = response.data.data?.order || {};
    }).catch((error) => {
        console.error(error);
    });

Date.prototype.addHours = function(h) {
    this.setTime(this.getTime() + (h*60*60*1000));
    return this;
}

const finishOrder = () => {
    axios.patch(`/api/v1/orders/${orderId}`, {
        status: 'canceled'
    }).then((response) => {
        router.visit(route('home'))
    }).catch((error) => {
        console.error(error);
    });

}
</script>

<template>
    <AppLayout title="Products">
        <div v-if="order.status === 'canceled'" class="py-12 max-w-2xl mx-auto sm:px-6 lg:px-8" >
            <p class="text-xl font-bold">Pedido cancelado!</p>
            <Link :href="route('home')" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Voltar para a página inicial
            </Link>
        </div>
        <div v-else-if="order.status === 'completed'" class="py-12 max-w-2xl mx-auto sm:px-6 lg:px-8" >
            <p class="text-xl font-bold">Pedido concluído!</p>
            <Link :href="route('home')"  class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Voltar para a página inicial
            </Link>
        </div>
        <div class="py-12 max-w-2xl mx-auto sm:px-6 lg:px-8" v-else>
            <p class="text-2xl my-5 font-extrabold leading-none tracking-tight">Acompanhe seu pedido</p>
            <p class="font-extrabold mb-5">Pedido #{{ order.id }}</p>
            <div v-if="order.deliveryType === 'delivery'">
                <p class="font-bold">Entrega prevista</p>
                <p class="mb-5">{{ new Date(order.createdAt)?.toLocaleString() }}</p>
            </div>
            <div v-else>
                <p class="font-bold">Retirada disponivel</p>
            </div>
            <p class="font-bold">Pedido feito</p>
            <p>{{ new Date(order.createdAt).addHours(1).toLocaleString() }}</p>
            <p class="text-2xl my-5 font-extrabold leading-none tracking-tight">Detalhes da entrega</p>
            <p class="font-bold">Cliente</p>
            <p class="mb-5">{{ order.client?.name }}</p>
            <p class="font-bold">Endereço de entrega</p>
            <p>{{ order.address?.street + '' + order.address?.number + ' ' + order.address?.neighborhood}}</p>
            <p class="text-2xl my-5 font-extrabold leading-none tracking-tight">Detalhes do Pedido</p>
            <div class="flex mb-3" v-for="item in order.items" :key="item.id">
                <img
                    :src="item.product.imageLink"
                    alt="Foto do produto"
                    class="w-16 h-16 rounded-lg">
                <div class="ml-2">
                    <p>{{ item.product.name }} X {{item.quantity}}</p>
                    <p>R$ {{ item.total?.toLocaleString() }}</p>
                </div>
            </div>
            <p class="mt-5 mb-2 font-bold">Subtotal</p>
            <p class="mb-5">R$ {{ order.total?.toLocaleString() }}</p>
            <p class="mb-2 font-bold">Taxa de Entrega</p>
            <p class="mb-5">Grátis</p>
            <p class="mb-2 font-bold">Total</p>
            <p>R${{ order.total?.toLocaleString() }}</p>
            <PrimaryButton class="mt-5 text-center w-auto" @click="finishOrder">Cancelar Pedido</PrimaryButton>
        </div>
    </AppLayout>
</template>
