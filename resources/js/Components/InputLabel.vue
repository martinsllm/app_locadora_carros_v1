<script setup>
defineProps({
    value: {
        type: String,
    },
});
</script>

<template>
    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>
