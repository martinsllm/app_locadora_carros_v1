<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Card from '@/Layouts/Card.vue';
import Header from '@/Layouts/Header.vue';
import Table from '@/Layouts/Table.vue';
import Alert from '@/Layouts/Alert.vue';
import Pagination from '@/Layouts/Pagination.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { onMounted, reactive, ref } from 'vue';
import Modal from '@/Layouts/Modal.vue';

const showModal = ref(false)
const urlBase = 'http://localhost:8000/api/v1/marca'
const transacaoStatus = ref('')
const transacaoMessage = reactive({
    message: '',
    data: ''
})
const marcas = ref([])

function toggleModal() {
    showModal.value = !showModal.value
    transacaoStatus.value = ''
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
});

const submit = () => {
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
            transacaoStatus.value = 'sucesso'
            transacaoMessage.message = 'ID do registro: ' + response.data.id
            transacaoMessage.data = ''
            
        }).catch(errors => {
            transacaoStatus.value = 'erro'
            transacaoMessage.data = errors.response.data.errors
            transacaoMessage.message = ''
        })
};

const carregarImagem = (e) => {
    form.imagem = e.target.files
}

const buscarLista = () => {
    let token = getToken()

    let config = {
        headers: {
            'Accept': 'application/json',
            'Authorization': token
        }
    }

    axios.get(urlBase, config)
        .then(response => {
            marcas.value = response.data
            console.log(marcas.links)
        }).catch(errors => {
            console.log(errors)
        })
}

onMounted(() => {
    buscarLista()
})

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
            <Table :data="marcas.data" :titulos="{
                id: {
                    titulo: 'id',
                    tipo: 'text'
                },
                nome: {
                    titulo: 'nome',
                    tipo: 'text'
                },
                imagem: {
                    titulo: 'imagem',
                    tipo: 'imagem'
                }
            }">

            </Table>

            <div class="flex flex-wrap -mx-3 mb-6 mt-5">
                <div class="w-full md:w-1/2 px-3">
                    <Pagination>
                        <li v-for="l,key in marcas.links" :key="key">
                            <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-gray-200 border border-gray-300 hover:bg-gray-100 hover:text-gray-700" v-html="l.label"></a>
                        </li>
                    </Pagination>
                </div> 

                <div class="w-full md:w-1/2 px-3" align="right">
                    <PrimaryButton @click="toggleModal">Adicionar</PrimaryButton>
                </div> 
            </div>  
        </Card>

        <Modal v-if="showModal" titulo="Nova Marca">
            <form>
                <Alert v-if="transacaoStatus === 'sucesso'" :message="transacaoMessage" class="mt-2" cor="green" titulo="Sucesso!"/>
                <Alert v-if="transacaoStatus === 'erro'" :message="transacaoMessage" class="mt-2" cor="red" titulo="Erro!"/>
                
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

