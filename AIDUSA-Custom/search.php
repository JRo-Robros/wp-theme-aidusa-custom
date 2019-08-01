<?php get_header(); ?>
<main>
<h1>Search Results</h1>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php
// if ( has_post_thumbnail( ) ){
?>
<a href="<?php the_permalink( );?>">
  <?php the_post_thumbnail( ); ?>
  </a>
<?php
// }
?>
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
  </div>

  </div>

<?php endwhile;  endif;?>
</main>
<?php get_footer(); ?>