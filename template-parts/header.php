<?php
$use_large_header = get_field('use_large_header');
$banner_image = get_field('banner_image') ?? get_stylesheet_directory_uri('/assets/images/banners/banner-home.jpg');
$subheader_leading_text = get_field('subheader_leading_text');
$subheader_text = get_field('subheader_text');
$banner_sliders = get_field('banner_sliders');
$banner_speed = get_field('banner_speed');
$quicklinks = get_field('quicklinks');
$dropdown_navigation = get_field('dropdown_navigation');

?>

<header style="background-image: url('<?php echo $banner_image ?>')" class="header">
  <div class="header-container">

    <!-- <SecondaryHeader /> -->
    <section class="secondaryHeader">
      <ul>
        <li>
          <a href="tel:1800622683" target="_blank" rel="noreferrer"><img src="<?php echo get_stylesheet_directory_uri('/assets/images/icons/phone-alt.svg') ?>" alt="Phone" /></a>
        </li>
        <li>
          <a href="mailto:info@unityclaims.com.au" target="_blank" rel="noreferrer"><img src="<?php echo get_stylesheet_directory_uri('/assets/images/icons/envelope-alt.svg') ?>" alt="Email" /></a>
        </li>
      </ul>
    </section>

    <div class="header-main">

      <!-- Logo -->
      <section class="logoContainer">
        <a href="/">
          <img class="logoImage" src="<?php echo get_stylesheet_directory_uri('/assets/images/logos/unityClaims-white.svg') ?>" alt="Unity Claims" />
        </a>
      </section>

      <!-- <Menu
        activateMegaMenu={activateMegaMenu}
        deactivateMegaMenu={deactivateMegaMenu} 
      /> -->

      <div class="headerMenu">
        <div class="mobileNav">
          <button onClick={openMenu} class="mobileNavButton" type="button">
            <img src="<?php echo get_stylesheet_directory_uri('/assets/images/icons/icon-menu.svg') ?>" alt="Menu" />
          </button>
          <div class={`mobileNavMenu ${mobileNavOpen ? " showMenu" : "" }`}>
            <div class="inner">
              <button
                onClick={closeMenu}
                class="mobileCloseButton"
                type="button">
                <img src="<?php echo get_stylesheet_directory_uri('/assets/images/icons/icon-close.svg') ?>" alt="Close" />
              </button>
              <ul class="mobileNavMenuList">
                <MobileMenuList menuItems={menuItems} />
              </ul>
            </div>
          </div>
        </div>
        <nav class="mainNavigation">
          <ul>
            <MenuList
              menuItems={menuItems}
              activateMegaMenu={props.activateMegaMenu}
              deactivateMegaMenu={props.deactivateMegaMenu} />
          </ul>
        </nav>
      </div>

    </div>
    <!-- <MegaMenu
      megaMenuState={megaMenuState}
      activateMegaMenu={activateMegaMenu}
      deactivateMegaMenu={deactivateMegaMenu} 
    /> -->
  </div>
</header>