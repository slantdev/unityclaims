<?php

/**
 * Output content block wrapper with settings
 */
function unity_content_block_start($block_class = '', $content_settings = array())
{
  // Default settings
  $defaults = array(
    'paddingTop' => 'medium',
    'paddingBottom' => 'medium',
    'colourTheme' => 'white'
  );

  // Merge with provided settings
  $settings = wp_parse_args($content_settings, $defaults);

  // Fix the case for extraLarge
  if ($settings['paddingTop'] === 'extralarge') {
    $settings['paddingTop'] = 'extraLarge';
  }
  if ($settings['paddingBottom'] === 'extralarge') {
    $settings['paddingBottom'] = 'extraLarge';
  }

  // Build classes
  // Special handling for CTA02 - it has its own background
  if ($block_class === 'CTA02') {
    $classes = array($block_class);
    $classes[] = 'paddingTop-' . $settings['paddingTop'];
    $classes[] = 'paddingBottom-' . $settings['paddingBottom'];
    // Don't add theme class for CTA02
  } else {
    // Regular blocks
    $classes = array($block_class);
    $classes[] = 'paddingTop-' . $settings['paddingTop'];
    $classes[] = 'paddingBottom-' . $settings['paddingBottom'];
    $classes[] = unity_get_theme_class($settings['colourTheme']);
  }

  // Output opening tags
  echo '<section class="' . esc_attr(implode(' ', $classes)) . '">';
  echo '<div class="' . esc_attr($block_class) . '-container">';
}

/**
 * Close content block wrapper
 */
function unity_content_block_end()
{
  echo '</div>';
  echo '</section>';
}

/**
 * Get theme class based on colour theme
 */
function unity_get_theme_class($colour_theme)
{
  switch ($colour_theme) {
    case 'white':
      return 'whiteTheme';
    case 'lightGrey':
      return 'lightGreyTheme';
    case 'grey':
      return 'greyTheme';
    case 'darkGrey':
      return 'darkGreyTheme';
    default:
      return 'whiteTheme';
  }
}

// inc/template-functions.php

/**
 * Render a heading block
 */
function unity_heading_block($text, $level = '2', $heading_class = '', $wrapper_class = '')
{
  if (empty($text)) return;

  $allowed_levels = array('1', '2', '3', '4', '5', '6');
  $level = in_array($level, $allowed_levels) ? $level : '2';

  $classes = 'headingWrapper';
  if ($wrapper_class) {
    $classes .= ' ' . $wrapper_class;
  }

  echo '<div class="' . esc_attr($classes) . '">';
  echo '<h' . $level . ' class="' . esc_attr($heading_class) . '">' . esc_html($text) . '</h' . $level . '>';
  echo '</div>';
}

/**
 * Render a text block with support for different content types
 */
function unity_text_block($text_content, $wrapper_class = '')
{
  if (!$text_content) return;

  $classes = 'textWrapper';
  if ($wrapper_class) {
    $classes .= ' ' . $wrapper_class;
  }

  echo '<div class="' . esc_attr($classes) . '">';

  // Check if text_content is an array (repeater)
  if (is_array($text_content) && !empty($text_content)) {
    // Handle repeater content
    foreach ($text_content as $text_element) {
      unity_text_block_element($text_element);
    }
  } else {
    // Handle WYSIWYG/simple text content
    echo unity_kses_post_with_iframe($text_content);
  }

  echo '</div>';
}


/**
 * Render individual text block elements from ACF repeater
 */
function unity_text_block_element($text_element)
{
  if (!is_array($text_element)) {
    return;
  }

  $type = $text_element['type'] ?? '';
  $text = $text_element['text'] ?? '';
  $image = $text_element['image'] ?? null;

  switch ($type) {
    case 'leadingText':
      echo '<div class="leadingText">';
      echo unity_kses_post_with_iframe($text);
      echo '</div>';
      break;

    case 'bodyText':
      // Note: CSS uses .bodyText not .body
      echo '<div class="bodyText">';
      echo unity_kses_post_with_iframe($text);
      echo '</div>';
      break;

    case 'image':
      if ($image && !empty($image['url'])) {
        unity_image_block(
          $image['url'],
          $image['alt'] ?? ''
        );
      }
      break;
  }
}

