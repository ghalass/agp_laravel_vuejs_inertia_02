<template>

    <!-- Modal -->
    <div class="modal fade" id="editEnginModal" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="editEnginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editEnginModalLabel">Editer un nouveau engin {{
                        form.name }}
                    </h1>
                    <button @click="closeModal" type="button" class="btn-close" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="soumettre" id="editForm">
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
                                <select v-model="selectedTypeparc" @change="updateParcs"
                                    class="form-select form-select-sm">
                                    <option value=""></option>
                                    <option v-for="typeparc in typeparcs" :value="typeparc.id" :key="typeparc.id">
                                        {{ typeparc.name }}
                                    </option>
                                </select>
                            </div>

                            <div class="col">
                                <label for="name">Parc</label>
                                <select v-model="selectedParc" class="form-select form-select-sm"
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
                    <button form="editForm" type="submit" class="btn btn-sm btn-outline-success">Soumettre</button>
                </div>
            </div>
        </div>
    </div>

</template>

<script setup>
import { ref, watch } from 'vue';
import axios from 'axios';
import { route } from 'ziggy-js';
import { showAlert } from '@/Composables/alert';
import { useForm } from '@inertiajs/inertia-vue3';

let selectedTypeparc = ref('');
let selectedParc = ref('');

let currentEngin = {
    id: "",
    name: "",
    parc_id: "",
    typeparc_id: "",
    site_id: "",
};

let parcs = ref([]);

const props = defineProps({
    enginId: {
        type: Number,
        required: true
    },
    show: {
        type: Boolean,
        default: false
    },
    typeparcs: Object,
    sites: Object,
})

const updateParcs = () => {
    if (selectedTypeparc.value == '') selectedTypeparc.value = '0'

    const url = route('parcs.get_by_typeparc_id', { id: selectedTypeparc.value });

    axios.get(url)
        .then((response) => {
            parcs.value = response.data.parcs
            if (selectedTypeparc.value == '') {
                form.parc_id = ''
            } else {
                if (selectedTypeparc.value == currentEngin.typeparc_id) {
                    selectedParc.value = currentEngin.parc_id
                } else {
                    selectedParc.value = ''
                }
            }
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

const openModal = () => {
    getEnginById()
    const editModal = new bootstrap.Modal(document.getElementById('editEnginModal'));
    editModal.show()
}

const emit = defineEmits(['modalClosed'])
const closeModal = () => {
    const editModal = bootstrap.Modal.getInstance(document.getElementById('editEnginModal'));
    editModal.hide()
    emit('modalClosed')
    form.reset().clearErrors()
    selectedTypeparc.value = ''
}

const getEnginById = () => {
    const url = route('engins.edit', { engin: props.enginId });
    axios.get(url)
        .then((response) => {
            currentEngin = {
                ...response.data.engin,
                typeparc_id: response.data.engin.parc.typeparc.id
            };

            form.name = response.data.engin.name
            form.parc_id = response.data.engin.parc_id
            form.site_id = response.data.engin.site_id

            selectedTypeparc.value = response.data.engin.parc.typeparc.id;
            selectedParc.value = response.data.engin.parc.id;

            updateParcs()
        })
        .catch((error) => {
            console.log(error);
        })
}

watch(() => props.show, (newVal, oldVal) => {
    if (newVal) openModal()
    else closeModal()
})

const soumettre = () => {
    form.parc_id = selectedParc.value
    const url = route('engins.update', { engin: props.enginId });
    form.put(url, {
        onSuccess: (page) => {
            closeModal()
            showAlert('success', 'Modifié avec succès!')
            form.reset().clearErrors()
            selectedTypeparc.value = ''
        },
        onError: (error) => {
            showAlert('error', "Une erreur s'est produite!")
        }
    });
}

</script>
