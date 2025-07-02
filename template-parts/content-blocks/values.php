<?php

/**
 * Template part for displaying values section content block
 */

// Get field values
$subtitle = get_sub_field('subtitle');
$heading = get_sub_field('heading');
$body_text = get_sub_field('body_text');
$values = get_sub_field('values');

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
unity_content_block_start('values', $content_block_settings);
?>

<?php if ($subtitle): ?>
  <div class="values-header">
    <?php unity_text_block($subtitle, 'leadingText'); ?>
  </div>
<?php endif; ?>

<div class="values-content">
  <div class="values-content-header">
    <?php if ($heading): ?>
      <?php unity_heading_block($heading, '2'); ?>
    <?php endif; ?>

    <?php if ($body_text): ?>
      <?php unity_text_block($body_text, 'subTitle'); ?>
    <?php endif; ?>
  </div>

  <div class="values-content-body">
    <?php if ($values && !empty($values)): ?>
      <?php foreach ($values as $value): ?>
        <div class="card">
          <?php if (!empty($value['image'])): ?>
            <?php unity_image_block(
              $value['image']['url'],
              $value['image']['alt'] ?: $value['heading']
            ); ?>
          <?php endif; ?>

          <?php if (!empty($value['heading'])): ?>
            <?php unity_heading_block($value['heading'], '3'); ?>
          <?php endif; ?>

          <?php if (!empty($value['body_text'])): ?>
            <?php unity_text_block($value['body_text'], 'bodyText'); ?>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="errorMessage">No values available</div>
    <?php endif; ?>
  </div>
</div>

<?php
// End content block wrapper
unity_content_block_end();
?>