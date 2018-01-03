<?php
define('CRB_THEME_DIR', dirname(__FILE__) . DIRECTORY_SEPARATOR);

# Enqueue JS and CSS assets on the front-end
add_action('wp_enqueue_scripts', 'crb_wp_enqueue_scripts');
function crb_wp_enqueue_scripts() {
	$template_dir = get_template_directory_uri();

	# Enqueue jQuery
	wp_enqueue_script('jquery');

	# Enqueue Custom JS files
	# @crb_enqueue_script attributes -- id, location, dependencies, in_footer = false
	crb_enqueue_script('theme-functions', $template_dir . '/js/functions.js', array('jquery'));

	# Enqueue Custom CSS files
	# @crb_enqueue_style attributes -- id, location, dependencies, media = all
	crb_enqueue_style('theme-styles', $template_dir . '/style.css');

	# Enqueue Comments JS file
	if (is_singular()) {
		wp_enqueue_script('comment-reply');
	}

	if (isset($_GET['location_id'])){
		$location_id = $_GET['location_id'];
	} else {
		$location_id = '';
	}
	$global_js = array(
		'ajax_url' => admin_url('admin-ajax.php'),
		'markers' => array(
			array(
				'lat' => '1',
				'lng' => '1',
				'title' => '1',
			),
			array(
				'lat' => '1',
				'lng' => '1',
				'title' => '1',
			)
		),
		'location_id' => $location_id,
	);

	wp_localize_script('theme-functions', 'crb_global', $global_js);
}

# Enqueue JS and CSS assets on admin pages
add_action('admin_enqueue_scripts', 'crb_admin_enqueue_scripts');
function crb_admin_enqueue_scripts() {
	$template_dir = get_template_directory_uri();

	# Enqueue Scripts
	# @crb_enqueue_script attributes -- id, location, dependencies, in_footer = false
	# crb_enqueue_script('theme-admin-functions', $template_dir . '/js/admin-functions.js', array('jquery'));
	
	# Enqueue Styles
	# @crb_enqueue_style attributes -- id, location, dependencies, media = all
	# crb_enqueue_style('theme-admin-styles', $template_dir . '/css/admin-style.css');
}

# Attach Custom Post Types and Custom Taxonomies
add_action('init', 'crb_attach_post_types_and_taxonomies', 0);
function crb_attach_post_types_and_taxonomies() {
	# Attach Custom Post Types
	include_once(CRB_THEME_DIR . 'options/post-types.php');

	# Attach Custom Taxonomies
	include_once(CRB_THEME_DIR . 'options/taxonomies.php');
}

add_action('after_setup_theme', 'crb_setup_theme');

# To override theme setup process in a child theme, add your own crb_setup_theme() to your child theme's
# functions.php file.
if (!function_exists('crb_setup_theme')) {
	function crb_setup_theme() {
		# Make this theme available for translation.
		load_theme_textdomain( 'crb', get_template_directory() . '/languages' );

		# Common libraries
		include_once(CRB_THEME_DIR . 'lib/common.php');
		include_once(CRB_THEME_DIR . 'lib/carbon-fields/carbon-fields.php');
		include_once(CRB_THEME_DIR . 'lib/admin-column-manager/carbon-admin-columns-manager.php');

		# Additional libraries and includes
		include_once(CRB_THEME_DIR . 'includes/comments.php');
		include_once(CRB_THEME_DIR . 'includes/gravity-forms.php');
		
		# Theme supports
		add_theme_support('automatic-feed-links');
		add_theme_support('menus');
		add_theme_support('post-thumbnails');

		# Manually select Post Formats to be supported - http://codex.wordpress.org/Post_Formats
		// add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ) );

		# Register Theme Menu Locations
		/*
		register_nav_menus(array(
			'main-menu'=>__('Main Menu', 'crb'),
		));
		*/
		
		# Attach custom shortcodes
		include_once(CRB_THEME_DIR . 'options/shortcodes.php');

		# Attach custom columns
		include_once(CRB_THEME_DIR . 'options/admin-columns.php');
		
		# Add Actions

		add_action('carbon_register_fields', 'crb_attach_theme_options');
		# Add Filters
	}
}

# Register Sidebars
# Note: In a child theme with custom crb_setup_theme() this function is not hooked to widgets_init

function crb_attach_theme_options() {
	# Attach fields
	include_once(CRB_THEME_DIR . 'options/theme-options.php');
	include_once(CRB_THEME_DIR . 'options/custom-fields.php');
}



add_action( 'init', 'register_my_menu' );
function register_my_menu() {
  register_nav_menu('main-nav',__( 'Main Navigation Menu' ));
  register_nav_menu('frontpage-featured-nav',__( 'Frontpage Featured Navigation Menu' ));
}


//Geocode Address
function crb_get_lat_lng_by_address($address) {
	$url = 'http://maps.googleapis.com/maps/api/geocode/xml?address=' . urlencode($address) . '&sensor=false';

	$transient_key = substr(md5($address), 0, 20);
	$coords_cache = get_transient( $transient_key );

	if ( $coords_cache !== false ) {
		return $coords_cache;
	}

	$response = wp_remote_get($url);
   
	$xml = @simplexml_load_string($response['body']);

	if (strcmp($xml->status, 'OK') == 0) {
		$node = $xml->result[0];
		foreach ($xml->result as $result) {
			// We're looking for a postal code - if there is no postal code, we'll just take the first result...
			if ( strtolower($result->type) == 'postal_code' ) {
				$node = $result;
				break;
			}
		}

		$lat = (float) $node->geometry->location->lat;
		$lng = (float) $node->geometry->location->lng;

		$coords_cache = array('lat' => $lat, 'lng' => $lng);
		set_transient( $transient_key, $coords_cache, 60*60*24 );

		return $coords_cache;
	}
   
	return false;
}

