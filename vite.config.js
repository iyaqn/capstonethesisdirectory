import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/js/Pages/main.js", // Main entry point
                "resources/assets/style.scss", // Include SCSS
            ],
            refresh: true,
        }),
        vue(),
    ],
    resolve: {
        alias: {
            "@": "/resources/js/Pages", // Ensure this points to your JS source folder
        },
    },
});
