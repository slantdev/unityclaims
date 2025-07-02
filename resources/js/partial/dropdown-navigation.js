// Add to assets/js/header.js or create dropdown-navigation.js
(function ($) {
  "use strict";

  $(document).ready(function () {
    const $dropdown = $("#serviceSelect");
    const $dropdownMenu = $dropdown.siblings(".dropdown-menu");
    const $dropdownText = $dropdown.find(".dropdown-item");
    const $submitButton = $("#serviceNavigationSubmit");

    let selectedItem = {
      url: "",
      text: "Select a service",
      target: "_self",
    };

    // Toggle dropdown menu
    $dropdown.on("click", function (e) {
      e.preventDefault();
      e.stopPropagation();

      const isExpanded = $(this).attr("aria-expanded") === "true";

      if (isExpanded) {
        closeDropdown();
      } else {
        openDropdown();
      }
    });

    // Handle menu item selection
    $(".dropdown-menu-item").on("click", function (e) {
      e.preventDefault();
      e.stopPropagation();

      // Update selected item
      selectedItem = {
        url: $(this).data("url"),
        text: $(this).text().trim(),
        target: $(this).data("target") || "_self",
      };

      // Update dropdown display
      $dropdownText.text(selectedItem.text);

      // Enable submit button
      $submitButton
        .attr("href", selectedItem.url)
        .attr("target", selectedItem.target)
        .removeClass("opacity-50 pointer-events-none");

      // Close dropdown
      closeDropdown();
    });

    // Close dropdown when clicking outside
    $(document).on("click", function (e) {
      if (!$(e.target).closest(".dropdown-wrapper").length) {
        closeDropdown();
      }
    });

    // Close dropdown on ESC key
    $(document).on("keydown", function (e) {
      if (e.keyCode === 27 && $dropdown.attr("aria-expanded") === "true") {
        closeDropdown();
      }
    });

    // Handle keyboard navigation
    $dropdown.on("keydown", function (e) {
      const $menuItems = $dropdownMenu.find(".dropdown-menu-item");
      let currentIndex = $menuItems.filter(".focused").index();

      switch (e.keyCode) {
        case 40: // Down arrow
          e.preventDefault();
          if (!$dropdownMenu.is(":visible")) {
            openDropdown();
            currentIndex = -1;
          }
          if (currentIndex < $menuItems.length - 1) {
            currentIndex++;
          } else {
            currentIndex = 0;
          }
          $menuItems
            .removeClass("focused")
            .eq(currentIndex)
            .addClass("focused");
          break;

        case 38: // Up arrow
          e.preventDefault();
          if ($dropdownMenu.is(":visible")) {
            if (currentIndex > 0) {
              currentIndex--;
            } else {
              currentIndex = $menuItems.length - 1;
            }
            $menuItems
              .removeClass("focused")
              .eq(currentIndex)
              .addClass("focused");
          }
          break;

        case 13: // Enter key
        case 32: // Space key
          e.preventDefault();
          if ($dropdownMenu.is(":visible") && currentIndex >= 0) {
            $menuItems.eq(currentIndex).click();
          } else if (!$dropdownMenu.is(":visible")) {
            openDropdown();
          }
          break;
      }
    });

    // Add focused class on hover for consistency
    $(".dropdown-menu-item").on("mouseenter", function () {
      $(".dropdown-menu-item").removeClass("focused");
      $(this).addClass("focused");
    });

    function openDropdown() {
      $dropdown.attr("aria-expanded", "true");
      $dropdownMenu.slideDown(300);
    }

    function closeDropdown() {
      $dropdown.attr("aria-expanded", "false");
      $dropdownMenu.slideUp(300);
      $(".dropdown-menu-item").removeClass("focused");
    }
  });
})(jQuery);
