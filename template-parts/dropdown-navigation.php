<?php

/**
 * Template part for displaying dropdown navigation
 * // template-parts/dropdown-navigation.php
 * 
 * @param array $args['dropdown_navigation'] Array of navigation items from ACF
 */

$dropdown_navigation = $args['dropdown_navigation'] ?? array();

// Don't render if no navigation items
if (empty($dropdown_navigation)) return;
?>

<section class="serviceNavigation">
  <div class="serviceNavigation-container">
    <label for="serviceSelect" class="text-white">I'm looking for</label>

    <div class="dropdown-wrapper relative">
      <button
        id="serviceSelect"
        class="dropdown"
        type="button"
        aria-haspopup="true"
        aria-expanded="false">
        <div class="dropdown-item active">Select a service</div>
      </button>

      <div class="dropdown-menu" style="display: none;">
        <?php foreach ($dropdown_navigation as $index => $item): ?>
          <?php
          $link = $item['link'];
          if (empty($link['url']) || empty($link['title'])) continue;
          ?>
          <button
            class="dropdown-menu-item"
            type="button"
            data-url="<?php echo esc_attr($link['url']); ?>"
            data-target="<?php echo esc_attr($link['target'] ?: '_self'); ?>">
            <?php echo esc_html($link['title']); ?>
          </button>
        <?php endforeach; ?>
      </div>
    </div>

    <a
      href="#"
      class="serviceNavigation-submit opacity-50 pointer-events-none"
      id="serviceNavigationSubmit"
      target="_self">
      Go
    </a>
  </div>
</section>