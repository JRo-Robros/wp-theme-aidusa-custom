<?php get_header(); ?>
<main>
<?php
  if (is_front_page() == false){
    ?><section id='title-section' class='alignfull'><div class='holder'>
    <ul id="breadcrumbs" class="breadcrumbs"><li class="item-home"><a class="bread-link bread-home" href="/" title="Homepage">Homepage</a></li><li class="separator separator-home"> / </li><li class="item-cat item-custom-post-type-product"><a class="bread-cat bread-custom-post-type-product" href="/products" title="Products">Products</a></li><li class="separator"> / </li><li><?php the_terms( $post->ID, 'product_category' );  ?></li><li class="separator"> / </li><li class="item-current"><strong class="bread-current" title="Product"><?php the_title() ?></strong></li></ul></div></section><?php
  };
  ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
  <?php the_title('<h1>', '</h1>'); ?>
  <?php the_content(); ?>
<?php endwhile;  endif;?>
</main>
<?php get_footer(); ?>