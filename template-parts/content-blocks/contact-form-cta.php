<?php

/**
 * Template part for displaying contact form CTA content block
 */

// Get field values
$heading = get_sub_field('heading');
$body_text = get_sub_field('body_text');
$form_id = get_sub_field('form');

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

// Start content block wrapper - using newsletterCTA as the class name to match React
unity_content_block_start('newsletterCTA', $content_block_settings);
?>

<div class="newsletterCTA-text">
  <?php if ($heading): ?>
    <?php unity_heading_block($heading, '2', 'sectionTitle shortUnderline'); ?>
  <?php endif; ?>

  <?php if ($body_text): ?>
    <?php unity_text_block($body_text); ?>
  <?php endif; ?>
</div>

<div class="newsletterCTA-form">
  <?php unity_get_form($form_id); ?>
</div>

<?php
// End content block wrapper
unity_content_block_end();
?>