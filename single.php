<?php

/**
 * The template for displaying single post
 */

// Get featured image for header
$featured_image_id = get_post_thumbnail_id();
$featured_image_url = '';
$featured_image_alt = '';

if ($featured_image_id) {
  $featured_image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
  $featured_image_alt = get_post_meta($featured_image_id, '_wp_attachment_image_alt', true);
}

// Prepare header data to pass to header.php
$header_args = array(
  'header_type' => 'standard', // Force standard header
  'banner_image' => array(
    'url' => $featured_image_url ?: get_template_directory_uri() . '/assets/images/pageImages/fallback.svg',
    'alt' => $featured_image_alt ?: get_the_title()
  )
);

// Pass header data to header.php
get_header(null, $header_args);

while (have_posts()) : the_post();

  // Prepare subheader data
  $subheader_data = array(
    'heading' => get_the_title(),
    'breadcrumbs' => array(
      array(
        'text' => 'News',
        'link' => '/news' // Adjust this to your news archive URL
      ),
      array(
        'text' => get_the_title(),
        'link' => ''
      )
    )
  );


?>

  <!-- Subheader -->
  <?php get_template_part('template-parts/content/subheader', null, $subheader_data); ?>

  <main class="post-container">
    <div class="post-content">
      <?php the_content(); ?>
    </div>

    <div class="post-side">
      <?php if ($featured_image_url): ?>
        <?php unity_image_block($featured_image_url, $featured_image_alt); ?>
      <?php endif; ?>
    </div>
  </main>

<?php endwhile;

get_footer();
?>