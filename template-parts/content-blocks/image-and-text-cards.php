<?php

/**
 * Template part for displaying image and text cards content block
 */

// Get field values
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
unity_content_block_start('imageAndTextCards', $content_block_settings);
?>

<div class="cards">
  <?php if ($cards_list && !empty($cards_list)): ?>
    <?php foreach ($cards_list as $card): ?>
      <?php
      $heading = $card['heading'] ?? '';
      $text = $card['text'] ?? '';
      $card_link = $card['card_link'] ?? null;
      $image = $card['image'] ?? null;
      ?>

      <div class="card">
        <?php if ($image && !empty($image['url'])): ?>
          <?php if ($card_link && !empty($card_link['url'])): ?>
            <div class="card-thumbnail">
              <a href="<?php echo esc_url($card_link['url']); ?>"
                target="<?php echo esc_attr($card_link['target'] ?: '_self'); ?>">
                <img src="<?php echo esc_url($image['url']); ?>"
                  alt="<?php echo esc_attr($image['alt'] ?: $heading); ?>">
              </a>
            </div>
          <?php else : ?>
            <div class="card-thumbnail">
              <img src="<?php echo esc_url($image['url']); ?>"
                alt="<?php echo esc_attr($image['alt'] ?: $heading); ?>">
            </div>
          <?php endif; ?>

        <?php endif; ?>

        <div class="card-body">
          <?php if ($heading): ?>
            <?php if ($card_link && !empty($card_link['url'])): ?>
              <h4><a class="!no-underline" href="<?php echo esc_url($card_link['url']); ?>"
                  target="<?php echo esc_attr($card_link['target'] ?: '_self'); ?>"><?php echo esc_html($heading); ?></a></h4>
            <?php else : ?>
              <h4><?php echo esc_html($heading); ?></h4>
            <?php endif; ?>
          <?php endif; ?>

          <?php if ($text): ?>
            <div class="card-text"><?php echo wp_kses_post($text); ?></div>
          <?php endif; ?>
        </div>

        <div class="card-footer">
          <?php if ($card_link && !empty($card_link['url'])): ?>
            <div class="card-footer-link">
              <a href="<?php echo esc_url($card_link['url']); ?>"
                target="<?php echo esc_attr($card_link['target'] ?: '_self'); ?>">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/arrow-right-gold.svg" alt="">
              </a>
            </div>
          <?php endif; ?>

          <?php
          // Note: Date field not in ACF - would need to add if required
          // if ($card['date']): 
          ?>
          <!-- <div class="card-footer-date"><?php // echo esc_html($card['date']); 
                                              ?></div> -->
          <?php // endif; 
          ?>
        </div>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <div class="errorMessage">No cards available</div>
  <?php endif; ?>
</div>

<?php
// End content block wrapper
unity_content_block_end();
?>