<?php

/**
 * Template for displaying single claims pages
 */

get_header();

while (have_posts()) : the_post();

  // Get page settings
  $use_large_header = get_field('use_large_header');
  $subheader_leading_text = get_field('subheader_leading_text');
  $subheader_text = get_field('subheader_text');

  // Display subheader ONLY if NOT using large header
  if (!$use_large_header) {
    $subheader_data = array(
      'heading' => get_the_title(),
      'leading_text' => $subheader_leading_text,
      'body_text' => $subheader_text
    );

    get_template_part('template-parts/content/subheader', null, $subheader_data);
  }
?>

  <main id="primary" class="site-main">
    <?php
    // Get content blocks from ACF flexible content
    if (have_rows('content_blocks')) :
      while (have_rows('content_blocks')) : the_row();

        // Get the layout name
        $layout = get_row_layout();

        // Convert layout name to template path (underscores to hyphens)
        $template_name = str_replace('_', '-', $layout);

        // Include the appropriate template part
        get_template_part('template-parts/content-blocks/' . $template_name);

      endwhile;
    endif;
    ?>
  </main>

<?php
endwhile;

get_footer();
