import { defineConfig, transformWithEsbuild } from 'vite'
import react from '@vitejs/plugin-react'
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    root: 'resources/js', // Si index.html está en resources/js
    plugins: [
      {
        name: 'treat-js-files-as-jsx',
        async transform(code, id) {
          if (!id.match(/src\/.*\.js$/)) return null

          return transformWithEsbuild(code, id, {
            loader: 'jsx',
            jsx: 'automatic',
          })
        },
      },
      react(),
      laravel([
        'resources/css/app.css',
        'resources/js/app.jsx',
    ]),
    ],

    optimizeDeps: {
      force: true,
      esbuildOptions: {
        loader: {
          '.js': 'jsx',
        },
      },
    },
  })
