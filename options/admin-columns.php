<?php

Carbon_Admin_Columns_Manager::modify_columns('post', array('crb_location') )
	->sort( array('cb', 'title', 'show-on-map') )
	->add( array(
		Carbon_Admin_Column::create('Show on Map')
			->set_name('show-on-map')
			->set_field('_crb_show_on_map'),
	));
