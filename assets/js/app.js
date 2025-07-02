/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/css/app.css":
/*!*******************************!*\
  !*** ./resources/css/app.css ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/css/editor-style.css":
/*!****************************************!*\
  !*** ./resources/css/editor-style.css ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/***/ (() => {

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
    var $carousel = $(this);
    var $scrollContainer = $carousel.find(".imageButtonCardsCarousel-carousel");
    var $prevBtn = $carousel.find(".carousel-control-prev");
    var $nextBtn = $carousel.find(".carousel-control-next");
    var scrollDistance = 300; // pixels to scroll per click

    // Handle previous button click
    $prevBtn.on("click", function () {
      $scrollContainer[0].scrollBy({
        left: -scrollDistance,
        behavior: "smooth"
      });
    });

    // Handle next button click
    $nextBtn.on("click", function () {
      $scrollContainer[0].scrollBy({
        left: scrollDistance,
        behavior: "smooth"
      });
    });

    // Optional: Update button states based on scroll position
    function updateButtonStates() {
      var scrollLeft = $scrollContainer.scrollLeft();
      var scrollWidth = $scrollContainer[0].scrollWidth;
      var clientWidth = $scrollContainer[0].clientWidth;

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

  var $dropdown = $("#serviceSelect");
  var $dropdownMenu = $dropdown.siblings(".dropdown-menu");
  var $dropdownText = $dropdown.find(".dropdown-item");
  var $submitButton = $("#serviceNavigationSubmit");
  var selectedItem = {
    url: "",
    text: "Select a service",
    target: "_self"
  };

  // Toggle dropdown menu
  $dropdown.on("click", function (e) {
    e.preventDefault();
    e.stopPropagation();
    var isExpanded = $(this).attr("aria-expanded") === "true";
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
      target: $(this).data("target") || "_self"
    };

    // Update dropdown display
    $dropdownText.text(selectedItem.text);

    // Enable submit button
    $submitButton.attr("href", selectedItem.url).attr("target", selectedItem.target).removeClass("opacity-50 pointer-events-none");

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
    var $menuItems = $dropdownMenu.find(".dropdown-menu-item");
    var currentIndex = $menuItems.filter(".focused").index();
    switch (e.keyCode) {
      case 40:
        // Down arrow
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
      case 38:
        // Up arrow
        e.preventDefault();
        if ($dropdownMenu.is(":visible")) {
          if (currentIndex > 0) {
            currentIndex--;
          } else {
            currentIndex = $menuItems.length - 1;
          }
          $menuItems.removeClass("focused").eq(currentIndex).addClass("focused");
        }
        break;
      case 13: // Enter key
      case 32:
        // Space key
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
    var $form = $(this);
    var $submitBtn = $form.find('button[type="submit"]');
    var originalText = $submitBtn.text();

    // Disable submit button
    $submitBtn.prop("disabled", true).text("Sending...");

    // Submit form via AJAX
    $.ajax({
      url: $form.attr("action"),
      type: "POST",
      data: $form.serialize(),
      success: function success(response) {
        if (response.success) {
          // Show success message
          $form.html('<div class="form-success">' + response.message + "</div>");
        } else {
          // Show error message
          alert(response.message);
          $submitBtn.prop("disabled", false).text(originalText);
        }
      },
      error: function error() {
        alert("An error occurred. Please try again.");
        $submitBtn.prop("disabled", false).text(originalText);
      }
    });
  });
});

// resources/js/job-search.js
jQuery(document).ready(function ($) {
  // Check if we're on a page with job listing
  if (!window.jobListData || !$("#job-list").length) {
    return;
  }
  var jobs = window.jobListData;
  var $jobList = $("#job-list");
  var $locationFilter = $("#location-filter");
  var $searchInput = $("#job-search");
  var errorMessage = "No jobs match your search criteria.";
  var displayedJobs = jobs;

  // Render jobs
  function renderJobs(jobsToRender) {
    $jobList.empty();
    if (jobsToRender.length === 0) {
      $jobList.html("<div class=\"errorMessage\">".concat(errorMessage, "</div>"));
      return;
    }
    jobsToRender.forEach(function (job) {
      var jobHtml = "\n                <a href=\"".concat(job.url, "\" class=\"job\" target=\"_blank\">\n                    <div class=\"job-heading\">\n                        <div class=\"job-heading-title\">").concat(job.title, "</div>\n                        <div class=\"job-heading-location\">").concat(job.location, "</div>\n                    </div>\n                    <img src=\"").concat(theme_vars.template_directory, "/assets/images/icons/chevron-right-gold.svg\" alt=\"\">\n                </a>\n            ");
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
    var search = searchText.toLowerCase();
    return jobArray.filter(function (job) {
      return job.title.toLowerCase().indexOf(search) !== -1;
    });
  }

  // Apply all filters
  function filterJobs() {
    var filteredJobs = jobs;

    // Filter by location
    var selectedLocation = $locationFilter.val();
    filteredJobs = filterByLocation(filteredJobs, selectedLocation);

    // Filter by search text
    var searchText = $searchInput.val();
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
  var $modal = $("#teamModal");
  var $modalOverlay = $modal.find(".modal-overlay");
  var $modalImage = $modal.find(".teamModal-image img");
  var $modalName = $modal.find(".name");
  var $modalPosition = $modal.find(".position");
  var $modalDescription = $modal.find(".description");
  var $closeButton = $modal.find(".teamModal-body-closeButton");

  // Open modal when team member card is clicked
  $(".teamList .card").on("click", function () {
    var $card = $(this);

    // Get member data from data attributes
    var memberData = {
      name: $card.data("member-name"),
      position: $card.data("member-position"),
      description: $card.data("member-description"),
      photo: $card.data("member-photo"),
      email: $card.data("member-email"),
      phone: $card.data("member-phone"),
      linkedin: $card.data("member-linkedin")
    };

    // Populate modal with member data
    $modalName.text(memberData.name);
    $modalPosition.text(memberData.position);
    $modalDescription.html(memberData.description);
    if (memberData.photo) {
      $modalImage.attr("src", memberData.photo).attr("alt", memberData.name);
    } else {
      $modalImage.attr("src", theme_vars.template_directory + "/assets/images/pageImages/fallback.svg").attr("alt", memberData.name);
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

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/assets/js/app": 0,
/******/ 			"assets/css/app": 0,
/******/ 			"assets/css/editor-style": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunkunityclaims"] = self["webpackChunkunityclaims"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["assets/css/app","assets/css/editor-style"], () => (__webpack_require__("./resources/js/app.js")))
/******/ 	__webpack_require__.O(undefined, ["assets/css/app","assets/css/editor-style"], () => (__webpack_require__("./resources/css/app.css")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["assets/css/app","assets/css/editor-style"], () => (__webpack_require__("./resources/css/editor-style.css")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;