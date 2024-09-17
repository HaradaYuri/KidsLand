import * as cheerio from 'cheerio';
import fs from 'fs/promises';
import path from 'path';

export async function phpConverter({ srcDir, distDir, wpThemeDir }) {
  // HTMLファイルをPHPに変換
  const htmlFiles = await fs.readdir(srcDir);
  for (const file of htmlFiles) {
    if (path.extname(file) === '.html') {
      const htmlContent = await fs.readFile(path.join(srcDir, file), 'utf-8');
      const phpContent = await convertHTMLToPHP(htmlContent);
      const phpFilename =
        file === 'index.html'
          ? 'front-page.php'
          : path.basename(file, '.html') + '.php';
      await createOrUpdateFile(
        path.join(wpThemeDir, phpFilename),
        phpContent,
        true
      );
    }
  }

  // WordPressテーマファイルの生成
  await createOrUpdateFile(
    path.join(wpThemeDir, 'style.css'),
    generateStyleCSS(),
    true
  );
  await createOrUpdateFile(
    path.join(wpThemeDir, 'functions.php'),
    generateFunctionsPHP(),
    true
  );
  await createHeaderFile(wpThemeDir);
  await createFooterFile(wpThemeDir);

  console.log('WordPress theme files have been generated and updated.');
}

async function fileExists(filePath) {
  try {
    await fs.access(filePath);
    return true;
  } catch {
    return false;
  }
}

async function createOrUpdateFile(filePath, content, overwrite = false) {
  if (await fileExists(filePath)) {
    if (overwrite) {
      const existingContent = await fs.readFile(filePath, 'utf-8');
      if (existingContent !== content) {
        await fs.writeFile(filePath, content);
        console.log(`Updated ${path.basename(filePath)}`);
      } else {
        console.log(`${path.basename(filePath)} is up to date`);
      }
    } else {
      console.log(`${path.basename(filePath)} already exists. Skipping.`);
    }
  } else {
    await fs.writeFile(filePath, content);
    console.log(`Created ${path.basename(filePath)}`);
  }
}

async function createHeaderFile(wpThemeDir) {
  const headerContent = `
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <!-- ここに <head> コンテンツを追加  -->
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
  `.trim();

  await createOrUpdateFile(
    path.join(wpThemeDir, 'header.php'),
    headerContent,
    false
  );
}

async function createFooterFile(wpThemeDir) {
  const footerContent = `
  <!-- ここに <footer> コンテンツを追加 -->
  <?php wp_footer(); ?>
  </body>
</html>
  `.trim();

  await createOrUpdateFile(
    path.join(wpThemeDir, 'footer.php'),
    footerContent,
    false
  );
}

async function convertHTMLToPHP(htmlContent) {
  const $ = cheerio.load(htmlContent);

  // スタイルシートとスクリプトの参照を更新
  $('link[rel="stylesheet"]').each((i, elem) => {
    const href = $(elem).attr('href');
    $(elem).replaceWith(
      `<?php wp_enqueue_style('style-${i}', get_template_directory_uri() . '/${href}'); ?>`
    );
  });

  $('script').each((i, elem) => {
    const src = $(elem).attr('src');
    if (src) {
      $(elem).replaceWith(
        `<?php wp_enqueue_script('script-${i}', get_template_directory_uri() . '/${src}', array(), null, true); ?>`
      );
    }
  });

  // 画像パスの更新
  $('img').each((i, elem) => {
    const src = $(elem).attr('src');
    $(elem).attr('src', `<?php echo get_template_directory_uri(); ?>/${src}`);
  });

  // PHPヘッダーとフッターの追加
  const phpContent = `<?php get_header(); ?>\n${$.html()}\n<?php get_footer(); ?>`;

  return phpContent;
}

async function copyDir(src, dest) {
  await fs.mkdir(dest, { recursive: true });
  const entries = await fs.readdir(src, { withFileTypes: true });
  for (const entry of entries) {
    const srcPath = path.join(src, entry.name);
    const destPath = path.join(dest, entry.name);
    if (entry.isDirectory()) {
      await copyDir(srcPath, destPath);
    } else {
      await fs.copyFile(srcPath, destPath);
    }
  }
}

function generateStyleCSS(themeName = 'My Theme') {
  return `
/*
Theme Name: ${themeName}
Author: Name
Description: Text
Version: 1.0
*/
  `.trim();
}

