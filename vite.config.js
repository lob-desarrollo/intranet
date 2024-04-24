import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/css/app.css',
                'resources/css/avisos-categoria.css',
                'resources/css/enlaces.css',
                'resources/css/home.css',
                'resources/css/login.css',
                'resources/css/nosotros.css',
                'resources/css/perfil.css',
                'resources/css/variables.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
