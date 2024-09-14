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

  const transformHTMLContent = (content) => {
    return content.replace(
      /(src=["'])(?:\.\.\/)*assets\/images\/([^"']+)\.(jpg|jpeg|png|gif)(["'])/gi,
      '$1assets/images/$2.webp$4'
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

  const processFiles = (dir, isHTML = false) => {
    const files = fs.readdirSync(dir);
    files.forEach((file) => {
      const filePath = path.resolve(dir, file);
      const stat = fs.statSync(filePath);
      if (stat.isDirectory()) {
        processFiles(filePath, isHTML);
      } else {
        const ext = path.extname(file).toLowerCase();
        let content = fs.readFileSync(filePath, 'utf-8');
        if (ext === '.php' && !isHTML) {
          content = transformPHPContent(content);
        } else if (ext === '.html' && isHTML) {
          content = transformHTMLContent(content);
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
    processFiles(srcDir, true);
    console.log("src/HTML and SCSS files' img paths updated successfully.");
  } else {
    console.warn('src directory not found:', srcDir);
  }
}
