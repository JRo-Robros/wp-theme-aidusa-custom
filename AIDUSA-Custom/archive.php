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

<?php endwhile;  endif;?>
</main>
<?php get_footer();