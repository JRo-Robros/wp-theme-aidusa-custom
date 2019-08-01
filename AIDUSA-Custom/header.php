<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="profile" href="http://gmpg.org/xfn/11">

  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<header id='main-header'>
<!-- <section id='header-top'>
  <div class='holder'>
    <div></div>
    <?php
    dynamic_sidebar( 'Header Top' )
    ?>
</section>
<section id='header-main'>
<?php
if ( function_exists( 'the_custom_logo' ) ) {
  the_custom_logo();
}

wp_nav_menu( array(
  'menu'          =>  'header',
  'container'     =>  'nav',
  'container_id'  => 'main-nav'
  ) );
?><div id='search-slide'><?php
dynamic_sidebar('Header Right')
  ?></div>
</section> -->
<?php
if ( function_exists( 'the_custom_logo' ) ) {
  the_custom_logo();
} ?>
<section id='header-inner'>

  <?php dynamic_sidebar( 'Header Top' ); ?>

  <div id="header-inner-bottom"><?php
  wp_nav_menu( array(
  'menu'          =>  'header',
  'container'     =>  'nav',
  'container_id'  => 'main-nav'
  ) );
?><div id='search-slide'><?php
dynamic_sidebar('Header Right')
  ?></div>
  </div>
  </div>
</section>
</header>