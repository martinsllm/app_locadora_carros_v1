<script setup>
import Container from '@/Layouts/Container.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Home" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Seja Bem-Vindo!
            </h2>
        </template>

        <Container>
            Apresentar indicadores do sistema!
       </Container>
    </AuthenticatedLayout>
</template>
