// assets/js/header.js
jQuery(document).ready(function ($) {
  "use strict";

  // Mobile menu functionality
  $("#mobile-menu-toggle").on("click", function () {
    $("#mobile-menu").addClass("showMenu");
    $("body").css("overflow", "hidden");
  });

  $("#mobile-menu-close").on("click", function () {
    $("#mobile-menu").removeClass("showMenu");
    $("body").css("overflow", "auto");
  });

  // Initialize Splide sliders if they exist
  // if (typeof Splide !== "undefined" && $(".splide").length > 0) {
  //   $(".splide").each(function () {
  //     const options = $(this).data("splide");
  //     new Splide(this, options).mount();
  //   });
  // }

  // Image Button Cards Carousel functionality
  $(".imageButtonCardsCarousel").each(function () {
    const $carousel = $(this);
    const $scrollContainer = $carousel.find(
      ".imageButtonCardsCarousel-carousel"
    );
    const $prevBtn = $carousel.find(".carousel-control-prev");
    const $nextBtn = $carousel.find(".carousel-control-next");

    const scrollDistance = 300; // pixels to scroll per click

    // Handle previous button click
    $prevBtn.on("click", function () {
      $scrollContainer[0].scrollBy({
        left: -scrollDistance,
        behavior: "smooth",
      });
    });

    // Handle next button click
    $nextBtn.on("click", function () {
      $scrollContainer[0].scrollBy({
        left: scrollDistance,
        behavior: "smooth",
      });
    });

    // Optional: Update button states based on scroll position
    function updateButtonStates() {
      const scrollLeft = $scrollContainer.scrollLeft();
      const scrollWidth = $scrollContainer[0].scrollWidth;
      const clientWidth = $scrollContainer[0].clientWidth;

      // Disable/enable previous button
      if (scrollLeft <= 0) {
        $prevBtn.prop("disabled", true).addClass("opacity-50");
      } else {
        $prevBtn.prop("disabled", false).removeClass("opacity-50");
      }

      // Disable/enable next button
      if (scrollLeft + clientWidth >= scrollWidth - 1) {
        $nextBtn.prop("disabled", true).addClass("opacity-50");
      } else {
        $nextBtn.prop("disabled", false).removeClass("opacity-50");
      }
    }

    // Update button states on scroll
    $scrollContainer.on("scroll", updateButtonStates);

    // Initial button state
    updateButtonStates();
  });
});
