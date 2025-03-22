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
    'introduction' => '/assets/js/pages/introduction.js',
    'letter' => '/assets/js/pages/letter.js',
  );

  foreach ($scripts as $handle => $path) {
    wp_enqueue_script_module($handle . '-script', get_theme_file_uri($path));
  }

  // Main JS
  wp_enqueue_script_module('main-script', get_theme_file_uri('/assets/js/main.js'));
}
add_action('wp_enqueue_scripts', 'theme_enqueue_assets');

/**
 * Yoast SEOのメタディスクリプションを上書きする
 */
function custom_wpseo_metadesc($description)
{
  global $post;
  $cfs_text = '';

  if (is_singular('introduction')) {
    $cfs_text = CFS()->get('introduction_text', $post->ID);
  } elseif (is_singular('letter')) {
    $letter_loop = CFS()->get('letter_loop', $post->ID);
    if (! empty($letter_loop) && is_array($letter_loop)) {
      $first_item  = reset($letter_loop);
      if (! empty($first_item['letter_text'])) {
        $cfs_text = $first_item['letter_text'];
      }
    }
  } elseif (is_singular('info')) {
    $info_loop = CFS()->get('info_loop', $post->ID);
    if (! empty($info_loop) && is_array($info_loop)) {
      $first_item = reset($info_loop);
      if (! empty($first_item['info_text'])) {
        $cfs_text = $first_item['info_text'];
      }
    }
  }


  if (! empty($cfs_text)) {
    $cfs_text = strip_shortcodes($cfs_text);
    $cfs_text = wp_strip_all_tags($cfs_text);
    $cfs_text = wp_trim_words($cfs_text, 50, '...');

    $description = $cfs_text;
  }

  return $description;
}
add_filter('wpseo_metadesc', 'custom_wpseo_metadesc');



/**
 * custom breadcrumbs
 */
function custom_breadcrumb_items($breadcrumbs)
{
  // Check if we're on the introduction archive page
  if (is_post_type_archive('introduction')) {
    $taxonomy = $_GET['taxonomy'] ?? null;

    // Create the breadcrumb structure
    $breadcrumbs = array(
      array(
        'url' => home_url(),
        'text' => 'TOP',
      ),
      array(
        'url' => get_post_type_archive_link('introduction'),
        'text' => '各園のご紹介',
      ),
    );

    if ($taxonomy === 'prefecture') {
      $breadcrumbs[] = array(
        'url' => add_query_arg('taxonomy', 'prefecture', get_post_type_archive_link('introduction')),
        'text' => '都道府県から探す',
      );
    } elseif ($taxonomy === 'nursery_type') {
      $breadcrumbs[] = array(
        'url' => add_query_arg('taxonomy', 'nursery_type', get_post_type_archive_link('introduction')),
        'text' => '園の種類から探す',
      );
    }
  } elseif (is_post_type_archive('letter') || is_tax('prefecture')) {
    $breadcrumbs = array(
      array(
        'url' => home_url(),
        'text' => 'TOP',
      ),
      array(
        'url' => get_post_type_archive_link('letter'),
        'text' => 'こもれびだより',
      ),
    );

    $prefecture_slug = get_query_var('prefecture');
    if ($prefecture_slug) {
      $term = get_term_by('slug', $prefecture_slug, 'prefecture');
      if ($term) {
        $breadcrumbs[] = array(
          'url' => add_query_arg('prefecture', $term->slug, get_post_type_archive_link('letter')),
          'text' => $term->name,
        );
      }
    }
  } elseif (is_singular('letter')) {
    // Get custom field values
    $nursery_name = CFS()->get('letter_nursery_name');
    $letter_title = CFS()->get('letter_title');

    $breadcrumbs = array(
      array(
        'url' => home_url(),
        'text' => 'TOP',
      ),
      array(
        'url' => get_post_type_archive_link('letter'),
        'text' => 'こもれびだより',
      ),
      array(
        'text' => '<br class="sp" />' . $nursery_name . 'からのおたより『' . $letter_title . '』',
      ),
    );
  }

  return $breadcrumbs;
}
add_filter('wpseo_breadcrumb_links', 'custom_breadcrumb_items');

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
    'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
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
    'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
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
    'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
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


    // introduction query ***
    if (!is_admin() && $query->is_main_query()) {
      $post_type = $query->get('post_type');
      $taxonomy = $query->get('taxonomy');
      $term = $query->get('term');
      $prefecture = $query->get('prefecture');

      if ($query->is_post_type_archive('introduction')) {
        $query->set('post_type', 'introduction');
        $post_type = 'introduction';
      }

      if ($query->is_singular('introduction')) {
        $query->set('post_type', 'introduction');
        $post_type = 'introduction';
      }

      // Handling prefecture for introduction and letter
      if ($prefecture) {
        if ($post_type == 'introduction' || (empty($post_type) && $query->is_single())) {
          $query->set('post_type', 'introduction');
        } elseif ($post_type == 'letter') {
          $query->set('post_type', 'letter');
        }
      }

      // Handling taxonomy queries
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


      // letter query ***
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

      // info query ***
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
}
add_action('pre_get_posts', 'custom_pre_get_posts');


