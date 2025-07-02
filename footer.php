<?php

/**
 * The template for displaying the footer
 */

// Get footer data from ACF General Information options page
$footer_text = get_field('footer_text', 'option');
$phone_number = get_field('phone_number', 'option');
$email = get_field('email', 'option');
$footer_menu = get_field('footer_menu', 'option');
$copyright_links = get_field('copyright_links', 'option');

// Static data
$contact_address = 'Unity Claims Management<br />U2/8 Gibberd Road,<br />Balcatta, WA, 6021,<br />Australia';
$current_year = date('Y');
?>

<footer>
  <section class="footer-widgets">
    <div class="footer-widgets-widget">
      <div class="footer-widgets-widget-content">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logos/unityClaims-vertical.svg"
          alt="Unity Claims Logo"
          class="mb-4 xl:mb-8" />
        <?php if ($footer_text): ?>
          <div class="textWrapper">
            <?php echo wp_kses_post($footer_text); ?>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <div class="footer-widgets-widget">
      <div class="headingWrapper">
        <h4>Find Us</h4>
      </div>
      <address>
        <div class="textWrapper">
          <?php echo wp_kses_post($contact_address); ?>
        </div>
      </address>

      <?php if ($email): ?>
        <address>
          <strong>Email: </strong>
          <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
        </address>
      <?php endif; ?>

      <?php if ($phone_number): ?>
        <address>
          <strong>Tel: </strong>
          <?php echo esc_html($phone_number); ?>
        </address>
      <?php endif; ?>
    </div>

    <div class="footer-widgets-widget">
      <div class="headingWrapper">
        <h4>Quicklink</h4>
      </div>
      <nav>
        <?php if ($footer_menu && !empty($footer_menu)): ?>
          <ul>
            <?php foreach ($footer_menu as $menu_item): ?>
              <?php
              $link = $menu_item['menu_item'];
              if (!$link || !$link['url']) continue;
              ?>
              <li>
                <a href="<?php echo esc_url($link['url']); ?>"
                  target="<?php echo esc_attr($link['target'] ?: '_self'); ?>">
                  <span class="linkText"><?php echo esc_html($link['title']); ?></span>
                  <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/chevron-circle-right.svg" alt="chevron" />
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php else: ?>
          <li class="errorMessage">No Quick links assigned</li>
        <?php endif; ?>
      </nav>
    </div>
  </section>

  <section class="copyright">
    <div class="copyright-container">
      <div class="copyright-textContent">
        <div class="text">© Copyright - Unity Claims. <?php echo $current_year; ?></div>
        <div class="text">All rights reserved.</div>
      </div>
      <div class="copyright-links">
        <?php if ($copyright_links && !empty($copyright_links)): ?>
          <ul>
            <?php foreach ($copyright_links as $copyright_link): ?>
              <?php
              $link = $copyright_link['menu_item'];
              if (!$link || !$link['url']) continue;
              ?>
              <li>
                <a href="<?php echo esc_url($link['url']); ?>"
                  target="<?php echo esc_attr($link['target'] ?: '_self'); ?>">
                  <div class="textWrapper">
                    <?php echo esc_html($link['title']); ?>
                  </div>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php else: ?>
          <li class="errorMessage">No copyright links assigned</li>
        <?php endif; ?>
      </div>
    </div>
  </section>
</footer>

<?php wp_footer(); ?>
</body>

</html>