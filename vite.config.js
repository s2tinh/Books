import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

// Tạo cấu hình Vite cho Laravel
export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css',
        'resources/css/admin.css',
        'resources/js/app.js',
      ],
      refresh: true,
    }),
  ],
  server: {
    // Đảm bảo sử dụng URL tương thích với môi trường Koyeb
    host: true,
    port: 3000, // Chọn cổng nếu cần thiết
    hmr: {
      host: 'qualified-lari-atbook-eddb05b3.koyeb.app', // Thay bằng URL của Koyeb
    },
  },
});
