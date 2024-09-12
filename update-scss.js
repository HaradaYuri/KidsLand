import fs from 'fs';
import path from 'path';
import chokidar from 'chokidar';

const scssDir = path.join(process.cwd(), 'src', 'assets', 'style');
const stylePath = path.join(scssDir, 'style.scss');

function addGlobalUseToScss(filePath) {
  const content = fs.readFileSync(filePath, 'utf8');
  const globalUseStatement = "@use '../global' as *;";

  // Check if the global use statement is already present
  if (!content.includes(globalUseStatement)) {
    const updatedContent = globalUseStatement + '\n' + content;
    fs.writeFileSync(filePath, updatedContent, 'utf8');
    console.log(`Added global use to ${filePath}`);
  }
}

function updateIndex(dirPath) {
  const files = fs.readdirSync(dirPath);
  const exports = files
    .filter(
      (file) =>
        file.startsWith('_') && file.endsWith('.scss') && file !== '_index.scss'
    )
    .map((file) => `@forward '${file.replace('_', '').replace('.scss', '')}';`)
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

function initialUpdate() {
  const dirs = fs
    .readdirSync(scssDir)
    .filter((dir) => fs.statSync(path.join(scssDir, dir)).isDirectory());

  dirs.forEach((dir) => {
    const dirPath = path.join(scssDir, dir);
    updateIndex(dirPath);

    // Process SCSS files to add global use
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

console.log('Starting watcher setup...');
console.log(`Watching directory: ${scssDir}`);

const watcher = chokidar.watch(scssDir, {
  ignored:
    /(^|[\/\\])\.|(_index\.scss)$|style\.scss$|global[\/\\].*|\.css$|\.map$/,
  persistent: true,
  ignoreInitial: true,
  depth: 2,
});

watcher
  .on('ready', () => {
    console.log('Watcher is ready and watching for new SCSS files...');
    initialUpdate();
  })
  .on('add', (filePath) => {
    if (
      filePath.endsWith('.scss') &&
      !filePath.includes('_index.scss') &&
      !filePath.includes('style.scss') &&
      !filePath.includes('global/')
    ) {
      console.log(`New SCSS file ${filePath} has been added`);
      try {
        const dirPath = path.dirname(filePath);
        addGlobalUseToScss(filePath); // Add global use when new file is added
        const indexUpdated = updateIndex(dirPath);
        const styleUpdated = updateStyle();

        if (!indexUpdated && !styleUpdated) {
          console.log('No updates were necessary.');
        }
      } catch (error) {
        console.error(`Error updating for file ${filePath}: ${error.message}`);
      }
    }
  })
  .on('unlink', (filePath) => {
    if (
      filePath.endsWith('.scss') &&
      !filePath.includes('_index.scss') &&
      !filePath.includes('style.scss') &&
      !filePath.includes('global/')
    ) {
      console.log(`SCSS file ${filePath} has been removed`);
      try {
        const dirPath = path.dirname(filePath);
        const indexUpdated = updateIndex(dirPath);
        const styleUpdated = updateStyle();

        if (!indexUpdated && !styleUpdated) {
          console.log('No updates were necessary.');
        }
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

console.log('Watching for SCSS file changes...');
