<template>

    <!-- Modal -->
    <div class="modal fade" id="editTypeparcModal" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="editTypeparcModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editTypeparcModalLabel">Editer un nouveau type parc {{
                        editTypeparc.name }}
                    </h1>
                    <button @click="closeModal" type="button" class="btn-close" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="soumettre" id="editForm">
                        <TextInput name="Nom du type de parc" v-model="editTypeparc.name"
                            :message="editTypeparc.nameError" />
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
import { showAlert } from '../../Composables/alert';
import TextInput from '../../Components/TextInput.vue';

const props = defineProps({
    typeparcId: {
        type: Number,
        required: true
    },
    show: {
        type: Boolean,
        default: false
    }
})

const editTypeparc = reactive({
    id: "", name: "", nameError: ''
});

const openModal = () => {
    getTypeparcById()
    const editModal = new bootstrap.Modal(document.getElementById('editTypeparcModal'));
    editModal.show()
}

const emit = defineEmits(['modalClosed'])
const closeModal = () => {
    const editModal = bootstrap.Modal.getInstance(document.getElementById('editTypeparcModal'));
    editModal.hide()
    emit('modalClosed')
    editTypeparc.nameError = ""
}

const getTypeparcById = () => {
    // ici on utilise axios car il a des données à retourner
    const url = route('typeparcs.edit', { typeparc: props.typeparcId });
    axios.get(url)
        .then((response) => {
            editTypeparc.id = response.data.typeparc.id
            editTypeparc.name = response.data.typeparc.name
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
    const url = route('typeparcs.update', { typeparc: props.typeparcId });
    // ici on utilise Initia car il n'a pas des données à retourner
    Inertia.put(url, { name: editTypeparc.name }, {
        onSuccess: (page) => {
            closeModal()
            showAlert('success', 'Modifié avec succès!')
        },
        onError: (error) => {
            if (error.name != null) {
                editTypeparc.nameError = error.name
            }
            showAlert('error', "Une erreur s'est produite!")
        }
    });
}

</script>
