import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import path from 'path';
import { viteStaticCopy } from 'vite-plugin-static-copy';
import inject from '@rollup/plugin-inject';

/***TODO: Image optimization may be required for CKEditor 5. Webpack used ImageMinimizerPlugin. May need to install and use vite-plugin-imagemin. */

export default defineConfig({
    plugins: [
        react(),
        // For copying static assets if needed
        viteStaticCopy({
            targets: [
                // Add any static file copies you need
            ]
        }),
        inject({
            $: 'jquery',
            jQuery: 'jquery',
        })
    ],

    resolve: {
        alias: {
            // Your jQuery alias (Vite handles this differently)
            // Add other aliases as needed
        }
    },

    build: {
        // Output to different directory than Webpack during transition
        outDir: 'js/dist-vite',

        // Emit assets to predictable locations
        assetsDir: '',

        rollupOptions: {
            // Start with ONE entry point for testing
            input: {
                // Pick your simplest JS file to start
                // Example: if you have common/test.js
                'common': path.resolve(__dirname, 'webroot/js/common/common.ts')
            },

            output: {
                // Match your Webpack naming convention
                entryFileNames: '[name].min.js',
                chunkFileNames: '[name].min.js',
                assetFileNames: '[name].[ext]'
            }
        },

        // Increase chunk size warning limit if needed
        chunkSizeWarningLimit: 1000,

        // Source maps (equivalent to your devtool: false)
        sourcemap: false,

        // Minification (Vite uses esbuild by default, which is faster)
        minify: 'esbuild'
    },

    root: 'webroot',
    // Development server config
    server: {
        port: 5173,
        cors: true,
        hmr: {
            overlay: true
        },
        // If your CakePHP runs on localhost:8000 or similar
        proxy: {
            // Proxy API calls to your CakePHP backend if needed
            // '/api': 'http://localhost:8000'
        }
    }
});