/**
 * Render an image block
 */
function unity_image_block($image_src, $image_alt = '', $wrapper_class = '', $image_class = '')
{
  $wrapper_classes = 'imageWrapper';
  if ($wrapper_class) {
    $wrapper_classes .= ' ' . $wrapper_class;
  }

  // Use fallback if no image source
  if (!$image_src) {
    $image_src = get_template_directory_uri() . '/assets/images/pageImages/fallback.svg';
    $image_alt = 'Fallback';
  }

  echo '<div class="' . esc_attr($wrapper_classes) . '">';
  echo '<img src="' . esc_url($image_src) . '" alt="' . esc_attr($image_alt) . '" class="' . esc_attr($image_class) . '" />';
  echo '</div>';
}

/**
 * Custom wp_kses that allows iframes
 */
function unity_kses_post_with_iframe($content)
{
  $allowed_tags = wp_kses_allowed_html('post');

  // Add iframe to allowed tags
  $allowed_tags['iframe'] = array(
    'src' => true,
    'width' => true,
    'height' => true,
    'frameborder' => true,
    'allowfullscreen' => true,
    'allow' => true,
    'title' => true,
    'class' => true,
    'id' => true,
    'style' => true,
    'loading' => true,
    'name' => true,
    'referrerpolicy' => true,
    'sandbox' => true,
    'srcdoc' => true,
    'align' => true,
    'scrolling' => true,
    'marginheight' => true,
    'marginwidth' => true,
  );

  return wp_kses($content, $allowed_tags);
}

// inc/forms.php or add to functions.php
/**
 * Display the appropriate form based on form ID
 */
function unity_get_form($form_id, $embed_code = '')
{
  switch ($form_id) {
    case 'generalContact':
      unity_general_contact_form();
      break;

    case 'becomeARepairer':
      unity_become_repairer_form();
      break;

    case 'bookACar':
      unity_book_car_form();
      break;

    case 'complaint':
      unity_complaint_form();
      break;

    case 'jobApplication':
      unity_job_application_form();
      break;

    case 'newsletter':
      unity_newsletter_form();
      break;

    case 'embed':
      if ($embed_code) {
        echo wp_kses_post($embed_code);
      }
      break;

    default:
      echo '<p>Form not found</p>';
  }
}

/**
 * General Contact Form for Contact Form CTA
 */
function unity_general_contact_form()
{
?>
  <form id="general-contact-form" class="unity-form" method="post" action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>">
    <?php wp_nonce_field('unity_form_submit', 'unity_form_nonce'); ?>
    <input type="hidden" name="action" value="unity_form_submit">
    <input type="hidden" name="form_type" value="general_contact">

    <input type="text"
      name="first_name"
      placeholder="First Name *"
      required>

    <input type="text"
      name="last_name"
      placeholder="Last Name *"
      required>

    <input type="email"
      name="email"
      placeholder="Email *"
      required>

    <input type="tel"
      name="phone"
      placeholder="Phone">

    <input type="text"
      name="company"
      placeholder="Company">

    <input type="text"
      name="state"
      placeholder="State">

    <textarea name="message"
      placeholder="Message"
      rows="4"
      class="col-span-2"></textarea>

    <input type="submit"
      value="Submit"
      class="col-span-2">
  </form>
<?php
}

/**
 * Become a Repairer Form
 */
function unity_become_repairer_form()
{
?>
  <iframe title="Become a Repairer" src="https://slantagency.snapforms.com.au/form/mrmlKgJks1" width="100%" height="100%" scrolling="no" style="border: 0px; height: 277px"></iframe>
<?php
}

