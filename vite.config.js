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
    target: 'es2020',
    minify: 'esbuild',
    sourcemap: false
  },
  css: {
    postcss: {
      plugins: [
        require('tailwindcss'),
        require('autoprefixer')
      ]
    }
  },
  optimizeDeps: {
    include: ['alpinejs']
  },
  server: {
    hmr: {
      overlay: false
    }
  }
});