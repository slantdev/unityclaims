// assets/js/job-search.js
(function ($) {
  "use strict";

  $(document).ready(function () {
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
})(jQuery);
