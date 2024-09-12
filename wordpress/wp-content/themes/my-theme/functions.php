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
  wp_enqueue_style('my-theme-style', get_template_directory_uri() . '/assets/style/style.css', array('google-fonts', 'slick-carousel'));

  // jQuery
  wp_enqueue_script('jquery');

  // Slick Carousel JS
  wp_enqueue_script('slick-carousel', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), '1.8.1', true);

  // Stickyfill
  wp_enqueue_script('stickyfill', 'https://cdn.jsdelivr.net/npm/stickyfill@2.1.0/dist/stickyfill.min.js', array('jquery'), '2.1.0', true);

  // Main JS
  wp_enqueue_script('my-theme-script', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), null, true);
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