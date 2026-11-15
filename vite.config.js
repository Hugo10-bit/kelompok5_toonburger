import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/admin.css',
                'resources/css/errors.css',
                'resources/js/app.js',
                'resources/js/admin.js',
                'resources/js/auth/login.js',
                'resources/js/errors.js',
            ],
            refresh: true,
        }),
    ],
});
