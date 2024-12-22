<template>

    <Head title="Typeparcs" />

    <!-- Content specific to this page -->
    <div class="content-header">
        <h1>Liste des Typeparc</h1>
    </div>

    <div class="card">
        <div class="card-body ">
            <div class="d-flex justify-content-between align-items-center">

                <CreateTypeparc />

                <Pagination :links="props.typeparcs.links" :prev="props.typeparcs.prev_page_url"
                    :next="props.typeparcs.next_page_url" />

            </div>

            <!-- Table with hoverable rows -->
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Type parc</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="typeparc in props.typeparcs.data" :key="typeparc.id">
                        <td>{{ typeparc.name }}</td>
                        <td class="d-flex justify-content-end gap-1">
                            <button @click="openEditModal(typeparc.id)" type="button"
                                class="btn btn-sm btn-outline-primary rounded-pill">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button @click="deleteConfirmation(typeparc.id)" type="button"
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

    <EditTypeparc :typeparc-id="editingElementId" :show="showModal" @modal-closed="modalClosed" />

</template>

<script setup>
import { ref } from 'vue';
import Pagination from '../../Components/Pagination.vue';
import CreateTypeparc from './CreateTypeparc.vue';
import EditTypeparc from './EditTypeparc.vue';
import { showAlert, useSwalConfirm } from '../../utils/alert';
import { Inertia } from '@inertiajs/inertia';

const editingElementId = ref(0)
const showModal = ref(false)

const props = defineProps({
    typeparcs: Object
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
        deleteTypeparc(id)
    })
}

const deleteTypeparc = (id) => {
    const url = route('typeparcs.delete', { id: id });
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
