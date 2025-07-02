<?php

// Enqueue scripts with localized data
function unity_enqueue_scripts()
{
  $theme = wp_get_theme();
  // Get menu data for JavaScript
  $menu_items = get_field('menu_items', 'option');
  $processed_menu_items = array();

  if ($menu_items) {
    foreach ($menu_items as $item) {
      $menu_data = array(
        'url' => $item['menu_item']['url'],
        'title' => $item['menu_item']['title'],
        'hasMegaMenu' => $item['has_megamenu'],
      );

      if ($item['has_megamenu'] && !empty($item['megamenu_items'])) {
        $megamenu = $item['megamenu_items'];
        $menu_data['megaMenuItems'] = array(
          'heading' => $megamenu['heading'],
          'bodyText' => $megamenu['body_text'],
          'imageSrc' => $megamenu['megamenu_image']['url'] ?? '',
          'menuItems' => array()
        );

        if (!empty($megamenu['menu_items'])) {
          foreach ($megamenu['menu_items'] as $submenu) {
            $menu_data['megaMenuItems']['menuItems'][] = array(
              'url' => $submenu['menu_item']['url'],
              'title' => $submenu['menu_item']['title']
            );
          }
        }
      }

      $processed_menu_items[] = $menu_data;
    }
  }

  // Enqueue styles
  wp_enqueue_style('splide', 'https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css');
  wp_enqueue_style('unity', theme_asset('assets/css/app.css'), array(), $theme->get('Version'));

  // Enqueue scripts
  wp_enqueue_script('splide', 'https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js', array(), '4.1.4', true);
  wp_enqueue_script('unity', theme_asset('assets/js/app.js'), array('jquery'), $theme->get('Version'), true);

  // Localize script
  wp_localize_script('unity-header', 'theme_vars', array(
    'template_directory' => get_template_directory_uri(),
    'menu_items' => $processed_menu_items
  ));
}
add_action('wp_enqueue_scripts', 'unity_enqueue_scripts');

/**
 * Get asset path.
 *
 * @param string  $path Path to asset.
 *
 * @return string
 */
function theme_asset($path)
{
  if (wp_get_environment_type() === 'production') {
    return get_stylesheet_directory_uri() . '/' . $path;
  }

  return add_query_arg('time', time(),  get_stylesheet_directory_uri() . '/' . $path);
}
