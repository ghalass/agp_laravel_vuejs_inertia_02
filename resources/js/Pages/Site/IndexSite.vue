<template>

    <Head title="Sites" />

    <!-- Content specific to this page -->
    <div class="content-header">
        <h1>Liste des Site</h1>
    </div>

    <div class="card">
        <div class="card-body ">
            <div class="d-flex justify-content-between align-items-center">

                <CreateSite />

                <Pagination :links="props.sites.links" :prev="props.sites.prev_page_url"
                    :next="props.sites.next_page_url" />

            </div>

            <!-- Table with hoverable rows -->
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Site</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="site in props.sites.data" :key="site.id">
                        <td>{{ site.name }}</td>
                        <td class="d-flex justify-content-end gap-1">
                            <button @click="openEditModal(site.id)" type="button"
                                class="btn btn-sm btn-outline-primary rounded-pill">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button @click="deleteConfirmation(site.id)" type="button"
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

    <EditSite :site-id="editingElementId" :show="showModal" @modal-closed="modalClosed" />

</template>

<script setup>
import { ref } from 'vue';
import Pagination from '../../Shared/Pagination.vue';
import CreateSite from './CreateSite.vue';
import EditSite from './EditSite.vue';
import { showAlert, useSwalConfirm } from '../../Composables/alert';
import { Inertia } from '@inertiajs/inertia';

const editingElementId = ref(0)
const showModal = ref(false)

const props = defineProps({
    sites: Object
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
        deleteSite(id)
    })
}

const deleteSite = (id) => {
    const url = route('sites.delete', { id: id });
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
