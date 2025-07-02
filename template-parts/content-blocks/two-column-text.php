<?php

/**
 * Template part for displaying two column text content block
 */

// Get field values
$heading = get_sub_field('heading');
$column_one = get_sub_field('column_one');
$column_two = get_sub_field('column_two');

// Get content block settings (nested group field)
$content_block_settings_group = get_sub_field('content_block_settings');
$content_block_settings = array(
  'paddingTop' => $content_block_settings_group['padding_top'] ?? 'medium',
  'paddingBottom' => $content_block_settings_group['padding_bottom'] ?? 'medium',
  'colourTheme' => $content_block_settings_group['colour_theme'] ?? 'white'
);

// Start content block wrapper
unity_content_block_start('twoColumnText', $content_block_settings);
?>

<?php if ($heading): ?>
  <div class="twoColumnText-header">
    <?php unity_heading_block($heading, '2', 'sectionTitle shortUnderline'); ?>
  </div>
<?php endif; ?>

<div class="twoColumnText-body">
  <?php unity_text_block($column_one, 'columnOne'); ?>
  <?php unity_text_block($column_two, 'columnTwo'); ?>
</div>

<?php
// End content block wrapper
unity_content_block_end();
?>