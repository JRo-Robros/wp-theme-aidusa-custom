<?php get_header(); ?>
<main>
<?php
  if (is_front_page() == false){
    ?><section id='title-section' class='alignfull'><div class='holder'><?php
    custom_breadcrumbs();
    ?></div></section><?php
  };
  ?>
<?php if (is_post_type_archive('product')):?>
	<div class='product-thirds'>
<?php $wpb_all_query = new WP_Query(array('post_type'=>'product', 'post_status'=>'publish', 'posts_per_page'=>-1));
	if ( $wpb_all_query->have_posts() ) : while ( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post();?>
<div class='product-third'>
<a href="<?php the_permalink( );?>">
  <?php the_post_thumbnail( ); ?>
  </a>
  <div class='post-info'>
  <h2><a href='<?php the_permalink(  ); ?>'>
  <?php $title = the_title( null, null, false );
  if ($title) {
    echo $title;
  } else {
    echo "No Title";
  }; ?>
  </a></h2>
  <?php the_excerpt(  ); ?>
  <a class='btn theme-col' href='<?php the_permalink( )?>'>More</a>
  </div>

  </div>

<?php endwhile;  wp_reset_postdata(); endif; ?>
	</div>
	<?php else: ?>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<a href="<?php the_permalink( );?>">
  <?php the_post_thumbnail( ); ?>
  </a>
  <div class='post-info'>
  <h2><a href='<?php the_permalink(  ); ?>'>
  <?php $title = the_title( null, null, false );
  if ($title) {
    echo $title;
  } else {
    echo "No Title";
  }; ?>
  </a></h2>
  <?php the_excerpt(  ); ?>
  <a class='btn theme-col' href='<?php the_permalink( )?>'>More</a>
  </div>

  </div>
	<?php endwhile;  endif; ?>
	<div class='pagination'>
	
	<?php
global $wp_query;

$big = 999999999; // need an unlikely integer

echo paginate_links( array(
	'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	'format' => '?paged=%#%',
	'current' => max( 1, get_query_var('paged') ),
	'total' => $wp_query->max_num_pages
) );
?> </div>
	<?php endif; ?>

</main>
<?php get_footer();