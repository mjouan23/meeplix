import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { VitePWA } from 'vite-plugin-pwa';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/boardgames/wttm.css',
                'resources/js/boardgames/wttm.js',
                'resources/css/boardgames/mcrw.css',
                'resources/js/boardgames/mcrw.js',
            ],
            refresh: true,
        }),
        VitePWA({
            registerType: 'autoUpdate',
            includeAssets: ['/favicon.ico'],
            manifest: {
                name: 'Meeplix',
                short_name: 'Meeplix',
                theme_color: '#0b1020',
                background_color: '#0b1020',
                display: 'standalone',
                start_url: '/',
                icons: [
                    { src: '/icons/icon-192.png', sizes: '192x192', type: 'image/png' },
                    { src: '/icons/icon-512.png', sizes: '512x512', type: 'image/png' },
                ],
            },
            workbox: {
                globPatterns: ['**/*.{js,css,html,ico,png,svg,webp}'],
                runtimeCaching: [
                    {
                        // assets/images served by your app
                        urlPattern: ({ url }) => url.origin === self.location.origin && /(\/build|\/images|\/storage)\//.test(url.pathname),
                        handler: 'CacheFirst',
                        options: {
                            cacheName: 'assets-images',
                            expiration: { maxEntries: 300, maxAgeSeconds: 60 * 60 * 24 * 30 },
                        },
                    },
                    {
                        // HTML pages
                        urlPattern: ({ request }) => request.destination === 'document',
                        handler: 'NetworkFirst',
                        options: {
                            cacheName: 'pages',
                            expiration: { maxEntries: 50, maxAgeSeconds: 60 * 60 * 24 * 7 },
                        },
                    },
                ],
            },
            // devOptions: { enabled: true }, // uncomment to test SW in dev
        }),
    ],
    server: {
        host: 'meeplix.local', // virtualhost défini dans /etc/hosts ou Valet
        port: 5173,
        origin: 'http://meeplix.local:5173', // <- FORCE l'origin injectée dans le CSS
        cors: true,
        strictPort: true,
        hmr: {
            host: 'meeplix.local',
            protocol: 'ws',
        },
    }
});
