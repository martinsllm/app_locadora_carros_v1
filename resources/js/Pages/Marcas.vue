<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Card from '@/Layouts/Card.vue';
import Header from '@/Layouts/Header.vue';
import Table from '@/Layouts/Table.vue';
import Alert from '@/Layouts/Alert.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import Modal from '@/Layouts/Modal.vue';

const showModal = ref(false)

function toggleModal() {
    showModal.value = !showModal.value
    form.transacaoStatus = ''
}

function getToken() {
    let token = document.cookie.split(";").find(indice => {
        return indice.includes("token=")
    })

    token = token.split('=')[1]
    token = 'Bearer ' + token

    return token
}

const form = useForm({
    nome: '',
    imagem: [],
    transacaoStatus: '',
    transacaoMessage: []
});

const submit = () => {
    let urlBase = 'http://localhost:8000/api/v1/marca'

    let formData = new FormData()
    formData.append('nome', form.nome)
    formData.append('imagem', form.imagem[0])

    let token = getToken()

    let config = {
        headers: {
            'Content-Type': 'multipart/form-data',
            'Accept': 'application/json',
            'Authorization': token
        }
    }
    
    axios.post(urlBase, formData, config)
        .then(response => {
            form.transacaoStatus = 'sucesso'
            form.transacaoMessage = response
        }).catch(errors => {
            form.transacaoStatus = 'erro'
            form.transacaoMessage = errors.response
        })
};

const carregarImagem = (e) => {
    form.imagem = e.target.files
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
                    <TextInput type="text" placeholder="ID"/>
                    <p class="text-xs italic">Opcional. Informe o ID do registro</p>
                </div>

                <div class="w-full md:w-1/2 px-3">
                    <InputLabel>Marca</InputLabel>
                    <TextInput type="text" placeholder="Nome da marca" />
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
                <Alert v-if="form.transacaoStatus === 'sucesso'" :message="form.transacaoMessage" class="mt-2" cor="green" titulo="Sucesso!"/>
                <Alert v-if="form.transacaoStatus === 'erro'" :message="form.transacaoMessage" class="mt-2" cor="red" titulo="Erro!"/>
                <InputLabel class="mt-2">Nome</InputLabel>
                <TextInput type="text" placeholder="Nome da marca" v-model="form.nome"/>
                
                <InputLabel class="mt-2">Imagem</InputLabel>
                <TextInput type="file" placeholder="Imagem" @change="carregarImagem($event)"/>
                <p class="text-xs italic">Selecione no formato PNG ou JPG</p>

                <div class="flex shrink-0 flex-wrap items-center pt-4 justify-end">
                    <button @click="toggleModal" class="rounded-md border border-transparent py-2 px-4 text-center text-sm transition-all text-slate-600 hover:bg-slate-100 focus:bg-slate-100 active:bg-slate-100 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" type="button">
                        Voltar
                    </button>
                    <button @click="submit" class="rounded-md bg-green-600 py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-green-700 focus:shadow-none active:bg-green-700 hover:bg-green-700 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none ml-2" type="button">
                        Confirmar
                    </button>
                </div>    
            </form>
        </Modal>

    </AuthenticatedLayout>
</template>