/**
 * Newsletter Form for Contact Form CTA
 */
function unity_newsletter_form()
{
?>
  <form id="newsletter-form" class="unity-form newsletter-form" method="post" action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>">
    <?php wp_nonce_field('unity_form_submit', 'unity_form_nonce'); ?>
    <input type="hidden" name="action" value="unity_form_submit">
    <input type="hidden" name="form_type" value="newsletter">

    <input type="text"
      name="first_name"
      placeholder="First Name"
      required>

    <input type="text"
      name="last_name"
      placeholder="Last Name"
      required>

    <input type="email"
      name="email"
      placeholder="Email Address"
      required>

    <input type="tel"
      name="phone"
      placeholder="Phone Number">

    <input type="submit"
      value="Subscribe"
      class="col-span-2">
  </form>
<?php
}

// Add placeholder functions for other forms
function unity_book_car_form()
{
  echo '<p>Book a Car form coming soon.</p>';
}

function unity_complaint_form()
{
  echo '<p>Complaint form coming soon.</p>';
}

function unity_job_application_form()
{
  echo '<p>Job Application form coming soon.</p>';
}

// Add to functions.php
/**
 * Handle form submissions via AJAX
 */
function unity_handle_form_submission()
{
  // Verify nonce
  if (!isset($_POST['unity_form_nonce']) || !wp_verify_nonce($_POST['unity_form_nonce'], 'unity_form_submit')) {
    wp_die('Security check failed');
  }

  $form_type = sanitize_text_field($_POST['form_type']);
  $response = array('success' => false, 'message' => '');

  // Process based on form type
  switch ($form_type) {
    case 'general_contact':
      $response = unity_process_general_contact();
      break;

    case 'become_repairer':
      //$response = unity_process_become_repairer();
      break;

    case 'newsletter':
      //$response = unity_process_newsletter();
      break;

    default:
      $response['message'] = 'Invalid form type';
  }

  wp_send_json($response);
}
add_action('wp_ajax_unity_form_submit', 'unity_handle_form_submission');
add_action('wp_ajax_nopriv_unity_form_submit', 'unity_handle_form_submission');

/**
 * Process general contact form
 */
function unity_process_general_contact()
{
  // Sanitize form data
  $first_name = sanitize_text_field($_POST['first_name']);
  $last_name = sanitize_text_field($_POST['last_name']);
  $email = sanitize_email($_POST['email']);
  $phone = sanitize_text_field($_POST['phone']);
  $company = sanitize_text_field($_POST['company']);
  $state = sanitize_text_field($_POST['state']);
  $message = sanitize_textarea_field($_POST['message']);

  // Validate required fields
  if (empty($first_name) || empty($last_name) || empty($email)) {
    return array('success' => false, 'message' => 'Please fill in all required fields.');
  }

  // Compose email
  $to = get_option('admin_email');
  $subject = 'New Contact Form Submission - Unity Claims';
  $body = "New contact form submission:\n\n";
  $body .= "Name: $first_name $last_name\n";
  $body .= "Email: $email\n";
  $body .= "Phone: $phone\n";
  $body .= "Company: $company\n";
  $body .= "State: $state\n";
  $body .= "Message:\n$message\n";

  $headers = array('Content-Type: text/plain; charset=UTF-8');

  // Send email
  $sent = wp_mail($to, $subject, $body, $headers);

  if ($sent) {
    return array('success' => true, 'message' => 'Thank you for your message. We will get back to you soon.');
  } else {
    return array('success' => false, 'message' => 'There was an error sending your message. Please try again.');
  }
}

/**
 * Render an image button card
 */
