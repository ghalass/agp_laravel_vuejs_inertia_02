<template>

    <!-- Button trigger modal -->
    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
        Edit
    </button> -->

    <!-- Modal -->
    <div class="modal fade" id="editSiteModal" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="editSiteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editSiteModalLabel">Editer un nouveau type parc {{
                        editSite.name }}
                    </h1>
                    <button @click="closeModal" type="button" class="btn-close" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="soumettre" id="editForm">
                        <TextInput name="Nom du site" v-model="editSite.name" :message="editSite.nameError" />
                    </form>
                </div>
                <div class="modal-footer">
                    <button @click="closeModal" type="button" class="btn btn-sm btn-outline-danger">Fermer</button>
                    <button form="editForm" type="submit" class="btn btn-sm btn-outline-success">Soumettre</button>
                </div>
            </div>
        </div>
    </div>

</template>

<script setup>
import { reactive, watch } from 'vue';
import axios from 'axios';
import { route } from 'ziggy-js';
import { Inertia } from '@inertiajs/inertia';
import { showAlert } from '../../utils/alert';
import TextInput from '../../Components/TextInput.vue';

const props = defineProps({
    siteId: {
        type: Number,
        required: true
    },
    show: {
        type: Boolean,
        default: false
    }
})

const editSite = reactive({
    id: "", name: "", nameError: ''
});

const openModal = () => {
    getSiteById()
    const editModal = new bootstrap.Modal(document.getElementById('editSiteModal'));
    editModal.show()
}

const emit = defineEmits(['modalClosed'])
const closeModal = () => {
    const editModal = bootstrap.Modal.getInstance(document.getElementById('editSiteModal'));
    editModal.hide()
    emit('modalClosed')
    editSite.nameError = ""
}

const getSiteById = () => {
    // ici on utilise axios car il a des données à retourner
    const url = route('sites.edit', { site: props.siteId });
    axios.get(url)
        .then((response) => {
            editSite.id = response.data.site.id
            editSite.name = response.data.site.name
        })
        .catch((error) => {
            console.log();
        })
}

watch(() => props.show, (newVal, oldVal) => {
    if (newVal) openModal()
    else closeModal()
})

const soumettre = () => {
    const url = route('sites.update', { site: props.siteId });
    // ici on utilise Initia car il n'a pas des données à retourner
    Inertia.put(url, { name: editSite.name }, {
        onSuccess: (page) => {
            closeModal()
            showAlert('success', 'Modifié avec succès!')
        },
        onError: (error) => {
            if (error.name != null) {
                editSite.nameError = error.name
            }
            showAlert('error', "Une erreur s'est produite!")
        }
    });
}

</script>
