import { defineConfig, ConfigEnv, UserConfig } from 'vite';
import { resolve } from 'path';
import { globSync } from 'glob';
import type { OutputOptions, OutputAsset } from 'rollup';
import VitePluginWebpAndPath from 'vite-plugin-webp-and-path';

import { scssManager } from './scripts/scss-manager.js';
import { phpConverter } from './scripts/php-converter.js';
import { updateWebpPaths } from './scripts/update-webp.js';

// プロジェクトのルートディレクトリと出力ディレクトリを設定
const root = resolve(__dirname, 'src');
const outDir = resolve(__dirname, 'wordpress/wp-content/themes/my-theme');

// メインJSファイルと画像ファイルを入力として設定
const commonInputs = {
  main: resolve(root, 'main.js'),
  ...Object.fromEntries(
    globSync('src/assets/images/**/*.{jpg,jpeg,png,gif,svg,webp}').map(
      (file) => [`images/${file.split('/').pop()}`, file]
    )
  ),
};

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

    // ビルド設定
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
        output: {
          entryFileNames: 'assets/js/[name].js',
          chunkFileNames: 'assets/js/[name]-[hash].js',
          assetFileNames: (assetInfo: OutputAsset): string => {
            const extType = assetInfo.name
              ? assetInfo.name.split('.').at(-1)
              : '';
            if (extType && /png|jpe?g|svg|gif|avif|webp|ico/i.test(extType)) {
              return `assets/images/[name][extname]`;
            }
            if (extType && /css|scss/.test(extType)) {
              return `assets/css/[name][extname]`;
            }
            return `assets/[ext]/[name][extname]`;
          },
        },
      },
      minify: isProduction,
      sourcemap: !isProduction,
    } as OutputOptions,

    // プラグインの設定
    plugins: [
      VitePluginWebpAndPath({
        targetDir: outDir,
        imgExtensions: 'jpg,jpeg,png',
        textExtensions: 'html,css,js,php',
        quality: 80,
      }),
      scssManager({
        scssDir: 'src/assets/scss',
        globalFile: 'global/_index.scss',
      }),
      {
        name: 'vite-plugin-php-converter',
        closeBundle() {
          return phpConverter({
            srcDir: root,
            distDir: outDir,
            wpThemeDir: resolve(
              __dirname,
              'wordpress/wp-content/themes/my-theme'
            ),
          });
        },
      },
      {
        name: 'vite-plugin-update-webp-paths',
        closeBundle() {
          if (isWP) {
            updateWebpPaths(outDir, root);
          }
        },
      },
    ],

    // CSS関連の設定
    css: {
      // 開発時のソースマップ生成を有効化
      devSourcemap: true,
      // SCSSのグローバル変数として現在のモードを追加
      preprocessorOptions: {
        scss: {
          additionalData: `$env: ${mode};`,
        },
      },
    },

    // 依存関係の最適化設定
    optimizeDeps: {
      exclude: ['fsevents'],
    },

    // グローバルに利用可能な環境変数を定義
    define: {
      'process.env.NODE_ENV': JSON.stringify(
        isProduction ? 'production' : 'development'
      ),
      'process.env.IS_WP': JSON.stringify(isWP),
    },
  };
});
