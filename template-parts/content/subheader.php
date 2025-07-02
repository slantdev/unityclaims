<?php

/**
 * Template part for displaying the subheader
 * // template-parts/content/subheader.php
 *
 * @param array $args {
 *     Arguments passed to the template
 *     @type string $heading The main heading text
 *     @type string $leading_text The leading/intro text
 *     @type string $body_text The body text content
 * }
 */

$heading = $args['heading'] ?? '';
$leading_text = $args['leading_text'] ?? '';
$body_text = $args['body_text'] ?? '';

?>

<section class="subheader">
  <div class="subheader-container">
    <div class="subheader-header">
      <?php if ($heading): ?>
        <?php unity_heading_block($heading, '2'); ?>
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