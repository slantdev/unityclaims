<?php

/**
 * Template part for displaying the large header
 * // template-parts/header/large-header.php
 */

// Get all page settings fields
$banner_sliders = get_field('banner_sliders');
$banner_speed = get_field('banner_speed') ?: 9000;
$quicklinks = get_field('quicklinks');
$dropdown_navigation = get_field('dropdown_navigation');
?>

<header class="largeHeader">
  <div class="largeHeader-container">
    <?php get_template_part('template-parts/header/secondary-header'); ?>

    <div class="largeHeader-header">
      <?php get_template_part('template-parts/header/logo'); ?>
      <?php get_template_part('template-parts/header/menu'); ?>
    </div>

    <?php get_template_part('template-parts/header/megamenu'); ?>

    <?php if ($banner_sliders && count($banner_sliders) > 0): ?>
      <div class="largeHeader-slider-wrapper">
        <?php
        get_template_part('template-parts/header/slider', null, array(
          'slides' => $banner_sliders,
          'slider_speed' => $banner_speed
        ));
        ?>
      </div>
    <?php endif; ?>
  </div>

  <?php if ($quicklinks && count($quicklinks) > 0): ?>
    <div class="largeHeader-footer">
      <?php foreach ($quicklinks as $quicklink): ?>
        <?php
        $link = $quicklink['link'];
        $image = $quicklink['image'];
        ?>
        <a href="<?php echo esc_url($link['url']); ?>"
          target="<?php echo esc_attr($link['target'] ?: '_self'); ?>">
          <?php if ($image): ?>
            <img src="<?php echo esc_url($image['url']); ?>"
              alt="<?php echo esc_attr($image['alt'] ?: ''); ?>">
          <?php endif; ?>
          <span class="button-text"><?php echo esc_html($link['title']); ?></span>
        </a>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</header>

<?php if ($dropdown_navigation && count($dropdown_navigation) > 0): ?>
  <?php get_template_part('template-parts/dropdown-navigation', null, array('dropdown_navigation' => $dropdown_navigation)); ?>
<?php endif; ?>