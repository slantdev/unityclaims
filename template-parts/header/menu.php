<?php
// Get menu items from ACF General Information options page
$menu_items = get_field('menu_items', 'option');
?>

<div class="headerMenu">
  <!-- Mobile Navigation -->
  <div class="mobileNav">
    <button class="mobileNavButton" type="button" id="mobile-menu-toggle">
      <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/icon-menu.svg" alt="Menu" />
    </button>
    <div class="mobileNavMenu" id="mobile-menu">
      <div class="inner">
        <button class="mobileCloseButton" type="button" id="mobile-menu-close">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/icon-close.svg" alt="Close" />
        </button>
        <ul class="mobileNavMenuList">
          <?php if ($menu_items): ?>
            <?php foreach ($menu_items as $item): ?>
              <li>
                <a href="<?php echo esc_url($item['menu_item']['url']); ?>"
                  target="<?php echo esc_attr($item['menu_item']['target'] ?: '_self'); ?>">
                  <?php echo esc_html($item['menu_item']['title']); ?>
                </a>
              </li>
            <?php endforeach; ?>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </div>

  <!-- Desktop Navigation -->
  <nav class="mainNavigation">
    <ul>
      <?php if ($menu_items): ?>
        <?php foreach ($menu_items as $index => $item): ?>
          <li <?php if ($item['has_megamenu']): ?>
            class="menu-item-has-megamenu"
            data-menu-index="<?php echo $index; ?>"
            <?php endif; ?>>
            <a href="<?php echo esc_url($item['menu_item']['url']); ?>"
              target="<?php echo esc_attr($item['menu_item']['target'] ?: '_self'); ?>">
              <?php echo esc_html($item['menu_item']['title']); ?>
            </a>

            <?php
            // Include megamenu directly after the menu item
            if ($item['has_megamenu'] && !empty($item['megamenu_items'])):
              $megamenu = $item['megamenu_items'];
            ?>
              <div class="megaMenu" data-menu-index="<?php echo $index; ?>">
                <div class="megaMenu-container">
                  <div class="megaMenu-column megaMenu-summary">
                    <div class="headingWrapper">
                      <h2><?php echo esc_html($megamenu['heading']); ?></h2>
                    </div>
                    <div class="textWrapper"><?php echo esc_html($megamenu['body_text']); ?></div>
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
            <?php endif; ?>
          </li>
        <?php endforeach; ?>
      <?php endif; ?>
    </ul>
  </nav>
</div>