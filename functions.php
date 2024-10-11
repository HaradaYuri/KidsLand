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
    'cardLinks' => '/assets/js/components/card-links.js',
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


/**
 * Register custom post types
 */
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

/**
 * Register custom taxonomies
 */
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

/**
 * Modify main query for custom post types
 */
function custom_pre_get_posts($query)
{
  if (!is_admin() && $query->is_main_query()) {
    $post_type = $query->get('post_type');
    $taxonomy = $query->get('taxonomy');
    $term = $query->get('term');

    if ($taxonomy == 'prefecture') {
      $post_type = isset($_GET['post_type']) ? $_GET['post_type'] : 'introduction';
      $query->set('post_type', $post_type);
    }

    if ($taxonomy && $term) {
      if ($post_type == 'introduction' || $post_type == 'letter') {
        $query->set('tax_query', array(
          array(
            'taxonomy' => $taxonomy,
            'field'    => 'slug',
            'terms'    => $term,
          ),
        ));
      }
    }

    if ($post_type == 'letter' || ($taxonomy == 'prefecture' && $post_type == 'letter')) {
      $query->set('posts_per_page', 9);
      $query->set('meta_key', 'letter_date');
      $query->set('orderby', 'meta_value');
      $query->set('order', 'DESC');

      $meta_query = array();

      // 園名での絞り込み
      $nursery = get_query_var('nursery');
      if (!empty($nursery)) {
        $meta_query[] = array(
          'key'     => 'letter_nursery_name',
          'value'   => $nursery,
          'compare' => '=',
        );
      }

      // 年月での絞り込み
      $year = $query->get('year');
      $monthnum = $query->get('monthnum');
      if ($year && $monthnum) {
        $start_date = $year . '-' . sprintf('%02d', $monthnum) . '-01';
        $end_date = $year . '-' . sprintf('%02d', $monthnum) . '-' . date('t', strtotime($start_date));

        $meta_query[] = array(
          'key'     => 'letter_date',
          'value'   => array($start_date, $end_date),
          'compare' => 'BETWEEN',
          'type'    => 'DATE'
        );
      }

      if (!empty($meta_query)) {
        $query->set('meta_query', $meta_query);
      }
    }

    if ($post_type == 'info' || is_tax('info_category')) {
      $query->set('posts_per_page', 10);
      $query->set('meta_key', 'info_date');
      $query->set('orderby', 'meta_value');
      $query->set('order', 'DESC');

      // カテゴリーフィルタリングの処理
      if (isset($_GET['category'])) {
        $query->set('tax_query', array(
          array(
            'taxonomy' => 'info_category',
            'field'    => 'slug',
            'terms'    => $_GET['category'],
          ),
        ));
      }
    }
  }
}
add_action('pre_get_posts', 'custom_pre_get_posts');

/**
 * Modify query clauses for efficient sorting
 */
function custom_posts_clauses($clauses, $wp_query)
{
  global $wpdb;
  if (!is_admin() && $wp_query->is_main_query()) {
    $post_type = $wp_query->get('post_type');

    if ($post_type == 'letter' || $wp_query->is_tax('prefecture')) {
      $clauses['join'] .= " LEFT JOIN (
              SELECT post_id, meta_value AS letter_date
              FROM {$wpdb->postmeta}
              WHERE meta_key = 'letter_date'
          ) AS letter_date ON ({$wpdb->posts}.ID = letter_date.post_id)";
      $clauses['orderby'] = "letter_date.letter_date DESC, " . $clauses['orderby'];
    } elseif ($post_type == 'info' || $wp_query->is_tax('info_category')) {
      $clauses['join'] .= " LEFT JOIN (
              SELECT post_id, meta_value AS info_date
              FROM {$wpdb->postmeta}
              WHERE meta_key = 'info_date'
          ) AS info_date ON ({$wpdb->posts}.ID = info_date.post_id)";
      $clauses['orderby'] = "info_date.info_date DESC, " . $clauses['orderby'];
    }
  }
  return $clauses;
}
add_filter('posts_clauses', 'custom_posts_clauses', 10, 2);

/**
 * Add custom query vars
 */
function add_query_vars_filter($vars)
{
  $vars[] = "nursery";
  $vars[] = "post_type";
  $vars[] = "taxonomy";
  $vars[] = "term";
  return $vars;
}
add_filter('query_vars', 'add_query_vars_filter');

/**
 * Custom rewrite rules
 */
function add_custom_rewrite_rules()
{
  // シンプルなアーカイブURLのためのルール
  add_rewrite_rule(
    '^introduction/?$',
    'index.php?post_type=introduction',
    'top'
  );
  add_rewrite_rule(
    '^letter/?$',
    'index.php?post_type=letter',
    'top'
  );

  // タクソノミーを含むURLのためのルール（ページネーション対応）
  add_rewrite_rule(
    'introduction/([^/]+)/([^/]+)(/page/([0-9]+))?/?$',
    'index.php?post_type=introduction&taxonomy=$matches[1]&term=$matches[2]&paged=$matches[4]',
    'top'
  );
  add_rewrite_rule(
    'letter/([^/]+)/([^/]+)(/page/([0-9]+))?/?$',
    'index.php?post_type=letter&taxonomy=$matches[1]&term=$matches[2]&paged=$matches[4]',
    'top'
  );

  // シンプルなアーカイブのページネーション
  add_rewrite_rule(
    'introduction/page/([0-9]+)/?$',
    'index.php?post_type=introduction&paged=$matches[1]',
    'top'
  );
  add_rewrite_rule(
    'letter/page/([0-9]+)/?$',
    'index.php?post_type=letter&paged=$matches[1]',
    'top'
  );
}

/**
 * Modify permalink structure
 */
function custom_post_type_link($post_link, $post)
{
  if (is_object($post) && ($post->post_type == 'introduction' || $post->post_type == 'letter')) {
    $terms = wp_get_object_terms($post->ID, 'prefecture');
    if ($terms) {
      return str_replace('%prefecture%', $terms[0]->slug, $post_link);
    }
  }
  return $post_link;
}
add_filter('post_type_link', 'custom_post_type_link', 10, 2);

/**
 * Custom template for taxonomy archives
 */
function custom_taxonomy_template($template)
{
  $post_type = get_query_var('post_type');
  $prefecture = get_query_var('prefecture');
  $term = get_query_var('term');

  if ($prefecture && $term) {
    if ($post_type == 'introduction') {
      $new_template = locate_template(array('archive-introduction.php'));
      if (!empty($new_template)) {
        return $new_template;
      }
    } elseif ($post_type == 'letter') {
      $new_template = locate_template(array('archive-letter.php'));
      if (!empty($new_template)) {
        return $new_template;
      }
    }
  }
  return $template;
}
add_filter('template_include', 'custom_taxonomy_template', 99);

/**
 * Disable visual editor for custom post types
 */
function disable_visual_editor($can)
{
  global $post;
  if (isset($post)) {
    $custom_post_types = array('introduction', 'letter', 'info');
    if (in_array($post->post_type, $custom_post_types)) {
      return false;
    }
  }
  return $can;
}
add_filter('user_can_richedit', 'disable_visual_editor');
