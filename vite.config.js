import { defineConfig } from 'vite'
import tailwindcss from '@tailwindcss/vite'
import path from 'path'

export default defineConfig({
    plugins: [tailwindcss()],
    build: {
        outDir: 'assets',
        emptyOutDir: false,
        rollupOptions: {
            input: {
                main: 'src/css/main.css',
                app: 'src/js/main.js',
            },
            output: {
                assetFileNames: 'css/[name][extname]',
                entryFileNames: 'js/[name].js',
            },
        },
    },
})