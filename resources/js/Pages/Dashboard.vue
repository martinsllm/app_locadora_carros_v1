<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Card from '@/Layouts/Card.vue';
import Header from '@/Layouts/Header.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Home" />

    <AuthenticatedLayout>
        <Header>Seja Bem-Vindo!</Header>

        <Card>
            Apresentar indicadores do sistema!
        </Card>
    </AuthenticatedLayout>
</template>
