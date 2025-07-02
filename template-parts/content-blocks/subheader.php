<?php

/**
 * Template part for displaying subheader content block
 */

// Get field values
$heading = get_sub_field('heading');
$breadcrumbs = get_sub_field('breadcrumbs');
$leading_text = get_sub_field('leading_text');
$body_text = get_sub_field('body_text');

// Don't get content block settings since subheader has its own styling
?>

<section class="subheader">
  <div class="subheader-container">
    <div class="subheader-header">
      <?php if ($heading): ?>
        <?php unity_heading_block($heading, '2'); ?>
      <?php endif; ?>

      <?php if ($breadcrumbs && !empty($breadcrumbs)): ?>
        <div class="breadcrumbs">
          <span>
            <a href="<?php echo esc_url(home_url('/')); ?>">Home</a> /
          </span>
          <?php
          $breadcrumb_count = count($breadcrumbs);
          foreach ($breadcrumbs as $index => $breadcrumb):
            $is_last = ($index === $breadcrumb_count - 1);
          ?>
            <?php if (!$is_last && !empty($breadcrumb['link'])): ?>
              <span>
                <a href="<?php echo esc_url($breadcrumb['link']); ?>">
                  <?php echo esc_html($breadcrumb['text']); ?>
                </a> /
              </span>
            <?php else: ?>
              <strong><?php echo esc_html($breadcrumb['text']); ?></strong>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
      <?php elseif ($heading): ?>
        <!-- Fallback to showing heading as breadcrumb if no breadcrumbs defined -->
        <div class="breadcrumbs">
          <span>
            <a href="<?php echo esc_url(home_url('/')); ?>">Home</a> /
          </span>
          <strong><?php echo esc_html($heading); ?></strong>
        </div>
      <?php endif; ?>
    </div>

    <?php if ($leading_text || $body_text): ?>
      <div class="subheader-body">
        <?php if ($leading_text): ?>
          <div class="leadingText">
            <?php echo esc_html($leading_text); ?>
          </div>
        <?php endif; ?>

        <?php if ($body_text): ?>
          <div class="bodyText">
            <?php echo wp_kses_post($body_text); ?>
          </div>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </div>
</section>