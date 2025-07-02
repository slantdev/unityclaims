<?php

/**
 * Template part for displaying news list content block
 */

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

// Query news articles
$news_articles = new WP_Query(array(
  'post_type' => 'claims-news',
  'posts_per_page' => -1,
  'orderby' => 'date',
  'order' => 'DESC'
));

// Build cards array
$cards_list = array();

if ($news_articles->have_posts()):
  while ($news_articles->have_posts()): $news_articles->the_post();

    // Get featured image
    $featured_image = get_post_thumbnail_id();
    $image_array = null;
    if ($featured_image) {
      $image_array = array(
        'url' => get_the_post_thumbnail_url(get_the_ID(), 'large'),
        'alt' => get_post_meta($featured_image, '_wp_attachment_image_alt', true)
      );
    }

    // Create card data
    $card = array(
      'image' => $image_array,
      'heading' => get_the_title(),
      'text' => unity_convert_to_excerpt(get_the_content()),
      'card_link' => array(
        'url' => get_the_permalink(),
        'title' => 'Read More',
        'target' => '_self'
      ),
      'date' => unity_convert_to_readable_date(get_the_date('c'))
    );

    $cards_list[] = $card;

  endwhile;
  wp_reset_postdata();
endif;

// Start content block wrapper
unity_content_block_start('imageAndTextCards', $content_block_settings);
?>

<div class="cards">
  <?php if (!empty($cards_list)): ?>
    <?php foreach ($cards_list as $card): ?>

      <div class="card">
        <?php if ($card['image'] && !empty($card['image']['url'])): ?>
          <div class="card-thumbnail">
            <img src="<?php echo esc_url($card['image']['url']); ?>"
              alt="<?php echo esc_attr($card['image']['alt'] ?: $card['heading']); ?>">
          </div>
        <?php endif; ?>

        <div class="card-body">
          <?php if ($card['heading']): ?>
            <h4><?php echo esc_html($card['heading']); ?></h4>
          <?php endif; ?>

          <?php if ($card['text']): ?>
            <div class="card-text"><?php echo wp_kses_post($card['text']); ?></div>
          <?php endif; ?>
        </div>

        <div class="card-footer">
          <?php if ($card['card_link'] && !empty($card['card_link']['url'])): ?>
            <div class="card-footer-link">
              <a href="<?php echo esc_url($card['card_link']['url']); ?>"
                target="<?php echo esc_attr($card['card_link']['target'] ?: '_self'); ?>">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/arrow-right-gold.svg" alt="">
              </a>
            </div>
          <?php endif; ?>

          <?php if ($card['date']): ?>
            <div class="card-footer-date"><?php echo esc_html($card['date']); ?></div>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <div class="errorMessage">No news articles available</div>
  <?php endif; ?>
</div>

<?php
// End content block wrapper
unity_content_block_end();
?>