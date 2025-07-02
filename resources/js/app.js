// resources/js/header.js
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

//resources/js/dropdown-navigation.js
jQuery(document).ready(function ($) {
  "use strict";

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
        $menuItems.removeClass("focused").eq(currentIndex).addClass("focused");
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

// resources/js/forms.js
jQuery(document).ready(function ($) {
  $(".unity-form").on("submit", function (e) {
    e.preventDefault();

    const $form = $(this);
    const $submitBtn = $form.find('button[type="submit"]');
    const originalText = $submitBtn.text();

    // Disable submit button
    $submitBtn.prop("disabled", true).text("Sending...");

    // Submit form via AJAX
    $.ajax({
      url: $form.attr("action"),
      type: "POST",
      data: $form.serialize(),
      success: function (response) {
        if (response.success) {
          // Show success message
          $form.html(
            '<div class="form-success">' + response.message + "</div>"
          );
        } else {
          // Show error message
          alert(response.message);
          $submitBtn.prop("disabled", false).text(originalText);
        }
      },
      error: function () {
        alert("An error occurred. Please try again.");
        $submitBtn.prop("disabled", false).text(originalText);
      },
    });
  });
});

// resources/js/job-search.js
jQuery(document).ready(function ($) {
  // Check if we're on a page with job listing
  if (!window.jobListData || !$("#job-list").length) {
    return;
  }

  const jobs = window.jobListData;
  const $jobList = $("#job-list");
  const $locationFilter = $("#location-filter");
  const $searchInput = $("#job-search");
  const errorMessage = "No jobs match your search criteria.";

  let displayedJobs = jobs;

  // Render jobs
  function renderJobs(jobsToRender) {
    $jobList.empty();

    if (jobsToRender.length === 0) {
      $jobList.html(`<div class="errorMessage">${errorMessage}</div>`);
      return;
    }

    jobsToRender.forEach(function (job) {
      const jobHtml = `
                <a href="${job.url}" class="job" target="_blank">
                    <div class="job-heading">
                        <div class="job-heading-title">${job.title}</div>
                        <div class="job-heading-location">${job.location}</div>
                    </div>
                    <img src="${theme_vars.template_directory}/assets/images/icons/chevron-right-gold.svg" alt="">
                </a>
            `;
      $jobList.append(jobHtml);
    });
  }

  // Filter by location
  function filterByLocation(jobArray, location) {
    if (!location) return jobArray;

    return jobArray.filter(function (job) {
      return job.location === location;
    });
  }

  // Filter by title
  function filterByTitle(jobArray, searchText) {
    if (!searchText) return jobArray;

    const search = searchText.toLowerCase();
    return jobArray.filter(function (job) {
      return job.title.toLowerCase().indexOf(search) !== -1;
    });
  }

  // Apply all filters
  function filterJobs() {
    let filteredJobs = jobs;

    // Filter by location
    const selectedLocation = $locationFilter.val();
    filteredJobs = filterByLocation(filteredJobs, selectedLocation);

    // Filter by search text
    const searchText = $searchInput.val();
    filteredJobs = filterByTitle(filteredJobs, searchText);

    displayedJobs = filteredJobs;
    renderJobs(displayedJobs);
  }

  // Event listeners
  $locationFilter.on("change", filterJobs);
  $searchInput.on("input", filterJobs);

  // Initial render
  renderJobs(jobs);
});

// resources/js/team-modal.js
jQuery(document).ready(function ($) {
  const $modal = $("#teamModal");
  const $modalOverlay = $modal.find(".modal-overlay");
  const $modalImage = $modal.find(".teamModal-image img");
  const $modalName = $modal.find(".name");
  const $modalPosition = $modal.find(".position");
  const $modalDescription = $modal.find(".description");
  const $closeButton = $modal.find(".teamModal-body-closeButton");

  // Open modal when team member card is clicked
  $(".teamList .card").on("click", function () {
    const $card = $(this);

    // Get member data from data attributes
    const memberData = {
      name: $card.data("member-name"),
      position: $card.data("member-position"),
      description: $card.data("member-description"),
      photo: $card.data("member-photo"),
      email: $card.data("member-email"),
      phone: $card.data("member-phone"),
      linkedin: $card.data("member-linkedin"),
    };

    // Populate modal with member data
    $modalName.text(memberData.name);
    $modalPosition.text(memberData.position);
    $modalDescription.html(memberData.description);

    if (memberData.photo) {
      $modalImage.attr("src", memberData.photo).attr("alt", memberData.name);
    } else {
      $modalImage
        .attr(
          "src",
          theme_vars.template_directory +
            "/assets/images/pageImages/fallback.svg"
        )
        .attr("alt", memberData.name);
    }

    // Show modal
    $modal.fadeIn(300);
    $("body").css("overflow", "hidden");
  });

  // Close modal functions
  function closeModal() {
    $modal.fadeOut(300);
    $("body").css("overflow", "auto");
  }

  // Close modal events
  $closeButton.on("click", closeModal);
  $modalOverlay.on("click", closeModal);

  // Close on ESC key
  $(document).on("keydown", function (e) {
    if (e.keyCode === 27 && $modal.is(":visible")) {
      closeModal();
    }
  });
});
