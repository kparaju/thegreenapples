<?php

function register_my_menu() {
  register_nav_menu('main-nav',__( 'Main Navigation Menu' ));
  register_nav_menu('frontpage-featured-nav',__( 'Frontpage Featured Navigation Menu' ));
}
add_action( 'init', 'register_my_menu' );