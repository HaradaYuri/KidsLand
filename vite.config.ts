import { defineConfig, ConfigEnv, UserConfig } from 'vite';
import { resolve } from 'path';
import { globSync } from 'glob';
import type { OutputOptions, OutputAsset } from 'rollup';
import { imageToWebpPlugin } from 'vite-plugin-image-to-webp';
import liveReload from 'vite-plugin-live-reload';

import fs from 'fs/promises';
import path from 'path';
import react from '@vitejs/plugin-react';

import { scssManager } from './scripts/scss-manager.js';
import { phpConverter } from './scripts/php-converter.js';
import { cssConverter } from './scripts/css-converter.js';

const root = resolve(__dirname, 'src');
const outDir = resolve(__dirname, 'wordpress/wp-content/themes/my-theme');

export default defineConfig(({ command, mode }: ConfigEnv): UserConfig => {
  const isProduction = command === 'build';
  const isWP = mode === 'wp';

  return {
    root,
    base: isWP ? '/wp-content/themes/my-theme/' : '/',

    server: {
      port: 5173,
      origin: isWP ? undefined : 'http://localhost:5173',
    },

    build: {
      outDir,
      emptyOutDir: true,
      manifest: true,
      rollupOptions: {
        input: {
          main: resolve(__dirname, 'src/main.js'),
          ...Object.fromEntries(
            globSync('src/assets/images/**/*.{jpg,jpeg,png,gif,svg}').map(
              (file) => [file.replace(/^src\//, ''), resolve(__dirname, file)]
            )
          ),
        },
        // output: {
        //   entryFileNames: 'assets/js/[name].js',
        //   chunkFileNames: 'assets/js/[name]-[hash].js',
        //   assetFileNames: (assetInfo: OutputAsset): string => {
        //     const extType = assetInfo.name
        //       ? assetInfo.name.split('.').at(-1)
        //       : '';
        //     if (extType && /png|jpe?g|svg|gif|avif|webp|ico/i.test(extType)) {
        //       return `assets/images/[name][extname]`;
        //     }
        //     if (extType && /css|scss/.test(extType)) {
        //       return `assets/css/[name][extname]`;
        //     }
        //     return `assets/[ext]/[name][extname]`;
        //   },
        // },
        output: {
          entryFileNames: 'assets/js/[name].[hash].js',
          chunkFileNames: 'assets/js/[name]-[hash].js',
          assetFileNames: (assetInfo: OutputAsset): string => {
            const extType = assetInfo.name
              ? assetInfo.name.split('.').at(-1)
              : '';
            if (extType && /png|jpe?g|svg|gif|avif|webp|ico/i.test(extType)) {
              return `assets/images/[name].[hash][extname]`;
            }
            if (extType && /css|scss/.test(extType)) {
              return `assets/css/[name].[hash][extname]`;
            }
            return `assets/[ext]/[name].[hash][extname]`;
          },
        },
      },
      minify: isProduction,
      sourcemap: !isProduction,
    } as OutputOptions,

    plugins: [
      liveReload([
        `${outDir}/**/*.php`,
        `${outDir}/**/*.css`,
        `${outDir}/**/*.js`,
      ]),
      scssManager({
        scssDir: 'src/assets/scss',
        globalFile: 'global/_index.scss',
      }),
      {
        ...imageToWebpPlugin({
          imageFormats: ['jpg', 'jpeg', 'png', 'gif'],
          webpQuality: { quality: 80 },
          destinationFolder:
            'wordpress/wp-content/themes/my-theme/assets/images',
        }),
      },
      {
        name: 'wordpress-theme-converter',
        closeBundle: async () => {
          try {
            // Convert HTML to PHP
            // Generate WordPress theme files
            // Convert image paths in PHP to WebP
            await phpConverter({
              srcDir: root,
              distDir: outDir,
              wpThemeDir: outDir,
            });

            // Convert image paths in CSS to WebP
            await cssConverter(outDir);

            console.log(
              'WordPress theme conversion, image path processing, and CSS conversion completed successfully.'
            );
          } catch (error) {
            console.error(
              'Error during WordPress theme conversion, image path processing, or CSS conversion:',
              error
            );
            throw error;
          }
        },
      },
    ],

    // css: {
    //   devSourcemap: true,
    //   preprocessorOptions: {
    //     scss: {
    //       additionalData: `$env: ${mode};`,
    //     },
    //   },
    // },

    optimizeDeps: {
      exclude: ['fsevents'],
    },

    define: {
      'process.env.NODE_ENV': JSON.stringify(
        isProduction ? 'production' : 'development'
      ),
      'process.env.IS_WP': JSON.stringify(isWP),
    },
  };
});
