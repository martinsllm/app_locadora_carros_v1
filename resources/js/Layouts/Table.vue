<script setup>

defineProps({
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
                <tr v-for="m in data" :key="m.id" class="bg-white border-b dark:bg-gray-50 dark:border-gray-700 border-gray-200 text-gray-500">
                    <th scope="row" class="px-6 py-4 whitespace-nowrap">
                        {{ m.id }}
                    </th>
                    <td class="px-6 py-4">
                        {{ m.nome }}
                    </td>
                    <td class="px-6 py-4">
                        <img :src="'/storage/'+m.imagem" width="65" height="65"/>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>