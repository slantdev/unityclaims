<?php

/**
 * Theme setup.
 */
function theme_setup()
{
  add_theme_support('title-tag');

  add_theme_support(
    'html5',
    array(
      'search-form',
      //'comment-form',
      //'comment-list',
      'gallery',
      'caption',
    )
  );

  // add_theme_support('custom-logo');
  add_theme_support('post-thumbnails');

  // add_theme_support('align-wide');
  // add_theme_support('wp-block-styles');

  add_theme_support('responsive-embeds');

  add_theme_support('editor-styles');
  add_editor_style('css/editor-style.css');
}

add_action('after_setup_theme', 'theme_setup');

/**
 * Required Functions.
 */
require get_template_directory() . '/inc/acf-functions.php';
require get_template_directory() . '/inc/custom-post-types.php';
require get_template_directory() . '/inc/enqueue.php';
require get_template_directory() . '/inc/template-functions.php';
