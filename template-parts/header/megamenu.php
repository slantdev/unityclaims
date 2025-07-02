<?php

/**
 * Megamenu container - content is populated via JavaScript
 */
?>
<!-- <div class="megaMenu" id="megaMenu"></div> -->

<?php
$menu_items = get_field('menu_items', 'option');

if ($menu_items):
  echo '<div id="megamenu">';
  foreach ($menu_items as $index => $item):
    if ($item['has_megamenu'] && !empty($item['megamenu_items'])):
      $megamenu = $item['megamenu_items'];
?>
      <div class="megaMenu" data-menu-index="<?php echo $index; ?>" style="display: none;">
        <div class="megaMenu-container">
          <div class="megaMenu-column megaMenu-summary">
            <h3><?php echo esc_html($megamenu['heading']); ?></h3>
            <p><?php echo esc_html($megamenu['body_text']); ?></p>
            <a href="<?php echo esc_url($item['menu_item']['url']); ?>" class="btn btn-primary btn-pill">Learn More</a>
          </div>
          <div class="megaMenu-column megaMenu-menu">
            <ul>
              <?php if (!empty($megamenu['menu_items'])): ?>
                <?php foreach ($megamenu['menu_items'] as $submenu): ?>
                  <li>
                    <a href="<?php echo esc_url($submenu['menu_item']['url']); ?>">
                      <span><?php echo esc_html($submenu['menu_item']['title']); ?></span>
                      <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/chevron-right-gold.svg" alt="">
                    </a>
                  </li>
                <?php endforeach; ?>
              <?php endif; ?>
            </ul>
          </div>
          <div class="megaMenu-column megaMenu-image">
            <?php if (!empty($megamenu['megamenu_image'])): ?>
              <div class="imageWrapper">
                <img src="<?php echo esc_url($megamenu['megamenu_image']['url']); ?>" alt="">
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
<?php
    endif;
  endforeach;
  echo '</div>';
endif;
?>