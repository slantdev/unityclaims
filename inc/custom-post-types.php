<?php

// Our custom post type function
function create_posttype()
{
  //slug, plural name, single name, graphql plural name, graphql single name
  //createCPT('claims-page', 'Claims Pages', 'Claims Page', 'ClaimsPages', 'ClaimsPage');
  createCPT('claims-services', 'Claims Services', 'Claims Service', 'ClaimsServices', 'ClaimsService');
  createCPT('claims-team', 'Claims Team', 'Claims Team Member', 'ClaimsTeam', 'ClaimsTeamMember');
  createCPT('claims-jobs', 'Claims Jobs', 'Claims Job', 'ClaimsJobs', 'ClaimsJob');
  createCPT('claims-news', 'Claims News', 'Claims News Article', 'ClaimsNews', 'ClaimsNewsArticle', true);
  createCPT('claims-whitepapers', 'Claims White Papers', 'Claims White Papers Article', 'ClaimsWhitePaper', 'ClaimsWhitePaperArticle', true);
}

// Hooking up our function to theme setup
add_action('init', 'create_posttype');

function createCPT($slug, $plural, $single, $gql_plural, $gql_single, $enable_thumbnail = false)
{

  $support = array('title', 'editor');
  if ($enable_thumbnail) array_push($support, 'thumbnail');

  register_post_type(
    $slug,
    // CPT Options
    array(
      'labels' => array(
        'name' => __($plural),
        'singular_name' => __($single)
      ),
      'public' => true,
      'has_archive' => false,
      'rewrite' => array('slug' => $slug),
      'show_in_rest' => true,
      'show_in_graphql' => true,
      'hierarchical' => true,
      'graphql_single_name' => $gql_single,
      'graphql_plural_name' => $gql_plural,
      'supports' => $support,
    ),
  );
}
