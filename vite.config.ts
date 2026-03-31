import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import fs from 'fs';
import path from 'path';
import { viteStaticCopy } from 'vite-plugin-static-copy';
import inject from '@rollup/plugin-inject';

/***TODO: Image optimization may be required for CKEditor 5. Webpack used ImageMinimizerPlugin. May need to install and use vite-plugin-imagemin. */

// Function to scan folders for entry points
function getEntries() {
    const entries: Record<string, string> = {};

    const scanFolder = (folderPath: string) => {
        if (!fs.existsSync(folderPath)) return;

        const files = fs.readdirSync(folderPath);
        files.forEach(file => {
            if (file.endsWith('.ts') && !file.includes('.min') && file !== '.DS_Store') {
                const name = file.replace('.ts', '');
                entries[name] = path.resolve(folderPath, file);
            }
        });
    };

    scanFolder('./webroot/js/admin');
    scanFolder('./webroot/js/common');

    return entries;
}

export default defineConfig({
    plugins: [
        react(),
        viteStaticCopy({
            targets: []
        }),
        inject({
            $: 'jquery',
            jQuery: 'jquery',
            include: [
                '**/*.js',
                '**/*.ts',
                '**/*.jsx',
                '**/*.tsx'
            ]
        })
    ],

    build: {
        // Output to different directory than Webpack during transition
        outDir: 'js/dist',

        // Emit assets to predictable locations
        assetsDir: '',

        rollupOptions: {
            // Start with ONE entry point for testing
            input: getEntries(),

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

    optimizeDeps: {
        include: ['jquery', 'jquery-ui-dist/jquery-ui']
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
    },
    assetsInclude: ['**/*.svg']
});