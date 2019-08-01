<?php get_header(); ?>
<main>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<?php
  if (is_front_page() == false){
    ?><div class='alignfull'><?php
    custom_breadcrumbs();
    ?></div><?php
  };
  ?>
  <?php the_content(); ?>
<?php endwhile;  endif;?>
</main>
<?php get_footer(); ?>