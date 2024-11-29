<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import TextInput from "@/Components/TextInput.vue";
import {ref, watch} from 'vue';
import "ag-grid-community/styles/ag-grid.css"; // Mandatory CSS required by the Data Grid
import "ag-grid-community/styles/ag-theme-quartz.css"; // Optional Theme applied to the Data Grid
import { AgGridVue } from "ag-grid-vue3";
import {Link} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {debounce} from "@/Helpers/utils.js"; // Vue Data Grid Component

const rowData = ref([]);
const search = ref('');

watch(search, debounce((value) => {
    orders.value = ordersOriginal.value.filter((order) => {
        const search = value.toLowerCase();
        return order.client.name.toLowerCase().includes(search)
            || order.items.some((item) => item.product.name.toLowerCase().includes(search))
            || order.id.toString().includes(search);
    });
}, 500));

const statusEnum = {
    pending: 'Pendente',
    processing: 'Processando',
    completed: 'Completado',
    canceled: 'Cancelado',
};

const colDefs = ref([
    { field: 'id', headerName: 'ID', width: 90, valueFormatter: (params) => `#${params.value}` },
    { field: 'status', headerName: 'Status', width: 120, valueFormatter: (params) => statusEnum[params.value] },
    { field: 'client.name', headerName: 'Cliente', width: 300},
    { field: 'address.street', headerName: 'Endereço', width: 180 },
    { field: 'total', headerName: 'Valor', width: 130, valueFormatter: (params) => `R$ ${params.value?.toLocaleString()}` },
    { field: 'createdAt', headerName: 'Data/Hora', cellRenderer: (params) => new Date(params.value).toLocaleString() },
]);

axios.get('/api/v1/orders')
    .then((response) => {
        rowData.value = response.data.data.data;
        console.log(rowData.value)
    }).catch((error) => {
        console.error(error);
    });
</script>

<template>
    <AppLayout title="Historico de Pedidos">
        <div class="py-12 max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between">
                <p class="text-2xl my-auto font-extrabold leading-none tracking-tight">Histórico de Pedidos</p>
                <Link :href="route('management.orders.queue')">
                    <PrimaryButton>Fila de pedidos</PrimaryButton>
                </Link>
            </div>
            <TextInput class="my-5 w-full" placeholder="Buscar pedidos"/>
            <ag-grid-vue
                :rowData="rowData"
                :columnDefs="colDefs"
                style="height: 500px"
                class="ag-theme-quartz"
            >
            </ag-grid-vue>
        </div>
    </AppLayout>
</template>
