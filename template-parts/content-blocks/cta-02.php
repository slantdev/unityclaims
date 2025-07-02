<?php

/**
 * Template part for displaying call to action 02 (testimonial) content block
 */

// Get field values
$quote = get_sub_field('quote');
$name = get_sub_field('name');
$position = get_sub_field('position');
$image = get_sub_field('image');

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

// Start content block wrapper - Note: CTA02 has its own background, so we might override theme
unity_content_block_start('CTA02', $content_block_settings);
?>

<div class="CTA02-body">
  <?php if ($quote): ?>
    <?php unity_text_block($quote, 'quote'); ?>
  <?php endif; ?>

  <?php if ($name || $position): ?>
    <div class="quoteSource">
      <?php if ($name): ?>
        <?php unity_text_block($name, 'name'); ?>
      <?php endif; ?>

      <?php if ($position): ?>
        <?php unity_text_block($position, 'position'); ?>
      <?php endif; ?>
    </div>
  <?php endif; ?>
</div>

<div class="CTA02-image">
  <?php if ($image && !empty($image['url'])): ?>
    <?php unity_image_block($image['url'], $image['alt'] ?? ''); ?>
  <?php else: ?>
    <?php unity_image_block(''); // Will use fallback 
    ?>
  <?php endif; ?>
</div>

<?php
// End content block wrapper
unity_content_block_end();
?>