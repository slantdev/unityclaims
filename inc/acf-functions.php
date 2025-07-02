<?php

function register_acf_options_pages()
{

	// check function exists
	if (! function_exists('acf_add_options_page')) {
		return;
	}

	acf_add_options_page(array(
		'page_title' 	=> 'General Information',
		'menu_title'	=> 'General Information',
		'menu_slug' 	=> 'general-information',
		'capability'	=> 'edit_posts',
		'redirect'		=> false,
		'show_in_graphql' => true,
	));
}

add_action('acf/init', 'register_acf_options_pages');
