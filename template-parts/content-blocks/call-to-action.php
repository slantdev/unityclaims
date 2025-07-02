<?php

/**
 * Template part for displaying call to action content block
 */

// Get field values
$heading = get_sub_field('heading');
$text = get_sub_field('text');
$button = get_sub_field('button');

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
unity_content_block_start('mainCTA', $content_block_settings);
?>

<div class="mainCTA-content">
  <?php if ($heading): ?>
    <?php unity_heading_block($heading, '1'); ?>
  <?php endif; ?>

  <?php if ($text): ?>
    <?php unity_text_block($text, 'mb-6'); ?>
  <?php endif; ?>

  <?php if ($button && !empty($button['url'])): ?>
    <a href="<?php echo esc_url($button['url']); ?>"
      target="<?php echo esc_attr($button['target'] ?: '_self'); ?>"
      class="btn btn-pill btn-primary">
      <?php echo esc_html($button['title'] ?: 'Undefined'); ?>
    </a>
  <?php endif; ?>
</div>

<?php
// End content block wrapper
unity_content_block_end();
?>