<template>

    <Head title="Parcs" />

    <div class="content-header">
        <h1>Liste des Parcs</h1>
    </div>

    <div class="card pt-4">
        <div class="card-body ">
            <div class="d-flex justify-content-between align-items-center">

                <Link :href="route('parcs.create')">
                <button type="button" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-plus-lg"></i> Nouveau
                </button>
                </Link>

                <div class="d-flex align-items-center gap-1">
                    <select @change="search" v-model="per_page" class="form-select form-select-sm"
                        aria-label="Default select example">
                        <option value="">Par page</option>
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>

            </div>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>
                            <p>Parc</p>
                            <input @keyup="search" v-model="searchParc" type="text"
                                class=" form-control form-control-sm">
                        </th>
                        <th>
                            <p>Type parc</p>
                            <select @change="search" v-model="filtreTypeparc" class="form-select form-select-sm"
                                aria-label="Default select example">
                                <option value=""></option>
                                <option v-for="typeparc in typeparcs" :value="typeparc.id" :key="typeparc.id">
                                    {{ typeparc.name }}
                                </option>
                            </select>
                        </th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="parc in props.parcs.data" :key="parc.id">
                        <td>{{ parc.name }}</td>
                        <td>{{ parc.typeparc.name }}</td>
                        <td class="d-flex justify-content-end gap-1">
                            <Link :href="route('parcs.edit', { parc: parc.id })"
                                class="btn btn-sm btn-outline-primary rounded-pill">
                            <i class="bi bi-pencil"></i>
                            </Link>
                            <button @click="deleteConfirmation(parc.id)" type="button"
                                class="btn btn-sm btn-outline-danger rounded-pill">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
        <div class="card-footer">
            <Pagination :paginator="props.parcs" />
        </div>
    </div>

</template>

<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { route } from 'ziggy-js';
import { showAlert, useSwalConfirm } from '../../utils/alert';
import Pagination from '../../Components/Pagination.vue';


const props = defineProps({
    parcs: Object,
    typeparcs: Array,
    filters: Object
})

const searchParc = ref(props.filters.search ?? '')
const filtreTypeparc = ref(props.filters.filter ?? '')
const per_page = ref(props.filters.per_page ?? 5)

const search = _.throttle(() => {
    const url = route('parcs.index', { search: searchParc.value, filter: filtreTypeparc.value, per_page: per_page.value });

    Inertia.get(url, {}, {
        replace: true,
        preserveState: true,
    });
}, 500)


const deleteConfirmation = (id) => {
    useSwalConfirm("Vous êtes sur le point de supprimer cet élément, voulez vous continez?", () => {
        deleteParc(id)
    })
}

const deleteParc = (id) => {
    const url = route('parcs.delete', { id: id });
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
