<script setup>

const props = defineProps({
    data: {
        type: Array,
    },
    titulos: {
        type: Object,
    },
});

</script>

<template>
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-200 dark:text-gray-400">
                <tr>
                    <th scope="col" v-for="t,key in titulos" :key="key" class="px-6 py-3">
                        {{ t.titulo }}
                    </th>
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
                </tr>
            </tbody>
        </table>
        
    </div>
</template>