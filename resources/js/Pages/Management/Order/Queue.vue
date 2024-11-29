<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {ref, watch} from "vue";
import axios from "axios";
import {debounce} from "@/Helpers/Utils.js";

const ordersOriginal = ref([]);
const orders = ref([]);
const search = ref('');


axios.get('/api/v1/orders/queue')
    .then((response) => {
        ordersOriginal.value = response.data.data.orders;
        orders.value = response.data.data.orders;
        console.log(orders.value)
    }).catch((error) => {
    console.error(error);
});

watch(search, debounce((value) => {
    orders.value = ordersOriginal.value.filter((order) => {
        const search = value.toLowerCase();
        return order.client.name.toLowerCase().includes(search)
            || order.items.some((item) => item.product.name.toLowerCase().includes(search))
            || order.id.toString().includes(search);
    });
}, 500));

const finishOrder = (orderId) => {
    axios.patch(`/api/v1/orders/${orderId}`, {
        status: 'completed'
    }).then(() => {
        ordersOriginal.value = ordersOriginal.value.filter((order) => order.id !== orderId);
        orders.value = orders.value.filter((order) => order.id !== orderId);
    }).catch((error) => {
        console.error(error);
    });
};
</script>

<template>
    <AppLayout title="Products">
        <div class="py-12 max-w-2xl mx-auto sm:px-6 lg:px-8">
            <p class="py-5 text-2xl my-auto font-extrabold leading-none tracking-tight">Fila de Pedidos</p>
            <TextInput v-model="search" class="w-full" placeholder="Buscar pedidos"/>
            <div v-for="order in orders" :key="order.id" class="mb-5">
                <div class="grid grid-cols-12">
                    <div class="col-span-9">
                        <p class="font-bold">{{order.client.name}}</p>
                        <p>{{ order.status }}</p>
                        <p>Pedido #{{ order.id }} - {{ order.items.length}} item{{order.items.length > 1 ? 's' : ''}}</p>
                    </div>
                    <div class="col-span-3 ml-16">
                        <PrimaryButton class="h-4" @click="finishOrder(order.id)">Finalizar</PrimaryButton>
                    </div>
                </div>
                <div class="ml-2">
                    <p class="py-3 text-xl my-auto font-extrabold leading-none tracking-tight">Produtos</p>
                    <div class="flex justify-between">
                        <div class="flex mb-5" v-for="item in order.items" :key="item.id">
                            <img
                                :src="item.product.imageLink"
                                alt="Foto do Produto"
                                class="w-12 h-12 rounded-lg">
                            <div class="ml-2">
                                <div class="flex"><p>{{item.product.name}}  </p><strong class="ml-3.5">X {{ item.quantity }}</strong></div>
                            </div>
                        </div>
                    </div>
                    <p class="py-2 text-xl my-auto font-extrabold leading-none tracking-tight">Observações</p>
                    <p class="mb-5">{{order.observation || 'Nenhuma observação'}}</p>
                    <p class="py-2 text-xl my-auto font-extrabold leading-none tracking-tight">Forma de entrega</p>
                    <p class="mb-5">
                        {{order.deliveryType === 'delivery' ? 'Entrega' : 'Retirada'}}
                    </p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
