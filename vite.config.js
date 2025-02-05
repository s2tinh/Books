import fs from 'fs';
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
        host: '0.0.0.0', // Có thể sử dụng host này nếu muốn chạy từ nhiều địa chỉ IP.
        port: 5173, // Cổng mà Vite sẽ chạy, bạn có thể thay đổi nếu cần.
        // HTTPS không cần thiết với Koyed.
    },
});
