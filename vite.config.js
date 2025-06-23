// import laravel from "laravel-vite-plugin";
import path from "path";
import { defineConfig } from "vite";

export default defineConfig({
    // plugins: [
    //     laravel({
    //         input: [],
    //         refresh: true,
    //     }),
    // ],
    server: {
        fs: {
            // Direktori yang diperbolehkan untuk diakses
            allow: [
                // Default: root project
                path.resolve(__dirname),
                // Tambahkan direktori lain jika dibutuhkan
                // path.resolve(__dirname, '../some-shared-folder'),
            ],
        },
    },
});
