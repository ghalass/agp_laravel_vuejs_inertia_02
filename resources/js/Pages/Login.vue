<template>


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                <div class="d-flex justify-content-center py-4">
                    <a href="/" class="logo d-flex align-items-center w-auto">
                        <img src="../nice-admin/img/logo.png" alt="">
                        <span class="d-none d-lg-block">NiceAdmin</span>
                    </a>
                </div>

                <div class="card mb-3">

                    <div class="card-body">

                        <div class="pt-4 pb-2">
                            <h5 class="card-title text-center pb-0 fs-4">Authentification</h5>
                        </div>

                        <form @submit.prevent="soumettre" class="row g-3 needs-validation">

                            <div class="col-12">
                                <label for="yourUsername" class="form-label">Email</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text" id="inputGroupPrepend">@</span>
                                    <input v-model="form.email" :class="{ 'is-invalid': form.errors.email }" type="text"
                                        name="username" class="form-control" id="yourUsername">
                                    <span v-if="form.errors.email" class="invalid-feedback error fst-italic">
                                        {{ form.errors.email }}
                                    </span>
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="yourPassword" class="form-label">Mot de passe</label>
                                <input v-model="form.password" type="password" name="password" class="form-control"
                                    id="yourPassword">
                            </div>
                            <div class="col-12">
                                <button class="btn btn-outline-primary w-100" type="submit">Connecter</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import { useForm } from '@inertiajs/inertia-vue3';
import AuthLayout from '../Layouts/AuthLayout.vue';

export default {
    layout: AuthLayout
}

</script>

<script setup>
import { showAlert } from '../Composables/alert';

const form = useForm({
    email: "",
    password: ""
})

const soumettre = () => {
    const url = route('login');
    form.post(url, {
        onSuccess: (page) => {
            showAlert('success', 'Connecté avec succès!')
            form.reset();
        },
        onError: (error) => {
            showAlert('error', "Une erreur s'est produite, veuillez réessayer plus tard!")
        }
    });
}

</script>
