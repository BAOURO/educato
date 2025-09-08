import { defineConfig } from 'vite';

export default defineConfig({
  build: {
    outDir: 'assets/dist',
    rollupOptions: {
      input: {
        main: 'src/main.js',
        style: 'src/style.css',
        admin: 'src/admin.css'
      },
      output: {
        entryFileNames: '[name].js',
        chunkFileNames: '[name].js',
        assetFileNames: '[name].[ext]'
      }
    },
    // Configuration optimisée pour Vite 7
    target: 'es2020',
    minify: 'esbuild',
    sourcemap: false
  },
  css: {
    postcss: {
      plugins: [
        require('@tailwindcss/postcss'),
        require('autoprefixer')
      ]
    }
  },
  // Optimisations pour Vite 7
  optimizeDeps: {
    include: ['alpinejs']
  },
  server: {
    hmr: {
      overlay: false
    }
  }
});