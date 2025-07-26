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
import { useStore } from 'vuex';
import axios from 'axios';

const showModal = ref(false)
const store = useStore();

const urlBase = ref('http://localhost:8000/api/v1/marca')
const urlPaginacao = ref('')
const urlFiltro = ref('')

const transacaoStatus = ref('')
const transacaoMessage = reactive({
    message: '',
    data: ''
})
const marcas = ref([])

const busca = reactive({
    id: '',
    nome: ''
})

function openModal(id) {
    showModal.value = true
    transacaoStatus.value = ''
}

function closeModal(id) {
    showModal.value = false
    store.state.openModal = false
    transacaoStatus.value = ''
}

const form = useForm({
    nome: '',
    imagem: [],
});

const submit = () => {
    urlBase.value = 'http://localhost:8000/api/v1/marca'
    let formData = new FormData()
    formData.append('nome', form.nome)
    formData.append('imagem', form.imagem[0])

    let config = {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    }
    
    axios.post(urlBase.value, formData, config)
        .then(response => {
            transacaoStatus.value = 'sucesso'
            transacaoMessage.message = 'ID do registro: ' + response.data.id
            transacaoMessage.data = ''
            reload(3000)
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
    let url = urlBase.value + '?' + urlPaginacao.value + urlFiltro.value

    axios.get(url)
        .then(response => {
            marcas.value = response.data
        }).catch(errors => {
            console.log(errors)
        })
}

const paginacao = (l) => {
    if(l.url){
        urlPaginacao.value = l.url.split('?')[1]
        buscarLista()
    }
}

const pesquisar = () => {
    let filtro = ''

    for(let chave in busca){
        if(busca[chave]) {
            if(filtro != ''){
                filtro += ';'
            }

            filtro += chave + ':like:' + '%' + busca[chave] + '%'
        }
    }

    if(filtro != ''){
        urlPaginacao.value = 'page=1'
        urlFiltro.value = '&filtro='+filtro
    } else {
        urlFiltro.value = ''
    }

    buscarLista()
}

function remover() {
    let url = urlBase.value + '/' + store.state.item.id

    let formData = new FormData()
    formData.append('_method', 'delete')

    axios.post(url, formData)
        .then(response => {
            transacaoStatus.value = 'sucesso'
            transacaoMessage.message = response.data.msg
            buscarLista()

            reload(3000)
        }).catch(errors => {
            transacaoStatus.value = 'erro'
            transacaoMessage.message = errors.response.data.erro
        })
}

function atualizar() {
    let url = urlBase.value + '/' + store.state.item.id

    let formData = new FormData()
    formData.append('_method', 'patch')
    formData.append('nome', store.state.item.nome)

    if(form.imagem[0]) {
        formData.append('imagem', form.imagem[0])
    }

    let config = {
        headers: {
            'Content-Type': 'multipart/form-data',
        }
    }

    axios.post(url, formData, config)
        .then(response => {
            transacaoStatus.value = 'sucesso'
            transacaoMessage.message = 'Registro ' + response.data.id + ' atualizado com sucesso!'
            transacaoMessage.data = ''
            reload(3000)
        }).catch(errors => {
            transacaoStatus.value = 'erro'
            transacaoMessage.data = errors.response.data.errors
            console.log(errors.response.data.errors)
        })
}

function reload(time) {
    setTimeout(function() {
        location.reload();
    }, time);  
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
                    <TextInput type="text" placeholder="ID" v-model="busca.id"/>
                    <p class="text-xs italic">Opcional. Informe o ID do registro</p>
                </div>

                <div class="w-full md:w-1/2 px-3">
                    <InputLabel>Marca</InputLabel>
                    <TextInput type="text" placeholder="Nome da marca" v-model="busca.nome" />
                    <p class="text-xs italic">Opcional. Informe o nome da marca</p>
                </div>

                <div class="w-full px-3 mb-6 md:mb-0 mt-5" align="right">
                    <PrimaryButton @click="pesquisar">Pesquisar</PrimaryButton>
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
                },
                created_at: {
                    titulo: 'data de criação',
                    tipo: 'data'
                }
            }">
            
            </Table>

            <div class="flex flex-wrap -mx-3 mb-6 mt-5">
                <div class="w-full md:w-1/2 px-3">
                    <Pagination>
                        <li v-for="l,key in marcas.links" :key="key" @click="paginacao(l)">
                            <a class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-gray-200 border border-gray-300 hover:bg-gray-100 hover:text-gray-70 cursor-pointer" tabindex="0">
                                <span v-if="l.active" class="font-bold text-gray-800" v-html="l.label"></span>
                                <span v-else v-html="l.label"></span>
                            </a>
                        </li>
                    </Pagination>
                </div> 
                
                <div class="w-full md:w-1/2 px-3" align="right">
                    <PrimaryButton @click="openModal()">Adicionar</PrimaryButton>
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
                    <button @click="closeModal()" class="rounded-md border border-transparent py-2 px-4 text-center text-sm transition-all text-slate-600 hover:bg-slate-100 focus:bg-slate-100 active:bg-slate-100 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" type="button">
                        Voltar
                    </button>
                    <button @click="submit" class="rounded-md bg-green-600 py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-green-700 focus:shadow-none active:bg-green-700 hover:bg-green-700 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none ml-2" type="button">
                        Confirmar
                    </button>
                </div>    
            </form>
        </Modal>

        <Modal v-if="store.state.openModal && store.state.modalId === 'view'" titulo="Visualizar">
            <InputLabel>ID</InputLabel>
            <TextInput type="text" v-model="store.state.item.id" disabled/>

            <InputLabel class="mt-2">Nome</InputLabel>
            <TextInput type="text" v-model="store.state.item.nome" disabled/>

            <div class="flex shrink-0 flex-wrap items-center pt-4 justify-end">
                <button @click="closeModal()" class="rounded-md border border-transparent py-2 px-4 text-center text-sm transition-all text-slate-600 hover:bg-slate-100 focus:bg-slate-100 active:bg-slate-100 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" type="button">
                    Fechar
                </button>
            </div>  
        </Modal>

        <Modal v-if="store.state.openModal && store.state.modalId === 'delete'" titulo="Remover Marca">
            <Alert v-if="transacaoStatus === 'sucesso'" :message="transacaoMessage" class="mt-2" cor="green" titulo="Sucesso!"/>
            <Alert v-if="transacaoStatus === 'erro'" :message="transacaoMessage" class="mt-2" cor="red" titulo="Erro!"/>
            
            <div class="mt-2">
                Deseja remover a marca {{ store.state.item.nome }}?
            </div>

            <div class="flex shrink-0 flex-wrap items-center pt-4 justify-end">
                <button @click="closeModal()" class="rounded-md border border-transparent py-2 px-4 text-center text-sm transition-all text-slate-600 hover:bg-slate-100 focus:bg-slate-100 active:bg-slate-100 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" type="button">
                    Cancelar
                </button>
                <button @click="remover()" class="rounded-md bg-red-600 py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-red-700 focus:shadow-none active:bg-red-700 hover:bg-red-700 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none ml-2" type="button">
                    Remover
                </button>
            </div>  
        </Modal>

        <Modal v-if="store.state.openModal && store.state.modalId === 'update'" titulo="Alterar Marca">
            <form>
                <Alert v-if="transacaoStatus === 'sucesso'" :message="transacaoMessage" class="mt-2" cor="green" titulo="Sucesso!"/>
                <Alert v-if="transacaoStatus === 'erro'" :message="transacaoMessage" class="mt-2" cor="red" titulo="Erro!"/>
                
                <InputLabel class="mt-2">Nome</InputLabel>
                <TextInput type="text" placeholder="Nome da marca" v-model="store.state.item.nome"/>
                
                <InputLabel class="mt-2">Imagem</InputLabel>
                <TextInput type="file" id="atualizarImagem" placeholder="Imagem" @change="carregarImagem($event)"/>
                <p class="text-xs italic">Selecione no formato PNG ou JPG</p>

                <div class="flex shrink-0 flex-wrap items-center pt-4 justify-end">
                    <button @click="closeModal()" class="rounded-md border border-transparent py-2 px-4 text-center text-sm transition-all text-slate-600 hover:bg-slate-100 focus:bg-slate-100 active:bg-slate-100 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" type="button">
                        Voltar
                    </button>
                    <button @click="atualizar" class="rounded-md bg-green-600 py-2 px-4 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-green-700 focus:shadow-none active:bg-green-700 hover:bg-green-700 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none ml-2" type="button">
                        Atualizar
                    </button>
                </div>    
            </form>
        </Modal>

    </AuthenticatedLayout>
</template>

