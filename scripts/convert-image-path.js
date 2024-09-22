// convert-images-path.js
import fs from 'fs/promises';
import path from 'path';
import sharp from 'sharp';

async function convertSingleImagePath(imagePath, webpPath) {
  try {
    await sharp(imagePath).webp().toFile(webpPath);
    return true;
  } catch (error) {
    console.error(`Failed to convert image ${imagePath}:`, error);
    return false;
  }
}

export async function convertImagePaths(filePath) {
  try {
    let content = await fs.readFile(filePath, 'utf8');
    const imgRegex = /\.(jpg|jpeg|png)/gi;
    const matches = content.match(imgRegex);

    if (matches) {
      for (const match of matches) {
        const oldPath = path.join(path.dirname(filePath), match);
        const newPath = oldPath.replace(imgRegex, '.webp');

        if (await convertSingleImagePath(oldPath, newPath)) {
          content = content.replace(match, '.webp');
        }
      }
      await fs.writeFile(filePath, content);
    }
  } catch (error) {
    console.error(`Error processing file ${filePath}:`, error);
  }
}

export async function processThemeFiles(themePath) {
  try {
    const entries = await fs.readdir(themePath, { withFileTypes: true });
    for (const entry of entries) {
      const fullPath = path.join(themePath, entry.name);
      if (entry.isDirectory()) {
        await processThemeFiles(fullPath);
      } else if (
        entry.name === 'main.css' ||
        path.extname(entry.name) === '.php'
      ) {
        await convertImagePaths(fullPath);
      }
    }
  } catch (error) {
    console.error(`Error processing theme files in ${themePath}:`, error);
  }
}
