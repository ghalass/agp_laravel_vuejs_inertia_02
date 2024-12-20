<template>
    <button @click="openModal" type="button" class="btn btn-sm btn-outline-primary">
        <i class="bi bi-plus-lg"></i> Nouveau
    </button>

    <div class="modal modal-lg fade" id="createEnginModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="createEnginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createEnginModalLabel">Ajouter un nouveau engin</h1>
                    <button type="button" class="btn-close" @click="closeModal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="soumettre" id="createForm">
                        <div class="row">
                            <div class="col">
                                <label for="name">Nom de l'engin</label>
                                <input v-model="form.name" :class="{ 'is-invalid': form.errors.name }"
                                    class="form-control form-control-sm" type="text" id="name" />
                                <span v-if="form.errors.name" class="invalid-feedback error fst-italic">
                                    {{ form.errors.name }}
                                </span>
                            </div>

                            <div class="col">
                                <label for="name">Site</label>
                                <select v-model="form.site_id" class="form-select form-select-sm"
                                    :class="{ 'is-invalid': form.errors.site_id }">
                                    <option value=""></option>
                                    <option v-for="site in sites" :value="site.id" :key="site.id">
                                        {{ site.name }}
                                    </option>
                                </select>
                                <span v-if="form.errors.site_id" class="invalid-feedback error fst-italic">
                                    {{ form.errors.site_id }}
                                </span>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col">
                                <label for="name">Type de parc</label>
                                <select @change="updateParcs" v-model="selectedTypeparc"
                                    class="form-select form-select-sm">
                                    <option value=""></option>
                                    <option v-for="typeparc in typeparcs" :value="typeparc.id" :key="typeparc.id">
                                        {{ typeparc.name }}
                                    </option>
                                </select>
                            </div>

                            <div class="col">
                                <label for="name">Parc</label>
                                <select v-model="form.parc_id" class="form-select form-select-sm"
                                    :class="{ 'is-invalid': form.errors.parc_id }">
                                    <option value=""></option>
                                    <option v-for="parc in parcs" :value="parc.id" :key="parc.id">
                                        {{ parc.name }}
                                    </option>
                                </select>
                                <span v-if="form.errors.parc_id" class="invalid-feedback error fst-italic">
                                    {{ form.errors.parc_id }}
                                </span>
                            </div>
                        </div>
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
import { ref } from 'vue';
import { showAlert } from '../../Composables/alert';
import { route } from 'ziggy-js';
import { useForm } from '@inertiajs/inertia-vue3';
import axios from 'axios';

const selectedTypeparc = ref('');

const parcs = ref([]);

const props = defineProps({
    typeparcs: Object,
    sites: Object,
})


const updateParcs = () => {
    const url = route('parcs.get_by_typeparc_id', { id: selectedTypeparc.value });
    axios.get(url)
        .then((response) => {
            parcs.value = response.data.parcs
        })
        .catch((error) => {
            console.log(error);
        })
};

const form = useForm({
    name: "",
    parc_id: "",
    site_id: ""
})

// Ouvrir le modal avec jQuery (Bootstrap)
const openModal = () => {
    const createModal = new bootstrap.Modal(document.getElementById('createEnginModal'));
    createModal.show();
}

// Fermer le modal avec Vue
const closeModal = () => {
    const createModal = bootstrap.Modal.getInstance(document.getElementById('createEnginModal'));
    createModal.hide()
    form.reset().clearErrors()
    selectedTypeparc.value = ''
}

const soumettre = () => {
    const url = route('engins.store');
    form.post(url, {
        onSuccess: (page) => {
            closeModal()
            showAlert('success', 'Ajouté avec succès!')
            form.reset().clearErrors()
            selectedTypeparc.value = ''
        },
        onError: (error) => {
            showAlert('error', "Une erreur s'est produite!")
        }
    });
}

</script>
