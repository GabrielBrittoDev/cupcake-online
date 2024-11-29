<script setup>
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextArea from "@/Components/TextArea.vue";
import FileInput from "@/Components/FileInput.vue";

const props = defineProps({
    product: {
        type: Object,
        default: {
            image: '',
            name: '',
            description: '',
            ingredients: '',
            price: '',
        },
    }
});

const emits = defineEmits(['submit']);

const submit = () => {
    emits('submit', props.product);
}

</script>

<template>
    <div>
        <p class="text-2xl my-5 font-extrabold leading-none tracking-tight">Informações do Produto</p>
        <FileInput
            label="Foto do Produto"
            v-model="product.image"
        />
        <TextInput
            placeholder="Nome"
            label="Nome"
            v-model="product.name"
        />
        <TextArea
            placeholder="Descrição"
            label="Descrição"
            v-model="product.description"
        />
        <TextArea
            placeholder="Ingredientes"
            label="Ingredientes"
            v-model="product.ingredients"
        />
        <TextInput
            placeholder="Preço"
            label="Preço"
            v-model="product.price"
        />
        <PrimaryButton class="mt-5" @click="submit">Salvar</PrimaryButton>
    </div>
</template>
