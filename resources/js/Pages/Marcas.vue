<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Container from '@/Layouts/Container.vue';
import Header from '@/Layouts/Header.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Marcas" />
    <AuthenticatedLayout>
        <Header>Marcas</Header>
        
        <Container>
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
        </Container> 

    </AuthenticatedLayout>
</template>