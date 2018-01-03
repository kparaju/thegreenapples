<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php wp_head(); ?>
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

    <title><?php wp_title(); ?></title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

    <!-- style.css -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD_MD3j7UmBRFfVqnGB48r3A_olcnUBLNA"> </script>

  </head>

  <body <?php body_class(); ?>>
    <div class="navigation-cotainer-wrapperw">
      <div class="navigation-container-wrapper">
        <div class="container">
          <a href="#" class="nav-button">
            <span></span>
          </a>

          <div class="tga-header">
            <div class="tga-header-nav">
              <?php wp_nav_menu(array(
                'theme_location' => 'main-nav',
                'depth' => 1
              )); ?>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="tga-header">
        <div class="tga-header-logo">
          <img src="<?php bloginfo('stylesheet_directory'); ?>/img/logo_new.png" alt="" class="logo-img" />
        </div>
      </div>

