<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import TextInput from "@/Components/TextInput.vue";
import TextArea from "@/Components/TextArea.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {ref} from "vue";
import axios from "axios";
import {clearCart, listProducts} from "@/Helpers/Cart.js";
import {Link, router} from "@inertiajs/vue3";
import Dropdown from "@/Components/Dropdown.vue";

const address = ref({});
const client = ref({});
const deliveryType = ref('pickup');
const observation = ref(null);

const submit = () => {
    const products = listProducts();

    axios.post('/api/v1/orders', {
        address: address.value,
        client: client.value,
        deliveryType: deliveryType.value,
        observation: observation.value,
        items: products.map((product) => {
            return {
                productId: product.id,
                quantity: product.quantity
            }
        })
    }).then((response) => {
        router.visit(route('orders.track', {id: response.data.data.order.id}));
        clearCart();
    }).catch((error) => {
        console.error(error);
    });
}

</script>

<template>
    <AppLayout title="Products">
        <div class="py-12 max-w-2xl mx-auto sm:px-6 lg:px-8">
            <p class="pb-7">
                <Link
                    :href="route('checkout.details')"
                    class="text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Carrinho
                </Link> / <strong>Checkout</strong></p>
            <p class="text-2xl my-5 font-extrabold leading-none tracking-tight">Informações de contato</p>
            <TextInput
                placeholder="Nome"
                label="Nome"
                v-model="client.name"
            />
            <TextInput
                placeholder="Celular"
                label="Celular"
                v-model="client.phone"
            />
            <TextInput
                placeholder="Email"
                label="Email"
                v-model="client.email"
            />
            <p class="text-2xl font-extrabold leading-none tracking-tight my-5">Endereço de entrega</p>
            <TextInput
                placeholder="Logradouro"
                label="Logradouro"
                v-model="address.street"
            />
            <div class="grid grid-cols-2 gap-16">
                <TextInput
                    placeholder="Bairro"
                    label="Bairro"
                    v-model="address.neighborhood"
                />
                <TextInput
                    placeholder="Número"
                    label="Número"
                    v-model="address.number"
                />
            </div>
            <div class="grid grid-cols-2 gap-16">
                <TextInput
                    placeholder="Cidade"
                    label="Cidade"
                    v-model="address.city"
                />
                <div>
                    <label for="state" class="text-sm font-bold text-gray-700">Estado</label>
                    <select
                    class="h-10 w-full rounded-lg border border-gray-400 px-3"
                    v-model="address.state"
                >
                    <option value="AC">Acre</option>
                    <option value="AL">Alagoas</option>
                    <option value="AP">Amapá</option>
                    <option value="AM">Amazonas</option>
                    <option value="BA">Bahia</option>
                    <option value="CE">Ceará</option>
                    <option value="DF">Distrito Federal</option>
                    <option value="ES">Espírito Santo</option>
                    <option value="GO">Goiás</option>
                    <option value="MA">Maranhão</option>
                    <option value="MT">Mato Grosso</option>
                    <option value="MS">Mato Grosso do Sul</option>
                    <option value="MG">Minas Gerais</option>
                    <option value="PA">Pará</option>
                    <option value="PB">Paraíba</option>
                    <option value="PR">Paraná</option>
                    <option value="PE">Pernambuco</option>
                    <option value="PI">Piauí</option>
                    <option value="RJ">Rio de Janeiro</option>
                    <option value="RN">Rio Grande do Norte</option>
                    <option value="RS">Rio Grande do Sul</option>
                    <option value="RO">Rondônia</option>
                    <option value="RR">Roraima</option>
                    <option value="SC">Santa Catarina</option>
                    <option value="SP">São Paulo</option>
                    <option value="SE">Sergipe</option>
                    <option value="TO">Tocantins</option>
                </select>
                </div>
            </div>
            <TextInput
                placeholder="Complemento"
                label="Complemento"
                v-model="address.complement"
            />
            <TextInput
                placeholder="CEP"
                label="CEP"
                v-model="address.postcode"
            />
            <p class="text-2xl font-extrabold leading-none tracking-tight my-5">Retirada do pedido</p>
            <div class="cursor-pointer h-14 w-full rounded-2xl border border-gray-400 py-4 px-6">
                <input
                    type="radio"
                    name="pickup"
                    @click="deliveryType = 'pickup'"
                />
                <label for="pickup" class="cursor-pointer ml-2">Retirada</label>
            </div>
            <div class="mt-3 cursor-pointer h-14 w-full rounded-2xl border border-gray-400 py-4 px-6">
                <input
                    type="radio"
                    class="cursor-pointer"
                    name="delivery"
                    @click="deliveryType = 'delivery'"
                />
                <label for="delivery" class="cursor-pointer ml-2">Entrega</label>
            </div>
            <p class="text-2xl font-extrabold leading-none tracking-tight my-5">Observações</p>
            <TextArea
                placeholder="Observações"
                v-model="observation"
                class="w-full"
            />
            <PrimaryButton class="mt-6" @click="submit">Finalizar Pedido</PrimaryButton>
        </div>
    </AppLayout>
</template>
