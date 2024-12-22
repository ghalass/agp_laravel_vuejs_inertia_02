<template>

    <Head title="Engins" />

    <!-- Content specific to this page -->
    <div class="content-header">
        <h1>Liste des Engin</h1>
    </div>

    <div class="card">
        <div class="card-body ">
            <div class="d-flex justify-content-between align-items-center">

                <CreateEngin :sites="props.sites" :typeparcs="props.typeparcs" />

                <Pagination :links="props.engins.links" :prev="props.engins.prev_page_url"
                    :next="props.engins.next_page_url" />

            </div>

            <!-- Table with hoverable rows -->
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Engin</th>
                        <th>Parc</th>
                        <th>Type Parc</th>
                        <th>Site</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="engin in props.engins.data" :key="engin.id">
                        <td>{{ engin.name }}</td>
                        <td>{{ engin.parc.name }}</td>
                        <td>{{ engin.parc.typeparc.name }}</td>
                        <td>{{ engin.site.name }}</td>
                        <td class="d-flex justify-content-end gap-1">
                            <button @click="openEditModal(engin.id)" type="button"
                                class="btn btn-sm btn-outline-primary rounded-pill">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button @click="deleteConfirmation(engin.id)" type="button"
                                class="btn btn-sm btn-outline-danger rounded-pill">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- End Table with hoverable rows -->

        </div>
    </div>

    <EditEngin :engin-id="editingElementId" :show="showModal" @modal-closed="modalClosed" :sites="props.sites"
        :typeparcs="props.typeparcs" />

</template>

<script setup>
import { ref } from 'vue';
import Pagination from '../../Components/Pagination.vue';
import CreateEngin from './CreateEngin.vue';
import EditEngin from './EditEngin.vue';
import { showAlert, useSwalConfirm } from '@/Composables/alert';
import { Inertia } from '@inertiajs/inertia';

const editingElementId = ref(0)
const showModal = ref(false)

const props = defineProps({
    engins: Object,
    typeparcs: Object,
    sites: Object,
})

const modalClosed = () => {
    editingElementId.value = 0;
    showModal.value = false
}

const openEditModal = (id) => {
    editingElementId.value = id;
    showModal.value = true
}

const deleteConfirmation = (id) => {
    useSwalConfirm("Vous êtes sur le point de supprimer cet élément, voulez vous continez?", () => {
        deleteEngin(id)
    })
}

const deleteEngin = (id) => {
    const url = route('engins.delete', { id: id });
    Inertia.delete(url, {
        onSuccess: (page) => {
            showAlert('success', 'Supprimé avec succès!')
        },
        onError: (error) => {
            showAlert('error', error.message ?? "Une erreur s'est produite!")
        }
    });
}

</script>
