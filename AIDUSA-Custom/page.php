<?php get_header(); ?>
<main>
<?php
  if (is_front_page() == false){
    ?><section id='title-section' class='alignfull'><div class='holder'><?php
    custom_breadcrumbs();
    ?></div></section><?php
  };
  ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
  <?php the_content(); ?>
<?php endwhile;  endif;?>
</main>
<?php get_footer(); ?>