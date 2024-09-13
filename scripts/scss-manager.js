import fs from 'fs';
import path from 'path';
import chokidar from 'chokidar';

/**
 * SCSSマネージャープラグイン
 * SCSSファイルの自動管理と最適化を行うViteプラグイン
 * @param {Object} options - プラグインのオプション
 * @param {string} options.scssDir - SCSSファイルのルートディレクトリ
 * @param {string} options.globalFile - グローバルSCSSファイルのパス
 * @returns {Object} Viteプラグインオブジェクト
 */
export function scssManager(options = {}) {
  const {
    scssDir = path.join(process.cwd(), 'src', 'assets', 'scss'),
    globalFile = 'global/_index.scss',
  } = options;

  const stylePath = path.join(scssDir, 'style.scss');

  /**
   * SCSSファイルにグローバルファイルのインポート文を追加
   * @param {string} filePath - 対象のSCSSファイルパス
   */
  function addGlobalUseToScss(filePath) {
    const content = fs.readFileSync(filePath, 'utf8');
    const globalUseStatement = `@use '${path.relative(
      path.dirname(filePath),
      path.join(scssDir, globalFile)
    )}' as *;`;

    if (!content.includes(globalUseStatement)) {
      const updatedContent = globalUseStatement + '\n' + content;
      fs.writeFileSync(filePath, updatedContent, 'utf8');
      console.log(`Added global use to ${filePath}`);
    }
  }

  /**
   * ディレクトリ内のSCSSファイルのインデックスを更新
   * @param {string} dirPath - 対象ディレクトリのパス
   * @returns {boolean} 更新が行われたかどうか
   */
  function updateIndex(dirPath) {
    const files = fs.readdirSync(dirPath);
    const exports = files
      .filter(
        (file) =>
          file.startsWith('_') &&
          file.endsWith('.scss') &&
          file !== '_index.scss'
      )
      .map(
        (file) => `@forward '${file.replace('_', '').replace('.scss', '')}';`
      )
      .join('\n');

    const indexPath = path.join(dirPath, '_index.scss');
    const currentContent = fs.existsSync(indexPath)
      ? fs.readFileSync(indexPath, 'utf8')
      : '';

    if (currentContent !== exports) {
      fs.writeFileSync(indexPath, exports);
      console.log(`Updated ${indexPath}`);
      return true;
    }
    return false;
  }

  /**
   * メインのstyle.scssファイルを更新
   * @returns {boolean} 更新が行われたかどうか
   */
  function updateStyle() {
    const dirs = fs.readdirSync(scssDir);
    const imports = dirs
      .filter((dir) => fs.statSync(path.join(scssDir, dir)).isDirectory())
      .map((dir) => {
        if (dir === 'pages') {
          const pageFiles = fs.readdirSync(path.join(scssDir, dir));
          return pageFiles
            .filter(
              (file) =>
                file.startsWith('_') &&
                file.endsWith('.scss') &&
                file !== '_index.scss'
            )
            .map(
              (file) =>
                `@use '${dir}/${file.replace('_', '').replace('.scss', '')}';`
            )
            .join('\n');
        } else {
          return `@use '${dir}';`;
        }
      })
      .join('\n');

    const currentContent = fs.existsSync(stylePath)
      ? fs.readFileSync(stylePath, 'utf8')
      : '';

    if (currentContent !== imports) {
      fs.writeFileSync(stylePath, imports);
      console.log(`Updated ${stylePath}`);
      return true;
    }
    return false;
  }

  /**
   * 初期更新処理
   * すべてのSCSSファイルとディレクトリの初期設定を行う
   */
  function initialUpdate() {
    const dirs = fs
      .readdirSync(scssDir)
      .filter((dir) => fs.statSync(path.join(scssDir, dir)).isDirectory());

    dirs.forEach((dir) => {
      const dirPath = path.join(scssDir, dir);
      updateIndex(dirPath);

      // グローバル以外のSCSSファイルにグローバルインポートを追加
      const scssFiles = fs.readdirSync(dirPath).filter((file) => {
        const filePath = path.join(dirPath, file);
        return (
          file.endsWith('.scss') &&
          file !== 'style.scss' &&
          file !== '_index.scss' &&
          file !== '_reset.scss' &&
          !filePath.includes(path.join('global'))
        );
      });
      scssFiles.forEach((file) => {
        const filePath = path.join(dirPath, file);
        addGlobalUseToScss(filePath);
      });
    });

    updateStyle();
  }

  // Viteプラグインオブジェクトを返す
  return {
    name: 'vite-plugin-scss-manager',
    configureServer(server) {
      // ファイル監視の設定
      const watcher = chokidar.watch(scssDir, {
        ignored:
          /(^|[\/\\])\.|(_index\.scss)$|style\.scss$|global[\/\\].*|\.css$|\.map$/,
        persistent: true,
        ignoreInitial: true,
        depth: 2,
      });

      // ファイル変更イベントのハンドリング
      watcher
        .on('ready', () => {
          console.log('SCSS Manager is ready and watching for changes...');
          initialUpdate();
        })
        .on('add', (filePath) => {
          if (
            filePath.endsWith('.scss') &&
            !filePath.includes('_index.scss') &&
            !filePath.includes('style.scss') &&
            !path.relative(scssDir, filePath).startsWith('global/')
          ) {
            console.log(`New SCSS file ${filePath} has been added`);
            try {
              const dirPath = path.dirname(filePath);
              addGlobalUseToScss(filePath);
              updateIndex(dirPath);
              updateStyle();
              server.ws.send({ type: 'full-reload' });
            } catch (error) {
              console.error(
                `Error updating for file ${filePath}: ${error.message}`
              );
            }
          }
        })
        .on('unlink', (filePath) => {
          if (
            filePath.endsWith('.scss') &&
            !filePath.includes('_index.scss') &&
            !filePath.includes('style.scss') &&
            !path.relative(scssDir, filePath).startsWith('global/')
          ) {
            console.log(`SCSS file ${filePath} has been removed`);
            try {
              const dirPath = path.dirname(filePath);
              updateIndex(dirPath);
              updateStyle();
              server.ws.send({ type: 'full-reload' });
            } catch (error) {
              console.error(
                `Error updating after file removal ${filePath}: ${error.message}`
              );
            }
          }
        })
        .on('error', (error) => {
          console.error(`Watcher error: ${error}`);
        });
    },
    buildStart() {
      // ビルド開始時に初期更新を実行
      initialUpdate();
    },
  };
}
