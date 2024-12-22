<template>
    <button @click="openModal" type="button" class="btn btn-sm btn-outline-primary"
        data-bs-target="#createTypeparcModal">
        <i class="bi bi-plus-lg"></i> Nouveau
    </button>

    <div class="modal modal-lg fade" id="createTypeparcModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="createTypeparcModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createTypeparcModalLabel">Ajouter un nouveau type parc</h1>
                    <button type="button" class="btn-close" @click="closeModal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="soumettre" id="createForm">
                        <TextInput name="Nom du type de parc" v-model="typeparcName" :message="nameError" />
                    </form>
                </div>
                <div class="modal-footer">
                    <button @click="closeModal" type="button" class="btn btn-sm btn-outline-danger">Fermer</button>
                    <button form="createForm" type="submit" class="btn btn-sm btn-outline-success">Soumettre</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Inertia } from '@inertiajs/inertia';
import { ref } from 'vue';
import { showAlert } from '../../utils/alert';
import { route } from 'ziggy-js';
import TextInput from '../../Components/TextInput.vue';


let typeparcName = ref("");
let nameError = ref("");

// Ouvrir le modal avec jQuery (Bootstrap)
const openModal = () => {
    const createModal = new bootstrap.Modal(document.getElementById('createTypeparcModal'));
    createModal.show();
}

// Fermer le modal avec Vue
const closeModal = () => {
    const createModal = bootstrap.Modal.getInstance(document.getElementById('createTypeparcModal'));
    createModal.hide();
    typeparcName.value = ""
    nameError.value = ""
}

const soumettre = () => {
    const name = typeparcName.value;
    const url = route('typeparcs.store');
    Inertia.post(url, { name: name }, {
        onSuccess: (page) => {
            closeModal()
            showAlert('success', 'Ajouté avec succès!')
        },
        onError: (error) => {
            if (error.name != null) {
                nameError.value = error.name
            }
            showAlert('error', "Une erreur s'est produite!")
        }
    });
}

</script>
