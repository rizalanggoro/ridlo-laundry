import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    server: {
        fs: {
          // Direktori yang diperbolehkan untuk diakses
          allow: [
            // Default: root project
            path.resolve(__dirname),
            // Tambahkan direktori lain jika dibutuhkan
            // path.resolve(__dirname, '../some-shared-folder'),
          ]
        }
    },
});
