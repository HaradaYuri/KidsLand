<?php
if (!defined('ABSPATH')) exit;
define('THEME_VERSION', '1.0.0');

/**
 * Enqueue theme assets
 */
function theme_enqueue_assets()
{
  // Preconnect to Google Fonts
  wp_enqueue_style('google-fonts-preconnect', 'https://fonts.googleapis.com', array(), null);
  wp_style_add_data('google-fonts-preconnect', 'rel', 'preconnect');

  wp_enqueue_style('google-fonts-gstatic-preconnect', 'https://fonts.gstatic.com', array(), null);
  wp_style_add_data('google-fonts-gstatic-preconnect', 'rel', 'preconnect');
  wp_style_add_data('google-fonts-gstatic-preconnect', 'crossorigin', 'anonymous');

  // Font Awesome
  wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css', [], '6.5.1');

  // Google Fonts
  wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Kosugi+Maru&family=Yusei+Magic&family=Jost:ital,wght@0,100..900;1,100..900&display=swap', [], null);

  // Slick Carousel
  wp_enqueue_style('slick-carousel', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', [], '1.8.1');
  wp_enqueue_script('slick-carousel', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', ['jquery'], '1.8.1', true);

  // Main Style
  wp_enqueue_style('main-style', get_template_directory_uri() . '/assets/css/style.css', ['google-fonts', 'slick-carousel'], THEME_VERSION);

  // Stickyfill
  wp_enqueue_script('stickyfill', 'https://cdn.jsdelivr.net/npm/stickyfill@2.1.0/dist/stickyfill.min.js', ['jquery'], '2.1.0', true);


  // Scripts(module)
  $scripts = array(
    'common' => '/assets/js/common.js',
    'animation' => '/assets/js/components/animation.js',
    'navigation' => '/assets/js/components/navigation.js',
    'slider' => '/assets/js/components/slider.js',
    'accordion' => '/assets/js/components/accordion.js',
    'form' => '/assets/js/layout/form.js',
    'home' => '/assets/js/pages/home.js',
  );

  foreach ($scripts as $handle => $path) {
    wp_enqueue_script_module($handle . '-script', get_theme_file_uri($path));
  }

  // Main JS
  wp_enqueue_script_module('main-script', get_theme_file_uri('/assets/js/main.js'));
}
add_action('wp_enqueue_scripts', 'theme_enqueue_assets');


/**
 * Custom title for Yoast SEO
 */
function custom_wpseo_title($title)
{
  if (is_front_page()) return '桜のこもれびキッズランド｜日本全国の認証・認可保育園';
  if (is_page('about')) return 'わたしたちのこと｜桜のこもれびキッズランド｜日本全国の認証・認可保育園';
  if (is_page('introduction')) return '各園のご紹介｜桜のこもれびキッズランド｜日本全国の認証・認可保育園';
  if (is_page('letter')) return 'こもれびだより｜桜のこもれびキッズランド｜日本全国の認証・認可保育園';
  if (is_page('recruit')) return '採用情報｜桜のこもれびキッズランド｜日本全国の認証・認可保育園';
  if (is_page('contact')) return 'お問い合わせ｜桜のこもれびキッズランド｜日本全国の認証・認可保育園';
  return $title;
}
add_filter('wpseo_title', 'custom_wpseo_title');
add_filter('wpseo_opengraph_title', 'custom_wpseo_title');

/**
 * Custom meta description for Yoast SEO
 */
function custom_wpseo_metadesc($description)
{
  if (is_front_page() || is_page('about') || is_page('price')) return 'ディスクリプション';
  return $description;
}
add_filter('wpseo_metadesc', 'custom_wpseo_metadesc');
add_filter('wpseo_opengraph_desc', 'custom_wpseo_metadesc');


// カスタム投稿タイプの登録
function create_custom_post_types()
{
  // 各園のご紹介
  register_post_type('introduction', array(
    'labels' => array(
      'name' => __('各園のご紹介'),
      'singular_name' => __('園の紹介'),
    ),
    'public' => true,
    'has_archive' => true,
    'rewrite' => array('slug' => 'introduction'),
    'supports' => array('title', 'editor', 'thumbnail'),
  ));

  // こもれびだより
  register_post_type('letter', array(
    'labels' => array(
      'name' => __('こもれびだより'),
      'singular_name' => __('こもれびだより'),
    ),
    'public' => true,
    'has_archive' => true,
    'rewrite' => array('slug' => 'letter'),
    'supports' => array('title', 'editor', 'thumbnail'),
  ));

  // お知らせ
  register_post_type('info', array(
    'labels' => array(
      'name' => __('お知らせ'),
      'singular_name' => __('お知らせ'),
    ),
    'public' => true,
    'has_archive' => true,
    'rewrite' => array('slug' => 'info'),
    'supports' => array('title', 'editor', 'thumbnail'),
  ));
}
add_action('init', 'create_custom_post_types');

// タクソノミーの登録
function create_custom_taxonomies()
{
  // 園の種類
  register_taxonomy('nursery_type', 'introduction', array(
    'hierarchical' => true,
    'labels' => array(
      'name' => __('園の種類'),
      'singular_name' => __('園の種類'),
    ),
    'rewrite' => array('slug' => 'nursery-type'),
  ));

  // 都道府県
  register_taxonomy('prefecture', array('introduction', 'letter'), array(
    'hierarchical' => true,
    'labels' => array(
      'name' => __('都道府県'),
      'singular_name' => __('都道府県'),
    ),
    'rewrite' => array('slug' => 'prefecture'),
  ));

  // お知らせカテゴリー
  register_taxonomy('info_category', 'info', array(
    'hierarchical' => true,
    'labels' => array(
      'name' => __('お知らせカテゴリー'),
      'singular_name' => __('お知らせカテゴリー'),
    ),
    'rewrite' => array('slug' => 'info-category'),
  ));
}
add_action('init', 'create_custom_taxonomies');

// Custom Field Suiteのフィールドグループを登録
// function register_cfs_field_groups()
// {
//   if (function_exists('cfs_field_group')) {
//     // 各園のご紹介用カスタムフィールド
//     $fields = array(
//       array(
//         'type' => 'text',
//         'label' => '住所',
//         'name' => 'address',
//       ),
//       array(
//         'type' => 'text',
//         'label' => '電話番号',
//         'name' => 'tel',
//       ),
//       // 他の必要なフィールドを追加
//     );

//     cfs_field_group('園の詳細情報', $fields, array(
//       'post_types' => array('introduction'),
//     ));

//     // こもれびだより用カスタムフィールド
//     $letter_fields = array(
//       array(
//         'type' => 'loop',
//         'label' => '内容',
//         'name' => 'content',
//         'sub_fields' => array(
//           array(
//             'type' => 'wysiwyg',
//             'label' => '段落',
//             'name' => 'paragraph',
//           ),
//         ),
//       ),
//     );

//     cfs_field_group('こもれびだより詳細', $letter_fields, array(
//       'post_types' => array('letter'),
//     ));

//     // お知らせ用カスタムフィールド
//     $info_fields = array(
//       array(
//         'type' => 'loop',
//         'label' => '内容',
//         'name' => 'content',
//         'sub_fields' => array(
//           array(
//             'type' => 'wysiwyg',
//             'label' => '段落',
//             'name' => 'paragraph',
//           ),
//         ),
//       ),
//     );

//     cfs_field_group('お知らせ詳細', $info_fields, array(
//       'post_types' => array('info'),
//     ));
//   }
// }
// add_action('init', 'register_cfs_field_groups');
