<?php

/**
 * Theme header template.
 *
 * @package TailPress
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
  <?php wp_head(); ?>
</head>

<body <?php body_class('font-sans'); ?>>
  <?php wp_body_open(); ?>

  <?php

  $header_args = $args ?? array();
  $use_large_header = get_field('use_large_header');

  if (isset($header_args['header_type']) && $header_args['header_type'] === 'standard') {
    // Use standard header with banner image
    $header_data = array(
      'banner_image' => $header_args['banner_image'] ?? null
    );
    get_template_part('template-parts/header/standard-header', null, array('header_data' => $header_data));
  } else if ($use_large_header) {
    get_template_part('template-parts/header/large-header');
  } else {
    // Standard header with banner image
    $banner_image = get_field('banner_image');
    get_template_part('template-parts/header/standard-header', null, array(
      'banner_image' => $banner_image
    ));
  }
