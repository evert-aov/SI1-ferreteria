import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0',
        port: 5173,
        hmr: {
            //host: '192.168.100.69'
            host: '127.0.0.1'
        },
        cors: true, // Habilita CORS
        //origin: 'http://192.168.100.69:5173' // Origen específico
        origin: 'http://127.0.0.1:5173'
    }
});
