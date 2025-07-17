<script setup>

defineProps({
    titulo: {
        type: String,
    },
});

</script>

<template>
    <div class="fixed inset-0 z-50 overflow-auto bg-black bg-opacity-50 flex justify-center items-center">
        <div class="relative bg-white p-4 w-full max-w-md max-h-full">
            <h2 class="text-xl font-semibold mb-5">{{ titulo }}</h2>
            <hr>
            <slot />
        </div>
    </div>
</template>