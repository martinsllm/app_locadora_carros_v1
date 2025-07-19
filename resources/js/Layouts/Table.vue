<script setup>

const props = defineProps({
    data: {
        type: Array,
    },
    titulos: {
        type: Array,
    },
});

</script>

<template>
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-200 dark:text-gray-400">
                <tr>
                    <th scope="col" v-for="t,key in titulos" :key="key" class="px-6 py-3">
                        {{ t }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="obj in data" :key="obj.id" class="bg-white border-b dark:bg-gray-50 dark:border-gray-700 border-gray-200 text-gray-500">
                   <td v-for="valor,key in titulos" :key="key" class="px-6 py-4">
                        <span v-if="valor == 'imagem'">
                            <img :src="'/storage/'+obj[valor]" width="65" height="65"/>
                        </span>
                        <span v-else>
                            {{ obj[valor] }}
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>