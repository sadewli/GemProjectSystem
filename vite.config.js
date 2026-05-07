import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/inventory/my_inventory/show.css',
                'resources/js/inventory/my_inventory/show.js',
            ],
            refresh: true,
        }),
    ],
});
