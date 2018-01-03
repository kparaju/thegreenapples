<?php  

register_post_type('crb_location', array(
	'labels' => array(
		'name'	 => __('Locations', 'crb'),
		'singular_name' => __('Location', 'crb'),
		'add_new' => __('Add New', 'crb'),
		'add_new_item' => __('Add new Location', 'crb'),
		'view_item' => __('View Location', 'crb'),
		'edit_item' => __('Edit Location', 'crb'),
		'new_item' => __('New Location', 'crb'),
		'view_item' => __('View Location', 'crb'),
		'search_items' => __('Search Locations', 'crb'),
		'not_found' =>  __('No Locations found', 'crb'),
		'not_found_in_trash' => __('No Locations found in trash', 'crb'),
	),
	'public' => true,
	'exclude_from_search' => false,
	'show_ui' => true,
	'menu_icon' => 'dashicons-location',
	'capability_type' => 'post',
	'hierarchical' => true,
	'_edit_link' =>  'post.php?post=%d',
	'rewrite' => array(
		'slug' => 'location',
		'with_front' => false,
	),
	'query_var' => true,
	'supports' => array('title', 'editor', 'page-attributes'),
));