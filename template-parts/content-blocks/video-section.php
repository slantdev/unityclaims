<?php

/**
 * Template part for displaying video section content block
 */

// Get field values
$video_title = get_sub_field('video_title');
$video_url = get_sub_field('video_url');

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
unity_content_block_start('videoBlock', $content_block_settings);
?>

<div class="videoBlock-video">
  <?php unity_render_video($video_url, $video_title); ?>
</div>

<?php
// End content block wrapper
unity_content_block_end();
?>