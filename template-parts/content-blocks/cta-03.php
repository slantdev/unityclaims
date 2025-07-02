<?php

/**
 * Template part for displaying call to action 03 content block
 */

// Get field values
$heading = get_sub_field('heading');
$body_text = get_sub_field('body_text');
$link = get_sub_field('link');
$image = get_sub_field('image');
$metrics = get_sub_field('metrics');

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
unity_content_block_start('CTA03', $content_block_settings);
?>

<div class="CTA03-container">
  <div class="CTA03-body">
    <?php if ($link && !empty($link['url'])): ?>
      <a href="<?php echo esc_url($link['url']); ?>"
        target="<?php echo esc_attr($link['target'] ?: '_self'); ?>"
        class="btn btn-primary btn-pill">
        <?php echo esc_html($link['title'] ?: 'Learn More'); ?>
      </a>
    <?php endif; ?>

    <?php if ($heading): ?>
      <?php unity_heading_block($heading, '2'); ?>
    <?php endif; ?>

    <?php if ($body_text): ?>
      <?php unity_text_block($body_text, 'bodyText'); ?>
    <?php endif; ?>

    <?php if ($metrics && !empty($metrics)): ?>
      <div class="metrics">
        <?php foreach ($metrics as $metric): ?>
          <div class="card">
            <div class="imageWrapper">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/tick-circle-gold.svg"
                alt="">
            </div>
            <?php if (!empty($metric['value'])): ?>
              <div class="value"><?php echo esc_html($metric['value']); ?></div>
            <?php endif; ?>
            <?php if (!empty($metric['title'])): ?>
              <div class="title"><?php echo esc_html($metric['title']); ?></div>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>

  <div class="CTA03-image">
    <?php if ($image && !empty($image['url'])): ?>
      <?php unity_image_block($image['url'], $image['alt'] ?? ''); ?>
    <?php else: ?>
      <?php unity_image_block(''); // Will use fallback 
      ?>
    <?php endif; ?>
  </div>
</div>

<?php
// End content block wrapper
unity_content_block_end();
?>