function crb_calculate_location_distance($latitude1, $longitude1, $latitude2, $longitude2) {
	$theta = $longitude1 - $longitude2;
	$miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
	$miles = acos($miles);
	$miles = rad2deg($miles);
	$miles = $miles * 60 * 1.1515;
	// $feet = $miles * 5280;
	// $yards = $feet / 3;
	$kilometers = $miles * 1.609344;
	// $meters = $kilometers * 1000;
	return $kilometers;
}


// Change Default Post type to Location
add_filter("gform_post_data", "crb_change_post_type", 10, 3);      
function crb_change_post_type($post_data, $form, $entry){
	$support_page_form_id = (int) carbon_get_the_post_meta('crb_select_form');
	if ($support_page_form_id === $form['id']) {
		$post_data["post_type"] = "crb_location";
	}
	return $post_data;
}

//Update Post Fields For Latitude Longitude
add_action("gform_after_submission", "set_post_content", 10, 2);
function set_post_content($entry, $form){
	$post_id = $entry["post_id"];

	$full_address = array(
		'street' => $entry['6.1'],
		'city' => $entry['6.3'],
		'state' => $entry['6.4'],
		'zip' => $entry['6.5']
	);

	$address = implode(', ', $full_address);
	update_post_meta( $post_id, '_crb_location_address-address', $address);

	if (!$address) {
		return;
	}
	$coordinates = crb_get_lat_lng_by_address($address);
	if (!$coordinates) {
		return;
	}

	$lat_lng = implode(',', $coordinates);
	add_post_meta( $post_id, '_crb_location_address', $lat_lng);
	add_post_meta( $post_id, '_crb_location_address-lat', $coordinates['lat']);
	add_post_meta( $post_id, '_crb_location_address-lng', $coordinates['lng']);
}

 // Validate Address Field
add_filter("gform_field_validation", "crb_custom_validation", 10, 4);
function crb_custom_validation($result, $value, $form, $field){
	$support_page_form_id = (int) carbon_get_the_post_meta('crb_select_form');
	if ($support_page_form_id === $form['id']) {

		$address_field = 2;
		if ($field['id'] === $address_field ) {
			if ($field['isRequired'] && !crb_get_lat_lng_by_address($value) ) {
				$result["is_valid"] = false;
		        $result["message"] = "Please enter valid address!";
			}

			if (!$field['isRequired'] && $value && !crb_get_lat_lng_by_address($value) ) {
				$result["is_valid"] = false;
		        $result["message"] = "Please enter valid address!";
			}
		}
	}

    return $result;
}

add_action('wp_ajax_get_makers', 'crb_get_markers');
add_action('wp_ajax_nopriv_get_makers', 'crb_get_markers');
function crb_get_markers() {
	$markers = array();

	$location_id = crb_request_param('location_id');

	$user_lat = get_post_meta( $location_id, '_crb_location_address-lat', true );
	$user_lng = get_post_meta( $location_id, '_crb_location_address-lng', true );
	$show_on_map = get_post_meta( $location_id, '_crb_show_on_map', true );

	if (!empty($user_lng) && !empty($user_lat) && $show_on_map) {
		$markers[] = array(
			'lat' => $user_lat,
			'lng' => $user_lng,
			'address' => $location_id
		);
	 	
	} else {
		if ($zip = crb_request_param('location')) {
			$zip_lat_lng = crb_get_lat_lng_by_address($zip);
			$all_markers = crb_get_location_post_lat_lng();
			if ($all_markers && !empty($zip_lat_lng) ) {

				foreach ($all_markers as $l) {
					
					$distance  = crb_calculate_location_distance($zip_lat_lng['lat'], $zip_lat_lng['lng'], $l['lat'], $l['lng']);
					if ($distance <= 10) {
						$markers[] = array(
							'lat' => $l['lat'],
							'lng' => $l['lng'],
							'address' => $l['address']
						);
					}
				}
			} 
		} else {
			$markers = crb_get_location_post_lat_lng();
		}	
	}
	echo json_encode($markers);
	wp_die();
};

function crb_get_location_post_lat_lng() {
	$markers = array();
	$locations = get_posts(array(
		'posts_per_page' => -1,
		'post_type' => 'crb_location',
		'meta_key' => '_crb_show_on_map',
	));	

	if ($locations) {
		foreach ($locations as $l) {
			$address = get_post_meta( $l->ID, '_crb_location_address-address', true);
			$lat = get_post_meta( $l->ID, '_crb_location_address-lat', true);
			$lng = get_post_meta( $l->ID, '_crb_location_address-lng', true);

			if (!$address || !$lat || !$lng) {
				continue;
			}
			$markers[] = array(
				'lat' => $lat,
				'lng' => $lng,
				'address' => $address
			);
			
		}
	}
	return $markers;
}