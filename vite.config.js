import Vue from '@vitejs/plugin-vue'
import Laravel from 'laravel-vite-plugin'
import RadixVueResolver from 'radix-vue/resolver'
import AutoImport from 'unplugin-auto-import/vite'
import Component from 'unplugin-vue-components/vite'
import { defineConfig } from 'vite'

export default defineConfig({
  plugins: [
    Laravel({
      input: ['resources/css/app.css', 'resources/js/app.js', 'resources/js/blog.ts'],
      refresh: true,
    }),
    Vue(),
    Component({
      dirs: [
        'resources/js/blog/components',
      ],
      resolvers: [
        RadixVueResolver(),
      ],
      dts: true,
    }),
    AutoImport({
      imports: [
        'vue',
        {
          from: '@pinia/colada',
          imports: ['useQuery', 'useMutation', 'useQueryCache'],
        },
      ],
      dirs: [
        'resources/js/blog/api/**',
        'resources/js/blog/composables/**',
        'resources/js/blog/queries/**',
      ],
      dts: true,
    }),
  ],
})
