import "./assets/style.scss";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";

// PrimeVue setup
import PrimeVue from "primevue/config";
import Material from "@primevue/themes/material";
import { definePreset } from "@primevue/themes";
import * as components from "primevue";

import "primeicons/primeicons.css";

// Define PrimeVue theme preset
const MyPreset = definePreset(Material, {
    semantic: {
        primary: {
            50: "{red.50}",
            100: "{red.100}",
            200: "{red.200}",
            300: "{red.300}",
            400: "{red.400}",
            500: "{red.500}",
            600: "{red.600}",
            700: "{red.700}",
            800: "{red.800}",
            900: "{red.900}",
            950: "{red.950}",
        },
    },
});

// Initialize Inertia.js
createInertiaApp({
    resolve: (name) =>
        resolvePageComponent(
            `./views/${name}.vue`, // Dynamic page resolution
            import.meta.glob("./views/**/*.vue") // Glob pattern to find all pages
        ),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });

        // Use PrimeVue with your custom theme preset
        app.use(PrimeVue, {
            theme: {
                preset: MyPreset,
            },
        });

        // Register all PrimeVue components globally
        Object.keys(components).forEach((componentName) => {
            if (components[componentName].name) {
                app.component(
                    components[componentName].name,
                    components[componentName]
                );
            }
        });

        // Use Vue Router (optional if you're using router with Inertia)
        // app.use(router);

        // Use Inertia plugin
        app.use(plugin);
        app.mount(el);
    },
});
