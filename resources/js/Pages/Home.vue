<template>

    <Head title="Home" />

    <!-- Content specific to this page -->
    <div class="content-header">
        <h1>Bonjour, {{ user.name }}</h1>
    </div>
    <div class="content-body">
        <p>Bienvenue sur cette application.</p>
    </div>

</template>

<script setup>
import { usePage } from '@inertiajs/inertia-vue3';
import { computed, } from 'vue';

const user = computed(() => {
    return usePage().props.value.auth.user
})





</script>
