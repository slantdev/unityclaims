<?php

/**
 * Template part for displaying quicklinks content block
 */

// Get field values
$quicklinks = get_sub_field('quicklinks');

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
unity_content_block_start('quicklinks', $content_block_settings);

// Display quicklinks
if ($quicklinks && !empty($quicklinks)):
  foreach ($quicklinks as $quicklink):
    $link = $quicklink['link'] ?? null;
    $button_image = $quicklink['button_image'] ?? null;

    // Skip if no link
    if (!$link || !$link['url']) continue;
?>

    <div class="quicklinks-button">
      <a href="<?php echo esc_url($link['url']); ?>"
        target="<?php echo esc_attr($link['target'] ?: '_self'); ?>">

        <div class="quicklinks-button-text">
          <?php echo esc_html($link['title'] ?: 'Untitled'); ?>
        </div>

        <div class="quicklinks-button-image">
          <?php if ($button_image && !empty($button_image['url'])): ?>
            <img src="<?php echo esc_url($button_image['url']); ?>"
              alt="<?php echo esc_attr($button_image['alt'] ?: $link['title']); ?>">
          <?php else: ?>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/pageImages/fallback.svg"
              alt="<?php echo esc_attr($link['title']); ?>">
          <?php endif; ?>
        </div>
      </a>
    </div>

  <?php endforeach;
else: ?>
  <div class="errorMessage">No quicklinks available</div>
<?php endif;

// End content block wrapper
unity_content_block_end();
?>