function unity_image_button_card($card_data)
{
  $link = $card_data['card_link'] ?? null;
  $image = $card_data['image'] ?? null;
  $heading = $card_data['heading'] ?? '';

  // Skip if no link
  if (!$link || !$link['url']) return;
?>

  <a href="<?php echo esc_url($link['url']); ?>"
    class="card"
    target="<?php echo esc_attr($link['target'] ?: '_self'); ?>">

    <div class="backgroundImage">
      <?php if ($image && !empty($image['url'])): ?>
        <img src="<?php echo esc_url($image['url']); ?>"
          alt="<?php echo esc_attr($image['alt'] ?: ''); ?>">
      <?php else: ?>
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/pageImages/fallback.svg"
          alt="Fallback">
      <?php endif; ?>
    </div>

    <?php if ($heading): ?>
      <div class="headingWrapper">
        <h3><?php echo esc_html($heading); ?></h3>
      </div>
    <?php endif; ?>

    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/arrow-right-gold.svg"
      alt=""
      class="arrowIcon">
  </a>
<?php
}

/**
 * Render an image and text card
 */
function unity_image_text_card($card_data)
{
  $heading = $card_data['heading'] ?? '';
  $text = $card_data['text'] ?? '';
  $card_link = $card_data['card_link'] ?? null;
  $image = $card_data['image'] ?? null;
?>

  <div class="card">
    <?php if ($image && !empty($image['url'])): ?>
      <div class="card-thumbnail">
        <img src="<?php echo esc_url($image['url']); ?>"
          alt="<?php echo esc_attr($image['alt'] ?: $heading); ?>">
      </div>
    <?php endif; ?>

    <div class="card-body">
      <?php if ($heading): ?>
        <h4><?php echo esc_html($heading); ?></h4>
      <?php endif; ?>

      <?php if ($text): ?>
        <div class="card-text"><?php echo wp_kses_post($text); ?></div>
      <?php endif; ?>
    </div>

    <div class="card-footer">
      <?php if ($card_link && !empty($card_link['url'])): ?>
        <div class="card-footer-link">
          <a href="<?php echo esc_url($card_link['url']); ?>"
            target="<?php echo esc_attr($card_link['target'] ?: '_self'); ?>">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/arrow-right-gold.svg" alt="">
          </a>
        </div>
      <?php endif; ?>
    </div>
  </div>
<?php
}
/**
 * Render video embed from URL
 */
// Simpler version using WordPress oEmbed
function unity_render_video($video_url, $video_title = '')
{
  if (empty($video_url)) {
    echo '<p>No video URL provided</p>';
    return;
  }

  // Use WordPress oEmbed
  $embed = wp_oembed_get($video_url, array(
    'width' => 1920,
    'height' => 1080
  ));

  if ($embed) {
    echo $embed;
  } else {
    echo '<p>Unable to embed video. Please check the URL.</p>';
  }
}

/**
 * Convert date to readable format
 * Matches the React component's date formatting
 */
function unity_convert_to_readable_date($date_string)
{
  $date = new DateTime($date_string);
  return $date->format('F j, Y'); // e.g., "March 21, 2024"
}

/**
 * Convert content to excerpt
 * Strips HTML and limits to 150 characters
 */
function unity_convert_to_excerpt($content, $length = 150)
{
  // Strip all HTML tags
  $text = strip_tags($content);

  // Remove shortcodes
  $text = strip_shortcodes($text);

  // Trim whitespace
  $text = trim($text);

  // Limit length
  if (strlen($text) > $length) {
    $text = substr($text, 0, $length);

    // Find last space to avoid cutting words
    $last_space = strrpos($text, ' ');
    if ($last_space !== false) {
      $text = substr($text, 0, $last_space);
    }

    $text .= '...';
  }

  return $text;
}

/**
 * Render breadcrumb navigation
 */
function unity_render_breadcrumbs($breadcrumbs = array(), $show_home = true)
{
?>
  <div class="breadcrumbs">
    <?php if ($show_home): ?>
      <span>
        <a href="<?php echo esc_url(home_url('/')); ?>">Home</a> /
      </span>
    <?php endif; ?>

    <?php if (!empty($breadcrumbs)): ?>
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
    <?php endif; ?>
  </div>
<?php
}
