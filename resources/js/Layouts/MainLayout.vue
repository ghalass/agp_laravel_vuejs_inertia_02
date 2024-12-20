<template>

    <!--../nice-admin -->

    <!-- ======= Header ======= -->
    <Header />

    <!-- ======= Sidebar ======= -->
    <Sidebar />

    <!-- ======= main ======= -->

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->



        <section class="section dashboard">
            <slot></slot>
        </section>




    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <Footer />

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

</template>

<script setup>

import Header from "./Partials/Header.vue";
import Sidebar from "./Partials/Sidebar.vue";
import Footer from "./Partials/Footer.vue";
import { toggleBodyClass } from "../utils";



defineProps({
    // Any props that may be passed to the layout
});


</script>
