<?php

/**
 * Template part for displaying info cards content block
 */

// Get field values
$cards = get_sub_field('cards');

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
unity_content_block_start('infoCards', $content_block_settings);
?>

<?php if ($cards && !empty($cards)): ?>
  <?php foreach ($cards as $card): ?>
    <div class="card">
      <?php if (!empty($card['image'])): ?>
        <div class="card-thumbnail">
          <img src="<?php echo esc_url($card['image']['url']); ?>"
            alt="<?php echo esc_attr($card['image']['alt'] ?: $card['heading']); ?>">
        </div>
      <?php else: ?>
        <div class="card-thumbnail">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/pageImages/fallback.svg"
            alt="<?php echo esc_attr($card['heading']); ?>">
        </div>
      <?php endif; ?>

      <div class="card-body">
        <?php if (!empty($card['heading'])): ?>
          <?php unity_heading_block($card['heading'], '3'); ?>
        <?php endif; ?>

        <?php if (!empty($card['body_text'])): ?>
          <?php unity_text_block($card['body_text']); ?>
        <?php endif; ?>
      </div>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <div class="errorMessage">No info cards available</div>
<?php endif; ?>

<?php
// End content block wrapper
unity_content_block_end();
?>