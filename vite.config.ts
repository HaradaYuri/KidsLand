import { defineConfig } from 'vite';
import { resolve } from 'path';
import { globSync } from 'glob';
import VitePluginWebpAndPath from 'vite-plugin-webp-and-path';

const root = resolve(__dirname, 'src');
const outDir = resolve(__dirname, 'wordpress/wp-content/themes/my-theme/dist');

// 共通のinput設定
const commonInputs = {
  main: resolve(root, 'main.js'),
  ...Object.fromEntries(
    globSync('src/assets/images/**/*.{jpg,jpeg,png,gif,svg,webp}').map(
      (file) => [`images/${file.split('/').pop()}`, file]
    )
  ),
};

export default defineConfig(({ mode }) => {
  const isWP = mode === 'wp';

  return {
    root,
    base: isWP ? '/wp-content/themes/my-theme/dist/' : '/',
    server: {
      port: 5173,
      origin: isWP ? undefined : 'http://localhost:5173',
    },
    build: {
      outDir,
      emptyOutDir: true,
      manifest: true,
      rollupOptions: {
        input: commonInputs,
        output: {
          entryFileNames: 'assets/js/[name].[hash].js',
          chunkFileNames: 'assets/js/[name].[hash].js',
          assetFileNames: (assetInfo) => {
            const ext = assetInfo.name.split('.').pop();
            if (ext === 'css') {
              return 'assets/css/[name].[hash][extname]';
            } else if (
              ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'].includes(ext)
            ) {
              return 'assets/images/[name].[hash][extname]';
            } else {
              return 'assets/[name].[hash][extname]';
            }
          },
        },
      },
    },
    plugins: [
      VitePluginWebpAndPath({
        targetDir: outDir,
        imgExtensions: 'jpg,jpeg,png',
        textExtensions: 'html,css,js,php',
        quality: 80,
      }),
    ],
  };
});