function custom_rewrite_rules()
{
  // introduction page
  add_rewrite_rule(
    'introduction/([^/]+)/([^/]+)/?$',
    'index.php?post_type=introduction&taxonomy=$matches[1]&term=$matches[2]',
    'top'
  );
  // for pagination url
  add_rewrite_rule(
    'introduction/([^/]+)/([^/]+)/page/([0-9]+)/?$',
    'index.php?post_type=introduction&taxonomy=$matches[1]&term=$matches[2]&paged=$matches[3]',
    'top'
  );


  // letter page
  // letter page
  // 都道府県・園・年月をすべて指定
  add_rewrite_rule(
    'letter/([^/]+)/([^/]+)/([0-9]{4})/([0-9]{2})/?$',
    'index.php?post_type=letter&prefecture=$matches[1]&name=$matches[2]&letter_year=$matches[3]&letter_month=$matches[4]',
    'top'
  );

  // 都道府県・園・年月をすべて指定（ページネーション付き）
  add_rewrite_rule(
    'letter/([^/]+)/([^/]+)/([0-9]{4})/([0-9]{2})/page/([0-9]+)/?$',
    'index.php?post_type=letter&prefecture=$matches[1]&name=$matches[2]&letter_year=$matches[3]&letter_month=$matches[4]&paged=$matches[5]',
    'top'
  );

  // 都道府県と園のみ
  add_rewrite_rule(
    'letter/([^/]+)/([^/]+)/?$',
    'index.php?post_type=letter&prefecture=$matches[1]&name=$matches[2]',
    'top'
  );

  // 都道府県と園のみ（ページネーション付き）
  add_rewrite_rule(
    'letter/([^/]+)/([^/]+)/page/([0-9]+)/?$',
    'index.php?post_type=letter&prefecture=$matches[1]&name=$matches[2]&paged=$matches[3]',
    'top'
  );

  // 都道府県のみ
  add_rewrite_rule(
    'letter/([^/]+)/?$',
    'index.php?post_type=letter&prefecture=$matches[1]',
    'top'
  );

  // 都道府県のみ（ページネーション付き）
  add_rewrite_rule(
    'letter/([^/]+)/page/([0-9]+)/?$',
    'index.php?post_type=letter&prefecture=$matches[1]&paged=$matches[2]',
    'top'
  );

  // date/年月形式のリライトルール
  add_rewrite_rule(
    'letter/date/([0-9]{4})/([0-9]{2})/?$',
    'index.php?post_type=letter&letter_year=$matches[1]&letter_month=$matches[2]',
    'top'
  );

  // date/年月形式のリライトルール（ページネーション付き）
  add_rewrite_rule(
    'letter/date/([0-9]{4})/([0-9]{2})/page/([0-9]+)/?$',
    'index.php?post_type=letter&letter_year=$matches[1]&letter_month=$matches[2]&paged=$matches[3]',
    'top'
  );

  add_rewrite_tag('%prefecture%', '([^/]+)');
  add_rewrite_tag('%name%', '([^/]+)');
  add_rewrite_tag('%letter_year%', '([0-9]{4})');
  add_rewrite_tag('%letter_month%', '([0-9]{2})');
}
add_action('init', 'custom_rewrite_rules');

