import fs from 'fs/promises';
import path from 'path';

export async function cssConverter(outDir) {
  const cssDir = path.join(outDir, 'assets', 'css');

  try {
    const files = await fs.readdir(cssDir);

    for (const file of files) {
      if (path.extname(file).toLowerCase() === '.css') {
        const filePath = path.join(cssDir, file);
        await convertImagePathsInCSS(filePath);
      }
    }

    console.log(
      'CSS files have been processed and image paths updated to WebP.'
    );
  } catch (error) {
    console.error('Error processing CSS files:', error);
  }
}

async function convertImagePathsInCSS(filePath) {
  try {
    let cssContent = await fs.readFile(filePath, 'utf-8');

    const regex =
      /url\(['"]?([^'"()]+\.(?:jpg|jpeg|png))['"]?\)|background-image:\s*url\(['"]?([^'"()]+\.(?:jpg|jpeg|png))['"]?\)/gi;
    cssContent = cssContent.replace(regex, (match, p1, p2) => {
      const imagePath = p1 || p2;
      const newPath = imagePath.replace(/\.(jpg|jpeg|png)$/i, '.webp');
      if (match.startsWith('background-image')) {
        return `background-image: url("${newPath}")`;
      } else {
        return `url("${newPath}")`;
      }
    });

    await fs.writeFile(filePath, cssContent, 'utf-8');
    console.log(`Updated image paths in ${path.basename(filePath)}`);
  } catch (error) {
    console.error(`Error processing ${path.basename(filePath)}:`, error);
  }
}

// 使用例
// cssConverter('/path/to/outDir');
