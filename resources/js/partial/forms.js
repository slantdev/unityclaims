// assets/js/forms.js
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
