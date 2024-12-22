<template>
    <div>

        <Head title="Saisie RJE" />

        <div class="card py-3">
            <form @submit.prevent="soumettre">
                <div class="card-body">
                    <div class="card-header pt-1">Saisie Journalier des perfomances</div>

                    <div class="row">
                        <div class="col">
                            <label>Date</label>
                            <input v-model="form.daterje" @change="getCurrentSaisie" type="date"
                                class="form-control form-control-sm">
                        </div>
                        <div class="col">
                            <label>Site</label>
                            <select v-model="form.site_id" @change="getCurrentSaisie"
                                class="form-select form-select-sm">
                                <option value=""></option>
                                <option v-for="site in sites" :value="site.id" :key="site.id">
                                    {{ site.name }}
                                </option>
                            </select>
                        </div>
                        <div class="col">
                            <label>Typeparc</label>
                            <select v-model="selectedTypeparc" @change="getCurrentSaisie"
                                class="form-select form-select-sm">
                                <option value=""></option>
                                <option v-for="typeparc in typeparcs" :value="typeparc.id" :key="typeparc.id">
                                    {{ typeparc.name }}
                                </option>
                            </select>
                        </div>
                        <div class="col">
                            <label>Parc</label>
                            <select v-model="selectedParc" @change="getCurrentSaisie"
                                class="form-select form-select-sm">
                                <option value=""></option>
                                <option v-for="parc in parcs" :value="parc.id" :key="parc.id">
                                    {{ parc.name }}
                                </option>
                            </select>
                        </div>
                        <div class="col">
                            <label>Engin</label>
                            <select v-model="form.engin_id" @change="getCurrentSaisie"
                                class="form-select form-select-sm">
                                <option value=""></option>
                                <option v-for="engin in engins" :value="engin.id" :key="engin.id">
                                    {{ engin.name }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label>Typepanne</label>
                            <select class="form-select form-select-sm">
                                <option value=""></option>
                                <option v-for="typepanne in typepannes" :value="typepanne.id" :key="typepanne.id">
                                    {{ typepanne.name }}
                                </option>
                            </select>
                        </div>

                        <div class="col">
                            <label>Panne</label>
                            <select v-model="form.panne_id" class="form-select form-select-sm">
                                <option value=""></option>
                                <option v-for="typeparc in typeparcs" :value="typeparc.id" :key="typeparc.id">
                                    {{ typeparc.name }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="name">HRM</label>
                                <input v-model="form.hrm" class="form-control form-control-sm" type="number" min="0"
                                    max="24" />
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="name">HIM</label>
                                <input v-model="form.him" class="form-control form-control-sm" type="number" min="0"
                                    max="24" />
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="name">NI</label>
                                <input v-model="form.ni" class="form-control form-control-sm" type="number" min="0" />
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="name">NHO</label>
                                <input v-model="form.nho" class="form-control form-control-sm" type="number" min="0"
                                    max="24" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer py-1">
                    <div class="d-flex gap-1 my-2 float-end">
                        <button type="button" class="btn btn-sm btn-outline-danger">Fermer</button>
                        <button type="submit" class="btn btn-sm btn-outline-success">Soumettre</button>
                    </div>
                </div>
            </form>
        </div>
        <p>Count:{{ saisie_rjes.length }}</p>
        <div class="card py-3">
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Engin</th>
                            <th>Panne</th>
                            <th>Site</th>
                            <th>Jour</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="saisie_rje in saisie_rjes" :key="saisie_rje.id">
                            <td>{{ saisie_rje.engin.name }}</td>
                            <td>{{ saisie_rje.panne.name }}</td>
                            <td>{{ saisie_rje.site.name }}</td>
                            <td>{{ moment(saisie_rje.daterje).format('DD-MM-YYYY') }}</td>
                            <td class="d-flex justify-content-end gap-1">
                                <button @click="openEditModal(saisie_rje.id)" type="button"
                                    class="btn btn-sm btn-outline-primary rounded-pill">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button @click="deleteConfirmation(saisie_rje.id)" type="button"
                                    class="btn btn-sm btn-outline-danger rounded-pill">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</template>


<script setup>
import { Inertia } from '@inertiajs/inertia';
import { useForm } from '@inertiajs/inertia-vue3';
import moment from 'moment';
import { ref } from 'vue';

const selectedTypeparc = ref('');
const selectedParc = ref('');

// const searchParc = ref(props.filters.search ?? '')
// const filtreTypeparc = ref(props.filters.filter ?? '')
// const per_page = ref(props.filters.per_page ?? 5)

const parcs = ref([]);
const engins = ref([]);
const saisie_rjes = ref([]);

const props = defineProps({
    sites: Object,
    typeparcs: Object,
    typepannes: Object,
    filters: Object
})

const form = useForm({
    daterje: "",
    engin_id: "",
    site_id: "",
    panne_id: "",
    hrm: "",
    him: "",
    nho: "24",
    ni: "",
})

const getCurrentSaisie = () => {
    updateParcs()
    updateEngins()
    getSaisie_rjes()
}

const updateParcs = () => {
    const url = route('parcs.get_by_typeparc_id', { id: selectedTypeparc.value });
    if (selectedTypeparc.value != '') {
        axios.get(url)
            .then((response) => {
                parcs.value = response.data.parcs
            })
            .catch((error) => {
                console.log(error);
            })
    }
};

const updateEngins = () => {
    const url = route('engins.get_by_parc_id', { id: selectedParc.value });
    if (selectedParc.value != '') {
        axios.get(url)
            .then((response) => {
                // console.log(response.data);

                engins.value = response.data.engins
            })
            .catch((error) => {
                console.log(error);
            })
    }
};

const getSaisie_rjes = () => {
    // const url = route('saisie_rje.get_by_date_engin');
    // if (form.daterje != '' && form.engin_id != '') {
    //     axios.post(url, {
    //         daterje: form.daterje,
    //         engin_id: form.engin_id,
    //     })
    //         .then((response) => {
    //             saisie_rjes.value = response.data.saisie_rjes
    //         })
    //         .catch((error) => {
    //             console.error(error);
    //         })
    // }


    const url = route('saisie_rje.index', { daterje: form.daterje, engin_id: form.engin_id, });

    Inertia.get(url, {}, {
        replace: true,
        preserveState: true,
    });
};

const soumettre = () => {
    // console.log('daterje:', form.daterje);
    // console.log('site_id:', form.site_id);
    // console.log('engin_id:', form.engin_id);

    // const url = route('engins.store');
    // form.post(url, {
    //     onSuccess: (page) => {
    //         closeModal()
    //         showAlert('success', 'Ajouté avec succès!')
    //         form.reset().clearErrors()
    //         selectedTypeparc.value = ''
    //     },
    //     onError: (error) => {
    //         showAlert('error', "Une erreur s'est produite!")
    //     }
    // });
}

</script>
