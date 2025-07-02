<?php

/**
 * Template part for displaying the banner slider
 * // template-parts/header/slider.php
 */

$slides = $args['slides'] ?? array();
$slider_speed = $args['slider_speed'] ?? 9000;

if (empty($slides)) return;
?>

<div class="splide largeHeader-slider">
  <div class="splide__track">
    <ul class="splide__list">
      <?php foreach ($slides as $index => $slide): ?>
        <li class="splide__slide">
          <?php if (!empty($slide['image'])): ?>
            <div class="imageWrapper">
              <img src="<?php echo esc_url($slide['image']['url']); ?>"
                alt="<?php echo esc_attr($slide['image']['alt'] ?: ''); ?>">
            </div>
          <?php endif; ?>
          <div class="splide__slide__content">
            <div class="splide__slide__content__container">
              <?php if (!empty($slide['heading'])): ?>
                <h2><?php echo esc_html($slide['heading']); ?></h2>
              <?php endif; ?>
              <?php if (!empty($slide['body_text'])): ?>
                <div class="textWrapper">
                  <?php echo wp_kses_post($slide['body_text']); ?>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var splide = new Splide('.splide', {
      type: "loop",
      rewind: true,
      arrows: true,
      pagination: false,
      perPage: 1,
      perMove: 1,
      drag: true,
      width: "100vw",
      autoplay: true,
      interval: <?php echo esc_attr($slider_speed); ?>,
    });

    splide.mount();
  });
</script>