<?php

/**
 * Template part for displaying image button cards content block
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

// Start content block wrapper
unity_content_block_start('imageButtonCards', $content_block_settings);
?>

<?php if ($heading || $body_text): ?>
  <div class="imageButtonCards-text">
    <?php if ($heading): ?>
      <?php unity_heading_block($heading, '2'); ?>
    <?php endif; ?>

    <?php if ($body_text): ?>
      <?php unity_text_block($body_text); ?>
    <?php endif; ?>
  </div>
<?php endif; ?>

<div class="imageButtonCards-cards">
  <?php if ($cards_list && !empty($cards_list)): ?>
    <div class="cards">
      <?php foreach ($cards_list as $card): ?>
        <?php unity_image_button_card($card); ?>
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