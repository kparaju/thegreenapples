<?php
Carbon_Container::factory('custom_fields', __('Support Options', 'crb'))
	->show_on_post_type('page')
	->show_on_template('templates/support.php')
	->add_fields(array(
		Carbon_Field::factory('gravity_form', 'crb_select_form', __('Select Form', 'crb') ),
	));


Carbon_Container::factory('custom_fields', __('Location Address', 'crb'))
	->show_on_post_type('crb_location')
	->add_fields(array(
		Carbon_Field::factory('map_with_address', 'crb_location_address', __('Address', 'crb') ),
		Carbon_Field::factory('text', 'crb_email', __('Email', 'crb') ),
		Carbon_Field::factory('checkbox', 'crb_show_on_map', __('Show On Map', 'crb') ),
	));


Carbon_Container::factory('custom_fields', __('Location Settings', 'crb'))
	->show_on_post_type('page')
	->show_on_template('templates/location.php')
	->add_fields(array(
		Carbon_Field::factory('text', 'crb_location_button_text', __('Button Text', 'crb') ),
		Carbon_Field::factory('text', 'crb_location_button_link', __('Button Link', 'crb') ),
		Carbon_Field::factory('textarea', 'crb_location_info_text', __('Info Text', 'crb') ),
	));