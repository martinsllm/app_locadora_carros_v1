<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Container from '@/Layouts/Container.vue';
import Header from '@/Layouts/Header.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Home" />

    <AuthenticatedLayout>
        <Header>Seja Bem-Vindo!</Header>

        <Container>
            Apresentar indicadores do sistema!
        </Container>
    </AuthenticatedLayout>
</template>
