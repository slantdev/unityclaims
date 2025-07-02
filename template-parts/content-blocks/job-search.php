<?php

/**
 * Template part for displaying job search/list content block
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

// Query jobs
$jobs = new WP_Query(array(
  'post_type' => 'claims-jobs',
  'posts_per_page' => -1,
  'orderby' => 'menu_order date',
  'order' => 'ASC'
));

// Build jobs array for JavaScript
$jobs_data = array();
$locations = array();

if ($jobs->have_posts()):
  while ($jobs->have_posts()): $jobs->the_post();
    $location = get_field('location') ?: '';
    $job_url = get_field('job_url') ?: '#';

    $job_item = array(
      'title' => get_the_title(),
      'location' => $location,
      'url' => $job_url
    );

    $jobs_data[] = $job_item;

    // Collect unique locations
    if ($location && !in_array($location, $locations)) {
      $locations[] = $location;
    }
  endwhile;
  wp_reset_postdata();
endif;

// Sort locations alphabetically
sort($locations);

// Default content
$heading = "Current Roles";
$body_text = "Find the right job for you no matter what it is that you do.";

// Start content block wrapper
unity_content_block_start('jobListing', $content_block_settings);
?>

<div class="jobListing-header">
  <?php unity_heading_block($heading, '2'); ?>
  <?php unity_text_block($body_text); ?>
</div>

<div class="jobListing-search">
  <select id="location-filter">
    <option value="" selected>Select a Location</option>
    <?php foreach ($locations as $location): ?>
      <option value="<?php echo esc_attr($location); ?>"><?php echo esc_html($location); ?></option>
    <?php endforeach; ?>
  </select>

  <input type="search"
    id="job-search"
    placeholder="Search Positions"
    class="col-span-2">
</div>

<div class="jobListing-list" id="job-list">
  <?php if (!empty($jobs_data)): ?>
    <!-- Jobs will be rendered by JavaScript -->
  <?php else: ?>
    <div class="errorMessage">No jobs available at this time.</div>
  <?php endif; ?>
</div>

<script type="text/javascript">
  // Pass PHP data to JavaScript
  window.jobListData = <?php echo json_encode($jobs_data); ?>;
</script>

<?php
// End content block wrapper
unity_content_block_end();
?>