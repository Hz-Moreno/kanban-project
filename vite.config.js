import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input:
            [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/auth/register.js',
                'resources/js/auth/login.js',
                'resources/js/app.js',
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/panel/index.css',
                'resources/js/panel/column.js',
                'resources/js/panel/home.js',
                'resources/js/panel/forms/create-column.js',
                'resources/js/panel/forms/edit-column.js',
                'resources/js/panel/forms/delete-column.js',
                'resources/js/panel/forms/create-task.js',
                'resources/js/panel/forms/delete-task.js'
            ],
            refresh: true,
        }),
    ],
});
