<?php

/**
 * Template part for displaying the standard header
 * // template-parts/header/standard-header.php
 */

$banner_image = get_field('banner_image');
$banner_image_url = $banner_image ? $banner_image['url'] : get_template_directory_uri() . '/assets/images/banners/banner-home.jpg';
?>

<header style="background-image: url(<?php echo esc_url($banner_image_url); ?>)" class="header">
  <div class="header-container">
    <?php get_template_part('template-parts/header/secondary-header'); ?>
    <div class="header-main">
      <?php get_template_part('template-parts/header/logo'); ?>
      <?php get_template_part('template-parts/header/menu'); ?>
    </div>
    <?php get_template_part('template-parts/header/megamenu'); ?>
  </div>
</header>