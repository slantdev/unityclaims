<?php

/**
 * Template part for displaying image button cards carousel content block
 */

// Get field values
$heading = get_sub_field('heading');
$body_text = get_sub_field('body_text');
$cards_list = get_sub_field('cards_list');

// Get content block settings (nested group field)
$content_block_settings_group = get_sub_field('content_block_settings');
$content_block_settings = array(
  'paddingTop' => $content_block_settings_group['padding_top'] ?? 'medium',
  'paddingBottom' => $content_block_settings_group['padding_bottom'] ?? 'medium',
  'colourTheme' => $content_block_settings_group['colour_theme'] ?? 'white'
);

// Fix the case for extraLarge
if ($content_block_settings['paddingTop'] === 'extralarge') {
  $content_block_settings['paddingTop'] = 'extraLarge';
}
if ($content_block_settings['paddingBottom'] === 'extralarge') {
  $content_block_settings['paddingBottom'] = 'extraLarge';
}

// Start content block wrapper
unity_content_block_start('imageButtonCardsCarousel', $content_block_settings);
?>

<div class="imageButtonCardsCarousel-text">
  <?php if ($heading): ?>
    <?php unity_heading_block($heading, '2'); ?>
  <?php endif; ?>

  <?php if ($body_text): ?>
    <?php unity_text_block($body_text); ?>
  <?php endif; ?>

  <div class="imageButtonCardsCarousel-controls">
    <button type="button" class="carousel-control-prev" aria-label="Previous slide">
      <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/chevron-left-white.svg" alt="">
    </button>
    <button type="button" class="carousel-control-next" aria-label="Next slide">
      <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/chevron-right-white.svg" alt="">
    </button>
  </div>
</div>

<div class="imageButtonCardsCarousel-carousel">
  <?php if ($cards_list && !empty($cards_list)): ?>
    <div class="cards">
      <?php foreach ($cards_list as $card): ?>
        <?php
        $link = $card['card_link'] ?? null;
        $image = $card['image'] ?? null;
        $card_heading = $card['heading'] ?? '';

        // Skip if no link
        if (!$link || !$link['url']) continue;
        ?>

        <a href="<?php echo esc_url($link['url']); ?>"
          class="card"
          target="<?php echo esc_attr($link['target'] ?: '_self'); ?>">

          <div class="buttonImage">
            <?php if ($image && !empty($image['url'])): ?>
              <img src="<?php echo esc_url($image['url']); ?>"
                alt="<?php echo esc_attr($image['alt'] ?: ''); ?>">
            <?php else: ?>
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/pageImages/fallback.svg"
                alt="Fallback">
            <?php endif; ?>
          </div>

          <?php if ($card_heading): ?>
            <div class="headingWrapper">
              <h3><?php echo esc_html($card_heading); ?></h3>
            </div>
          <?php endif; ?>

          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/arrow-right-gold.svg"
            alt=""
            class="arrowIcon">
        </a>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="errorMessage">No cards available</div>
  <?php endif; ?>
</div>

<?php
// End content block wrapper
unity_content_block_end();
?>