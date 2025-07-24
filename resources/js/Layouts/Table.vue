<script setup>
import { useStore } from 'vuex';

const store = useStore();

const props = defineProps({
    data: {
        type: Array,
    },
    titulos: {
        type: Object,
    }
});

function setModal(id) {
    store.state.openModal = true
    store.state.modalId = id
}

function setObj(obj, modalId) {
    store.state.item = obj
    setModal(modalId)
}

</script>

<template>
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-200 dark:text-gray-400">
                <tr>
                    <th scope="col" v-for="t,key in titulos" :key="key" class="px-6 py-3">
                        {{ t.titulo }}
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="obj in data" :key="obj.id" class="bg-white border-b dark:bg-gray-50 dark:border-gray-700 border-gray-200 text-gray-500 dark:hover:bg-gray-100">
                   <td v-for="valor,key in titulos" :key="key" class="px-6 py-4">
                        <span v-if="valor.tipo === 'imagem'">
                            <img :src="'/storage/'+obj[key]" width="55" height="55"/>
                        </span>
                        <span v-else>
                            {{ obj[key] }}
                        </span>
                    </td>
                    <td>
                        <button @click="setObj(obj, 'view')" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Visualizar</button>
                        <button class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800">Atualizar</button>
                        <button @click="setObj(obj, 'delete')" type="button" class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">Remover</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</template>