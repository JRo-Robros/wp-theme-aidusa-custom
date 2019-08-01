<?php get_header(); ?>

<main>
<?php
  if (is_front_page() == false){
    ?><section id='title-section' class='alignfull'><div class='holder'><?php
    custom_breadcrumbs();
    ?></div></section><?php
  };
  ?>
  <div class='with-sidebar'>
  <div class='main-content'>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

  <?php the_post_thumbnail( 'full', array(
    'class' => 'mobile-responsive'
  ) ); ?>
  <section style='margin-top: 30px'>
  <?php the_title('<h1>', '</h1>'); ?>
  <?php the_content(); ?>
  </section>
<?php endwhile;  endif;?>
</div>
<aside>
<?php dynamic_sidebar( 'sidebar'); ?>
</aside>
</div>
</main>
<?php get_footer(); ?>