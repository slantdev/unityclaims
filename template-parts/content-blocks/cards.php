<?php

/**
 * Template part for displaying cards content block
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
unity_content_block_start('textandcards', $content_block_settings);
?>

<div class="cards">
  <?php if ($cards_list && !empty($cards_list)): ?>
    <?php foreach ($cards_list as $card): ?>
      <?php
      $image = $card['image'] ?? null;
      $heading = $card['heading'] ?? '';
      $body_text = $card['body_text'] ?? '';
      // Note: Link field not in ACF structure but exists in React component
      $link = $card['link'] ?? null;
      ?>

      <?php if ($link && !empty($link['url'])): ?>
        <!-- Card with link -->
        <a href="<?php echo esc_url($link['url']); ?>"
          target="<?php echo esc_attr($link['target'] ?: '_self'); ?>"
          class="card">
        <?php else: ?>
          <!-- Card without link -->
          <div class="card">
          <?php endif; ?>

          <div class="card-media">
            <?php if ($image && !empty($image['url'])): ?>
              <?php unity_image_block($image['url'], $image['alt'] ?? ''); ?>
            <?php endif; ?>
          </div>

          <div class="card-content">
            <?php if ($heading): ?>
              <?php unity_heading_block($heading, '3'); ?>
            <?php endif; ?>

            <?php if ($body_text): ?>
              <?php unity_text_block($body_text); ?>
            <?php endif; ?>
          </div>

          <?php if ($link && !empty($link['url'])): ?>
        </a>
      <?php else: ?>
</div>
<?php endif; ?>

<?php endforeach; ?>
<?php else: ?>
  <div class="errorMessage">No cards available</div>
<?php endif; ?>
</div>

<?php
// End content block wrapper
unity_content_block_end();
?>