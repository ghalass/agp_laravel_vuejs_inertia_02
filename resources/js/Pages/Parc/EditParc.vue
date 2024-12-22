<template>

    <Head title="Parcs Création" />

    <div class="content-header">
        <h1>Création d'un nouveau Parc</h1>
    </div>

    <div class="card">
        <div class="card-header">

            <Link :href="route('parcs.index')">
            <button type="button" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-arrow-left"></i> Back
            </button>
            </Link>

        </div>
        <div class="card-body">
            <form @submit.prevent="soumettre" id="editForm">
                <div class="row my-2">
                    <TextInput name="Nom du parc" v-model="form.name" :message="form.errors.name" />

                    <div class="form-group col">
                        <label>Type de parc</label>
                        <select v-model="form.typeparc_id" class="form-select form-select-sm"
                            :class="{ 'is-invalid': form.errors.typeparc_id }">
                            <option value=""></option>
                            <option v-for="typeparc in props.typeparcs" :key="typeparc.id" :value="typeparc.id">
                                {{ typeparc.name }}
                            </option>
                        </select>
                        <span v-if="form.errors.typeparc_id" class="invalid-feedback error fst-italic">
                            {{ form.errors.typeparc_id }}
                        </span>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <div class="d-flex gap-1">
                <button type="button" class="btn btn-sm btn-outline-danger">Fermer</button>
                <button form="editForm" type="submit" class="btn btn-sm btn-outline-success">Soumettre</button>
            </div>
        </div>
    </div>

</template>

<script setup>
import { Head, useForm } from '@inertiajs/inertia-vue3';
import { route } from 'ziggy-js';
import { showAlert } from '../../Composables/alert';
import TextInput from '../../Components/TextInput.vue';

const props = defineProps({
    typeparcs: Array,
    parc: Object
})

const form = useForm({
    name: props.parc.name,
    typeparc_id: props.parc.typeparc_id
})

const soumettre = () => {
    const url = route('parcs.update', { parc: props.parc });
    form.put(url, {
        onSuccess: (page) => {
            showAlert('success', 'Modifié avec succès!')
        },
        onError: (error) => {
            showAlert('error', "Une erreur s'est produite!")
        }
    });
}

</script>
