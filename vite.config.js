import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/css/variables.css',
                'resources/css/app.css',
                'resources/css/home.css',
                'resources/css/nosotros.css',
                'resources/css/login.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
