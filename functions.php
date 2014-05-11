<?php

function register_my_menu() {
  register_nav_menu('main-nav',__( 'Main Navigation Menu' ));
}
add_action( 'init', 'register_my_menu' );