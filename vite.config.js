import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';
import persianDate from "persian-date";

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/scss/dashboard.scss', 'resources/js/dashboard.js',
                'resources/scss/home.scss', 'resources/js/home.js',],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '$' : 'jQuery',
        },
    },
});
