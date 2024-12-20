import './bootstrap';

import { createApp, h } from 'vue';
import { createInertiaApp, Head, Link } from '@inertiajs/inertia-vue3';
import MainLayout from "./Layouts/MainLayout.vue";

import { InertiaProgress } from '@inertiajs/progress'
import { ZiggyVue } from 'ziggy-js';

InertiaProgress.init()

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob("./Pages/**/*.vue", {
            eager: true,
        });
        let page = pages[`./Pages/${name}.vue`].default;
        if (page.layout == null) page.layout = MainLayout;
        return page;

    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props, plugin) })
            .use(plugin)
            .use(ZiggyVue)
            .component("Head", Head)
            .component("Link", Link)
            .mount(el);  // Monter l'application Vue
    }, optimizeDeps: {
        include: ['jquery'],  // Assurez-vous que jQuery est inclus dans les dépendances optimisées
    },
});
