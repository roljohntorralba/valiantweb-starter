<?php

/**
 * Setup theme
 */
function vws_theme_support()
{
  add_theme_support('post-thumbnails');
  set_post_thumbnail_size(1200, 9999);

  add_theme_support('title-tag');

  add_theme_support(
    'html5',
    array(
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
      'script',
      'style',
      'navigation-widgets',
    )
  );

  add_theme_support('responsive-embeds');

  add_theme_support('customize-selective-refresh-widgets');

  /*
	 * Adds `async` and `defer` support for scripts registered or enqueued
	 * by the theme.
	 */
  $loader = new VWS_Script_Loader();
  add_filter('script_loader_tag', array($loader, 'filter_script_loader_tag'), 10, 2);
}
add_action('after_setup_theme', 'vws_theme_support');

/**
 * Add async/defer script loader
 */
require get_template_directory() . '/classes/class-vws-script-loader.php';

/**
 * Register and Enqueue styles and scripts
 */
function vws_register_styles_scripts()
{
  $theme_version = wp_get_theme()->get('Version');

  // Styles
  wp_enqueue_style('tailwindcss', get_template_directory_uri() . '/dist/css/main.min.css', array(), $theme_version);
  
  // Scripts
  if ((!is_admin()) && is_singular() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }

  wp_enqueue_script('vws-js', get_template_directory_uri() . '/dist/js/index.min.js', array(), $theme_version, false);
  wp_script_add_data('vws-js', 'async', true);
}
add_action('wp_enqueue_scripts', 'vws_register_styles_scripts');

// Remove wp emoji styles
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');