function generateFunctionsPHP() {
  return `
<?php
if (!defined('ABSPATH')) exit;
define('THEME_VERSION', '1.0.0');
define('IS_DEVELOPMENT', WP_DEBUG);

function enqueue_all_assets() {
    if (IS_DEVELOPMENT) {
        // Development mode: Load from Vite dev server
        wp_enqueue_script('vite-client', 'http://localhost:3000/@vite/client', [], null);
        wp_enqueue_script('main-js', 'http://localhost:3000/src/main.js', [], null, true);
    } else {
        // Production mode: Load built assets
        $manifest_path = get_template_directory() . '/.vite/manifest.json';
        if (file_exists($manifest_path)) {
            $manifest = json_decode(file_get_contents($manifest_path), true);
            if (isset($manifest['src/main.js'])) {
                $main_js = $manifest['src/main.js'];
                
                // Debug information
                error_log('Main JS file: ' . print_r($main_js, true));
                
                $version = defined('WP_DEBUG') && WP_DEBUG ? filemtime(get_template_directory() . '/.vite/' . $main_js['file']) : THEME_VERSION;
                wp_enqueue_script('main-js', get_template_directory_uri() . '/.vite/' . $main_js['file'], ['jquery'], $version, true);
                
                if (isset($main_js['css'])) {
                    foreach ($main_js['css'] as $css_file) {
                        // Debug information
                        error_log('CSS file: ' . $css_file);
                        
                        $css_version = defined('WP_DEBUG') && WP_DEBUG ? filemtime(get_template_directory() . '/.vite/' . $css_file) : THEME_VERSION;
                        wp_enqueue_style('main-css', get_template_directory_uri() . '/.vite/' . $css_file, [], $css_version);
                    }
                } else {
                    // Debug information
                    error_log('No CSS files found in manifest');
                }
            } else {
                error_log('src/main.js not found in manifest');
            }
        } else {
            error_log('Vite manifest file not found: ' . $manifest_path);
        }
    }
    
    // Enqueue external libraries and fonts
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css', [], '6.5.1');
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Marcellus&family=Parisienne&display=swap', [], null);
    wp_enqueue_style('slick-carousel', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', [], '1.8.1');
    wp_enqueue_script('slick-carousel', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', ['jquery'], '1.8.1', true);
    wp_enqueue_script('stickyfill', 'https://cdn.jsdelivr.net/npm/stickyfill@2.1.0/dist/stickyfill.min.js', ['jquery'], '2.1.0', true);

    // Enqueue jQuery (WordPress core)
    wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'enqueue_all_assets');

/**
 * Enqueue theme assets
 */
// function theme_enqueue_assets() {
//     // Font Awesome
//     wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css', [], '6.5.1');

//     // Google Fonts
//     wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Marcellus&family=Parisienne&display=swap', [], null);

//     // Typekit Fonts
//     wp_enqueue_style('typekit-fonts', 'https://use.typekit.net/gzw7lod.css', [], null);

//     // Slick Carousel
//     wp_enqueue_style('slick-carousel', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', [], '1.8.1');
//     wp_enqueue_script('slick-carousel', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', ['jquery'], '1.8.1', true);

//     // Main Style
//     wp_enqueue_style('main-style', get_template_directory_uri() . '/assets/css/main.css', array('google-fonts', 'slick-carousel'));

//     // Stickyfill
//     wp_enqueue_script('stickyfill', 'https://cdn.jsdelivr.net/npm/stickyfill@2.1.0/dist/stickyfill.min.js', ['jquery'], '2.1.0', true);

//     // jQuery
//     wp_enqueue_script('jquery');

//     // Main JS
//     wp_enqueue_script('main-script', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), null, true);
// }
// add_action('wp_enqueue_scripts', 'theme_enqueue_assets');

/**
 * Custom title for Yoast SEO
 */
function custom_wpseo_title($title) {
    if (is_front_page()) return 'CompanyName | Title';
    if (is_page('about')) return 'About | CompanyName';
    if (is_page('price')) return 'Price | CompanyName';
    return $title;
}
add_filter('wpseo_title', 'custom_wpseo_title');
add_filter('wpseo_opengraph_title', 'custom_wpseo_title');

/**
 * Custom meta description for Yoast SEO
 */
function custom_wpseo_metadesc($description) {
    if (is_front_page() || is_page('about') || is_page('price')) return 'ディスクリプション';
    return $description;
}
add_filter('wpseo_metadesc', 'custom_wpseo_metadesc');
add_filter('wpseo_opengraph_desc', 'custom_wpseo_metadesc');

/**
 * Add theme support
 */
function theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);
}
add_action('after_setup_theme', 'theme_setup');

/**
 * Register navigation menus
 */
function register_theme_menus() {
    register_nav_menus([
        'primary' => __('Primary Menu', 'theme-textdomain'),
        'footer' => __('Footer Menu', 'theme-textdomain'),
    ]);
}
add_action('init', 'register_theme_menus');

/**
 * Disable WordPress emoji script
 */
function disable_wp_emojicons() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
}
add_action('init', 'disable_wp_emojicons');

/**
 * Remove unnecessary meta tags
 */
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');

/**
 * Custom excerpt length
 */
function custom_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'custom_excerpt_length', 999);

/**
 * Custom excerpt more
 */
function custom_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'custom_excerpt_more');
  `.trim();
}
