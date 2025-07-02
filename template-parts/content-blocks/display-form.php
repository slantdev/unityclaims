<?php

/**
 * Template part for displaying form content block
 */

// Get field values
$display_form = get_sub_field('display_form');
$embed_code = get_sub_field('embed_code');

// Get content block settings (nested group field)
$content_block_settings_group = get_sub_field('content_block_settings');
$content_block_settings = array(
  'paddingTop' => $content_block_settings_group['padding_top'] ?? 'medium',
  'paddingBottom' => $content_block_settings_group['padding_bottom'] ?? 'medium',
  'colourTheme' => $content_block_settings_group['colour_theme'] ?? 'white'
);

// Start content block wrapper
unity_content_block_start('displayForm', $content_block_settings);

// Display the appropriate form
unity_get_form($display_form, $embed_code);

// End content block wrapper
unity_content_block_end();
