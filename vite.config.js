import { defineConfig } from 'vite';
import minifyLitTemplates from 'rollup-plugin-minify-html-literals';
import postcssCustomMedia from 'postcss-custom-media';
import postcssCustomMediaGenerator from 'postcss-custom-media-generator';
import postcssPresetEnv from 'postcss-preset-env';
import { customMedia } from './src/js/media_queries.ts';


export default defineConfig({
  base: '/static/',
  publicDir: 'src/public',
  plugins: [
    minifyLitTemplates(),
  ],
  server: {
    host: true,
  },
  build: {
    manifest: true,
    outDir: 'codepoints.net/static/',
    rollupOptions: {
      input: ['src/js/main.js', 'src/css/main.css', 'src/css/print.css'],
      output: {
        chunkFileNames: '[name]-[hash].js',
        entryFileNames: '[name]-[hash].js',
        assetFileNames: 'assets/[name]-[hash][extname]',
      },
    },
  },
  css: {
    postcss: {
      plugins: [
        postcssCustomMediaGenerator(customMedia),
        postcssCustomMedia(),
        postcssPresetEnv({
          features: {
            'custom-properties': false,
          },
        }),
      ],
    },
  },
})