function clean_pagination_links($link)
{
  $link = remove_query_arg('term', $link);
  $link = str_replace('&#038;', '&', $link);
  return $link;
}
add_filter('paginate_links', 'clean_pagination_links');

// flush_rewrite_rules();


/**
 * Add custom query vars
 */
function add_custom_query_vars($vars)
{
  $custom_vars = array(
    'nursery_type',
    'paged',
    'taxonomy',
    'term',
    'prefecture',
    'name',
    'nursery',
    'post_type',
    'year',
    'monthnum'
  );
  return array_merge($vars, $custom_vars);
}
add_filter('query_vars', 'add_custom_query_vars');

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

// ページネーションリンクのカスタマイズ
function custom_pagination_base($link)
{
  if (is_post_type_archive('introduction') || is_tax('nursery_type') || is_tax('prefecture')) {
    $link = str_replace('page/', '', $link);
  }
  return $link;
}
add_filter('get_pagenum_link', 'custom_pagination_base');

/**
 * Modify permalink structure
 */
function custom_post_type_link($post_link, $post)
{
  if (is_object($post)) {
    if ($post->post_type == 'introduction') {
      $terms = wp_get_object_terms($post->ID, 'prefecture');
      if ($terms) {
        return home_url('/introduction/' . $post->post_name . '/');
      }
    } elseif ($post->post_type == 'letter') {
      $terms = wp_get_object_terms($post->ID, 'prefecture');
      if (!empty($terms) && !is_wp_error($terms)) {
        return home_url('/letter/' . $terms[0]->slug . '/' . $post->post_name . '/');
      }
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
 * letter_date (CFS) を基にアーカイブ検索を可能にする
 */
function modify_letter_query($query)
{
  if (!is_admin() && $query->is_main_query() && $query->get('post_type') === 'letter') {
    $year = $query->get('letter_year');
    $month = $query->get('letter_month');

    if ($year && $month) {
      // 月の最初の日
      $start_date = $year . '-' . $month . '-01';
      // 月の最後の日
      $end_date = date('Y-m-t', strtotime($start_date));

      $query->set('meta_query', array(
        array(
          'key' => 'letter_date',
          'value' => array($start_date, $end_date),
          'compare' => 'BETWEEN',
          'type' => 'DATE'
        )
      ));

      // デバッグ用
      echo "<!-- Using date range: $start_date to $end_date -->";
    }
  }
  return $query;
}
add_action('pre_get_posts', 'modify_letter_query');

// Enqueue the letter filter script
function enqueue_letter_filter_script()
{
  // Only enqueue on the letter archive page
  if (is_post_type_archive('letter') || is_tax('prefecture')) {
    wp_enqueue_script('letter-filter', get_template_directory_uri() . '/assets/js/letter-filter.js', array('jquery'), '1.0', true);
    wp_localize_script('letter-filter', 'letter_data', array(
      'ajax_url' => admin_url('admin-ajax.php'),
      'current_prefecture' => get_query_var('prefecture', ''),
      'current_nursery' => isset($_GET['nursery']) ? sanitize_text_field($_GET['nursery']) : ''
    ));
  }
}
add_action('wp_enqueue_scripts', 'enqueue_letter_filter_script');

// recruit 希望就職先
function add_prefecture_choices()
{
  ob_start();

  $prefectures = get_terms(array(
    'taxonomy' => 'prefecture',
    'hide_empty' => false,
    'orderby' => 'name',
    'order' => 'ASC'
  ));

  echo '<option value=""> </option>';

  if (!empty($prefectures) && !is_wp_error($prefectures)) {
    foreach ($prefectures as $prefecture) {
      printf(
        '<option value="%s">%s</option>',
        esc_attr($prefecture->name),
        esc_html($prefecture->name)
      );
    }
  }

  return ob_get_clean();
}
wpcf7_add_form_tag('prefecture_choices', 'add_prefecture_choices');

/**
 * Disable visual editor for custom post types
 */
function remove_editor_from_post_type()
{
  $post_types = array('letter', 'introduction', 'info');

  foreach ($post_types as $post_type) {
    remove_post_type_support($post_type, 'editor');
  }
}
add_action('init', 'remove_editor_from_post_type');
