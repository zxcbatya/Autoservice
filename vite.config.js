import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css',
        'resources/css/ionicons.min.css',
        'resources/css/source-sans-pro.css',
        'resources/js/app.js'
      ],
      refresh: true,
    }),
  ],
  server: {
    hmr: {
      host: '127.0.0.1',
    },
  }
});
