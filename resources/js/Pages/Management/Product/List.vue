<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {defineComponent, onBeforeMount, ref, shallowRef, watch} from 'vue';
import "ag-grid-community/styles/ag-grid.css"; // Mandatory CSS required by the Data Grid
import "ag-grid-community/styles/ag-theme-quartz.css"; // Optional Theme applied to the Data Grid
import { AgGridVue } from "ag-grid-vue3";
import {Link} from "@inertiajs/vue3";
import {debounce} from "@/Helpers/utils.js"; // Vue Data Grid Component

const rowData = ref([]);
const productsOriginal = ref([]);
const search = ref('');
const colDefs = ref([
    { field: 'id', headerName: 'ID', width: 90, valueFormatter: (params) => `#${params.value}` },
    { field: 'imageLink', headerName: 'Foto', cellRenderer: (params) => `<img src="${params.value}" style="height: 40px; width: 40px; border-radius: 10%">` },
    { field: 'name', headerName: 'Nome' },
    { field: 'price', headerName: 'Valor', width: 130, valueFormatter: (params) => `R$ ${params.value?.toLocaleString()}` },
    { field: 'active', headerName: 'Ativo', width: 100 },
    {
        field: 'actions',
        headerName: 'Ações',
        cellRenderer: (params) => `<a href="/management/products/edit/${params.data.id}"><button class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-200">✏️</button></Link>`, width: 100
    },
]);
const paginationPageSize = ref(null);
const gridApi = shallowRef();
const cacheBlockSize = ref(null);

onBeforeMount(() => {
    paginationPageSize.value = 20;
    cacheBlockSize.value = 10;
});

const onGridReady = (params) => {
    gridApi.value = params.api;
    gridApi.value.sizeColumnsToFit();
    axios.get('/api/v1/management/products')
        .then((response) => {
            rowData.value = response.data.data.data;
            productsOriginal.value = response.data.data.data;
        }).catch((error) => {
        console.error(error);
    });
};

watch(search, debounce((value) => {
    rowData.value = productsOriginal.value.filter((product) => {
        const search = value.toLowerCase();
        return product.name.toLowerCase().includes(search);
    });
}, 500));


</script>

<template>
    <AppLayout title="Products">
        <div class="py-12 max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between">
                <p class="text-2xl my-auto font-extrabold leading-none tracking-tight">Produtos</p>
                <Link :href="route('management.products.create')">
                    <PrimaryButton>Novo</PrimaryButton>
                </Link>
            </div>
            <TextInput class="my-5 w-full" v-model="search" placeholder="Buscar produtos"/>
            <ag-grid-vue
                :rowData="rowData"
                :columnDefs="colDefs"
                :pagination="true"
                :paginationPageSize="paginationPageSize"
                :paginationPageSizeSelector="[10, 20, 50, 100]"
                :cacheBlockSize="cacheBlockSize"
                style="height: 500px"
                class="ag-theme-quartz"
                @grid-ready="onGridReady"
            >
            </ag-grid-vue>
        </div>
    </AppLayout>
</template>
