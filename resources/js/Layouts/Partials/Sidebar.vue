<template>
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item ">
                <Link class="nav-link " :class="{ 'collapsed': $page.component != 'Home' }" :href="route('home')">
                <i class="bi bi-grid"></i>
                <span>Acceuil</span>
                </Link>
            </li><!-- End Dashboard Nav -->

            <li class="nav-item">
                <a class="nav-link " :class="{ 'collapsed': !$page.url.startsWith('/configs') }"
                    data-bs-target="#components-nav" data-bs-toggle="collapse" href="#"
                    :aria-expanded="{ false: $page.url.startsWith('/configs') }">
                    <i class="bi bi-gear"></i><span>Configurations</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="components-nav" class="nav-content collapse "
                    :class="{ 'show': $page.url.startsWith('/configs') }" data-bs-parent="#sidebar-nav">
                    <li>
                        <Link :href="route('sites.index')"
                            :class="{ 'active': $page.url.startsWith('/configs/sites') }">
                        <i class="bi bi-circle"></i><span>Sites</span>
                        </Link>
                    </li>
                    <li>
                        <Link :href="route('typeparcs.index')" :class="{ 'active': $page.url == '/configs/typeparcs' }">
                        <i class="bi bi-circle"></i><span>Types de parcs</span>
                        </Link>
                    </li>
                    <li>
                        <Link :href="route('parcs.index')"
                            :class="{ 'active': $page.url.startsWith('/configs/parcs') }">
                        <i class="bi bi-circle"></i><span>Parcs</span>
                        </Link>
                    </li>
                    <li>
                        <Link :href="route('engins.index')"
                            :class="{ 'active': $page.url.startsWith('/configs/engins') }">
                        <i class="bi bi-circle"></i><span>Engins</span>
                        </Link>
                    </li>
                </ul>
            </li><!-- End Components Nav -->

            <li class="nav-item">
                <a class="nav-link" :class="{ 'collapsed': !$page.url.startsWith('/performaces') }"
                    data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#"
                    :aria-expanded="{ false: $page.url.startsWith('/performaces') }">
                    <i class="bi bi-journal-text"></i><span>Performaces</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <Link :href="route('saisie_rje.index')"
                            :class="{ 'active': $page.url.startsWith('/performaces/saisie_rje') }">
                        <i class="bi bi-circle"></i><span>Saisie RJE</span>
                        </Link>
                    </li>
                </ul>
            </li><!-- End Forms Nav -->

            <li class="nav-heading">Pages</li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="pages-contact.html">
                    <i class="bi bi-envelope"></i>
                    <span>Contact</span>
                </a>
            </li><!-- End Contact Page Nav -->



        </ul>

    </aside><!-- End Sidebar-->
</template>

<script setup>
import { route } from 'ziggy-js';

</script>
