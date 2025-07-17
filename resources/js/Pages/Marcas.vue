<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Card from '@/Layouts/Card.vue';
import Header from '@/Layouts/Header.vue';
import Table from '@/Layouts/Table.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import Modal from '@/Layouts/Modal.vue';

const showModal = ref(false)

function toggleModal() {
    showModal.value = !showModal.value
}
</script>


<template>
    <Head title="Marcas" />
    <AuthenticatedLayout>
        <Header>Marcas</Header>
        
        <!-- Card de buscas -->
        <Card>
            <div class="flex flex-wrap -mx-3 mb-6">

                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <InputLabel>ID</InputLabel>
                    <TextInput class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="ID" />
                    <p class="text-xs italic">Opcional. Informe o ID do registro</p>
                </div>

                <div class="w-full md:w-1/2 px-3">
                    <InputLabel>Marca</InputLabel>
                    <TextInput class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Nome da marca" />
                    <p class="text-xs italic">Opcional. Informe o nome da marca</p>
                </div>

                <div class="w-full px-3 mb-6 md:mb-0 mt-5" align="right">
                    <PrimaryButton>Pesquisar</PrimaryButton>
                </div>     
            </div>
        </Card> 

        <!-- Card de listagem de marcas -->
        <Card>
            <Table></Table>

            <div class="w-full px-3 mb-6 md:mb-0 mt-5" align="right">
                <PrimaryButton @click="toggleModal">Adicionar</PrimaryButton>
            </div>   
        </Card>

        <Modal v-if="showModal" titulo="Nova Marca">
            <form>
                <InputLabel class="mt-2">Nome</InputLabel>
                <TextInput type="text" placeholder="Nome da marca" />
                
                <InputLabel class="mt-2">Imagem</InputLabel>
                <TextInput type="file" placeholder="Imagem" />
                <p class="text-xs italic">Selecione no formato PNG ou JPG</p>

                <div class="flex shrink-0 flex-wrap items-center pt-4 justify-end">
                    <button @click="toggleModal" class="rounded-md border border-transparent py-2 px-4 text-center text-sm transition-all text-slate-600 hover:bg-slate-100 focus:bg-slate-100 active:bg-slate-100 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" type="button">
                        Cancelar
                    </button>
                    <button class="rounded-md bg-green-600 py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-green-700 focus:shadow-none active:bg-green-700 hover:bg-green-700 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none ml-2" type="button">
                        Confirmar
                    </button>
                </div>    
            </form>
        </Modal>

    </AuthenticatedLayout>
</template>

