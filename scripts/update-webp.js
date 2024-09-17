import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

export function updateWebpPaths(wpThemeDir, srcDir) {
  const transformPHPContent = (content) => {
    return content.replace(
      /(['"])(?:\.\.\/)*assets\/images\/([^'"]+)(['"])/gi,
      '<?php echo get_template_directory_uri(); ?>/assets/images/$2'
    );
  };

  const transformSCSSContent = (content, filePath) => {
    return content.replace(
      /url\(['"]?(.+?\.)(jpe?g|png|gif)(['"]?)\)/gi,
      (match, p1, p2, p3) => {
        const originalFilePath = path.resolve(path.dirname(filePath), p1 + p2);
        const webpFilePath = originalFilePath.replace(
          /\.(jpe?g|png|gif)$/i,
          '.webp'
        );

        if (fs.existsSync(webpFilePath)) {
          return `url(${p1}webp${p3})`;
        }
        return match;
      }
    );
  };

  const processFiles = (dir) => {
    const files = fs.readdirSync(dir);
    files.forEach((file) => {
      const filePath = path.resolve(dir, file);
      const stat = fs.statSync(filePath);
      if (stat.isDirectory()) {
        processFiles(filePath);
      } else {
        const ext = path.extname(file).toLowerCase();
        let content = fs.readFileSync(filePath, 'utf-8');
        if (ext === '.php') {
          content = transformPHPContent(content);
        } else if (ext === '.scss' || ext === '.sass') {
          content = transformSCSSContent(content, filePath);
        }
        fs.writeFileSync(filePath, content);
      }
    });
  };

  if (fs.existsSync(wpThemeDir)) {
    processFiles(wpThemeDir);
    console.log("wp/PHP files' img paths updated successfully.");
  } else {
    console.warn('PHP directory not found:', wpThemeDir);
  }

  if (fs.existsSync(srcDir)) {
    processFiles(srcDir);
    console.log("src/SCSS files' img paths updated successfully.");
  } else {
    console.warn('src directory not found:', srcDir);
  }
}
