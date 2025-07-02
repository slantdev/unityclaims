<?php

/**
 * Template part for displaying team list content block
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

// Query team members
$team_members = new WP_Query(array(
  'post_type' => 'claims-team',
  'posts_per_page' => -1,
  'orderby' => 'menu_order',
  'order' => 'ASC'
));

// Start content block wrapper
unity_content_block_start('teamList', $content_block_settings);

if ($team_members->have_posts()):
  while ($team_members->have_posts()): $team_members->the_post();

    // Get ACF fields for team member
    $photo = get_field('photo');
    $position = get_field('position');
    $description = get_field('description');
    $contact_details = get_field('contact_details');
?>

    <button class="card"
      type="button"
      data-member-id="<?php echo get_the_ID(); ?>"
      data-member-name="<?php echo esc_attr(get_the_title()); ?>"
      data-member-position="<?php echo esc_attr($position); ?>"
      data-member-description="<?php echo esc_attr($description); ?>"
      data-member-photo="<?php echo esc_attr($photo['url'] ?? ''); ?>"
      data-member-email="<?php echo esc_attr($contact_details['email'] ?? ''); ?>"
      data-member-phone="<?php echo esc_attr($contact_details['phone'] ?? ''); ?>"
      data-member-linkedin="<?php echo esc_attr($contact_details['linkedin'] ?? ''); ?>">

      <div class="card-image">
        <?php if ($photo && !empty($photo['url'])): ?>
          <img src="<?php echo esc_url($photo['url']); ?>"
            alt="<?php echo esc_attr(get_the_title()); ?>">
        <?php else: ?>
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/pageImages/fallback.svg"
            alt="<?php echo esc_attr(get_the_title()); ?>">
        <?php endif; ?>
      </div>

      <div class="card-body">
        <div class="name"><?php the_title(); ?></div>
        <?php if ($position): ?>
          <div class="position"><?php echo esc_html($position); ?></div>
        <?php endif; ?>
        <div class="icon">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/plus.svg" alt="">
        </div>
      </div>
    </button>

  <?php endwhile;
  wp_reset_postdata();
else: ?>
  <div class="errorMessage">No team members found</div>
<?php endif;

// End content block wrapper
unity_content_block_end();
?>

<!-- Modal container -->
<div id="teamModal" class="modal" style="display: none;">
  <div class="modal-overlay"></div>
  <div class="teamModal">
    <div class="teamModal-container">
      <div class="teamModal-image">
        <img src="" alt="">
      </div>
      <div class="teamModal-body">
        <button class="teamModal-body-closeButton" type="button">&times;</button>
        <div class="name"></div>
        <div class="position"></div>
        <div class="description"></div>
      </div>
    </div>
  </div>
</div>