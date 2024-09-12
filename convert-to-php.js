import * as cheerio from 'cheerio';
import fs from 'fs/promises';
import path from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

const srcDir = path.resolve(__dirname, 'src');
const wpThemeDir = path.resolve(
  __dirname,
  'wordpress/wp-content/themes/my-theme'
);

// HTMLファイルをPHPファイルに変換する関数
const convertHTMLToPHP = async (htmlContent, filename) => {
  const $ = cheerio.load(htmlContent);
  updatePaths($);
  return $.html();
};

// パスを更新する関数
const updatePaths = ($) => {
  $('link[rel="stylesheet"]').remove();
  $('script').remove();

  $('img').each((i, elem) => {
    const src = $(elem).attr('src');
    $(elem).attr(
      'src',
      `<?php echo get_stylesheet_directory_uri(); ?>/assets/images/${path.basename(
        src
      )}`
    );
  });

  $('a').each((i, elem) => {
    const href = $(elem).attr('href');
    if (href && href.endsWith('.html')) {
      const newHref = href.replace('.html', '');
      $(elem).attr('href', `<?php echo home_url("${newHref}"); ?>`);
    }
  });
};

// style.cssを生成する関数
const generateStyleCSS = (themeName = 'My Custom Theme') =>
  `
/*
Theme Name: ${themeName}
Author: Name
Description: A custom theme converted from static HTML
Version: 1.0
*/
`.trim();

// functions.phpを生成する関数
const generateFunctionsPHP = () =>
  `
<?php
if (!defined('ABSPATH')) exit;

define('THEME_VERSION', '1.0.0');

function theme_enqueue_assets() {
  // Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css', array(), '6.5.1');

  // Google Fonts
  wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Marcellus&family=Parisienne&display=swap', array(), null);

  // Typekit Fonts
  wp_enqueue_style('typekit-fonts', 'https://use.typekit.net/gzw7lod.css', array(), null);

  // Slick Carousel CSS
  wp_enqueue_style('slick-carousel', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', array(), '1.8.1');

  // Main Style
  wp_enqueue_style('my-theme-style', get_template_directory_uri() . '/css/style.css', array('google-fonts', 'slick-carousel'));

  // jQuery
  wp_enqueue_script('jquery');

  // Slick Carousel JS
  wp_enqueue_script('slick-carousel', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), '1.8.1', true);

  // Stickyfill
  wp_enqueue_script('stickyfill', 'https://cdn.jsdelivr.net/npm/stickyfill@2.1.0/dist/stickyfill.min.js', array('jquery'), '2.1.0', true);

  // Main JS
  wp_enqueue_script('my-theme-script', get_template_directory_uri() . '/js/main.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'theme_enqueue_assets');

function custom_wpseo_title($title) {
    if (is_front_page()) return 'CompanyName | すごいたい焼き屋さん';
    if (is_page('about')) return 'About | CompanyName';
    if (is_page('price')) return 'Price | CompanyName';
    return $title;
}
add_filter('wpseo_title', 'custom_wpseo_title');
add_filter('wpseo_opengraph_title', 'custom_wpseo_title');

function custom_wpseo_metadesc($description) {
    if (is_front_page() || is_page('about') || is_page('price')) return 'ディスクリプション';
    return $description;
}
add_filter('wpseo_metadesc', 'custom_wpseo_metadesc');
add_filter('wpseo_opengraph_desc', 'custom_wpseo_metadesc');
`.trim();

// ディレクトリをコピーする関数
const copyDir = async (src, dest) => {
  await fs.mkdir(dest, { recursive: true });
  const entries = await fs.readdir(src, { withFileTypes: true });
  await Promise.all(
    entries.map((entry) => {
      const srcPath = path.join(src, entry.name);
      const destPath = path.join(dest, entry.name);
      return entry.isDirectory()
        ? copyDir(srcPath, destPath)
        : fs.copyFile(srcPath, destPath);
    })
  );
};

// 基本的なPHPファイルを作成する関数
const createBasicPHPFile = async (filename, content) => {
  try {
    await fs.writeFile(path.join(wpThemeDir, filename), content);
  } catch (error) {
    console.error(`Error creating ${filename}:`, error);
  }
};

// メイン処理を行う関数
const processFiles = async () => {
  try {
    await fs.mkdir(wpThemeDir, { recursive: true });

    // 基本的なPHPファイルを作成
    await Promise.all([
      createBasicPHPFile('header.php', '<?php wp_head(); ?>\n</head>'),
      createBasicPHPFile(
        'footer.php',
        '<?php wp_footer(); ?>\n</body>\n</html>'
      ),
      createBasicPHPFile(
        'front-page.php',
        '<?php get_header(); ?>\n\n<?php get_footer(); ?>'
      ),
      createBasicPHPFile('index.php', '<?php'),
      fs.writeFile(path.join(wpThemeDir, 'style.css'), generateStyleCSS()),
      fs.writeFile(
        path.join(wpThemeDir, 'functions.php'),
        generateFunctionsPHP()
      ),
    ]);

    const files = await fs.readdir(srcDir);
    await Promise.all(
      files.map(async (file) => {
        if (path.extname(file) === '.html') {
          try {
            const content = await fs.readFile(path.join(srcDir, file), 'utf-8');
            const phpContent = await convertHTMLToPHP(content, file);
            const phpFilename =
              file === 'index.html'
                ? 'front-page.php'
                : path.basename(file, '.html') + '.php';
            await fs.writeFile(path.join(wpThemeDir, phpFilename), phpContent);
          } catch (error) {
            console.error(`Error processing ${file}:`, error);
          }
        }
      })
    );

    // assetsディレクトリのコピー
    await copyDir(path.join(srcDir, 'assets'), path.join(wpThemeDir, 'assets'));

    console.log('Files processed successfully.');
  } catch (error) {
    console.error('Error in main process:', error);
  }
};

processFiles();
