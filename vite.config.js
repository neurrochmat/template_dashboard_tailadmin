import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/index.js"],
            // Disable Herd/Valet TLS autodetection; use plain HTTP locally
            detectTls: false,
            refresh: true,
        }),
    ],
});
