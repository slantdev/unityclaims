<?php

/**
 * Template part for displaying full width text content block
 */

// Get field values
$heading = get_sub_field('heading');
$heading_text_align = get_sub_field('heading_text_align');
$text_content = get_sub_field('text_content');

// Get content block settings (nested group field)
$content_block_settings_group = get_sub_field('content_block_settings');
$content_block_settings = array(
  'paddingTop' => $content_block_settings_group['padding_top'] ?? 'medium',
  'paddingBottom' => $content_block_settings_group['padding_bottom'] ?? 'medium',
  'colourTheme' => $content_block_settings_group['colour_theme'] ?? 'white'
);

// Start content block wrapper
unity_content_block_start('fullWidthText', $content_block_settings);
?>

<?php if ($heading): ?>
  <div class="fullWidthText-header">
    <?php
    $heading_class = ($heading_text_align === 'center') ? 'centerUnderline' : 'shortUnderline';
    unity_heading_block($heading, '1', $heading_class);
    ?>
  </div>
<?php endif; ?>

<div class="fullWidthText-body">
  <?php unity_text_block($text_content); ?>
</div>

<?php
// End content block wrapper
unity_content_block_end();
?>