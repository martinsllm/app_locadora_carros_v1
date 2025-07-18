<script setup>

const props = defineProps({
    cor: {
        type: String,
    },
    titulo: {
        type: String,
    },
    message: {
        type: String,
    },
});

let classeModificada = `bg-${props.cor}-100 border border-${props.cor}-400 text-${props.cor}-700 px-4 py-3 rounded relative`

</script>

<template>
    <div v-bind:class="classeModificada" role="alert">
        <strong class="font-bold">{{ titulo }}</strong>
        <span class="block sm:inline">
            <ul v-if="message.data.id">
                <li>{{ 'ID do registro: ' + message.data.id }}</li>
            </ul>
            <ul v-if="message.data.errors">
                <li v-for="e, key in message.data.errors" :key="key">{{ e[0] }}</li>
            </ul>
        </span>
    </div>
</template>