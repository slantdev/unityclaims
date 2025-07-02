<?php

/**
 * Template part for displaying call to action 04 content block
 */

// Get field values
$heading = get_sub_field('heading');
$body_text = get_sub_field('body_text');
$button = get_sub_field('button');
$background_image = get_sub_field('background_image');

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

// Prepare background image style
$bg_style = '';
if ($background_image && !empty($background_image['url'])) {
  $bg_style = 'style="background-image: url(' . esc_url($background_image['url']) . ');"';
} else {
  // Fallback to dark grey if no image
  $bg_style = 'style="background-color: #333;"';
}

// Start content block wrapper with custom style
?>
<section class="CTA04 paddingTop-<?php echo esc_attr($content_block_settings['paddingTop']); ?> paddingBottom-<?php echo esc_attr($content_block_settings['paddingBottom']); ?>" <?php echo $bg_style; ?>>
  <div class="CTA04-container">
    <?php if ($heading): ?>
      <?php unity_heading_block($heading, '2'); ?>
    <?php endif; ?>

    <?php if ($body_text): ?>
      <?php unity_text_block($body_text); ?>
    <?php endif; ?>

    <?php if ($button && !empty($button['url'])): ?>
      <a href="<?php echo esc_url($button['url']); ?>"
        target="<?php echo esc_attr($button['target'] ?: '_self'); ?>"
        class="btn btn-primary btn-pill">
        <?php echo esc_html($button['title'] ?: 'Learn More'); ?>
      </a>
    <?php endif; ?>
  </div>
</section>