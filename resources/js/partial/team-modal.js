(function ($) {
  "use strict";

  $(document).ready(function () {
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
})(jQuery);
