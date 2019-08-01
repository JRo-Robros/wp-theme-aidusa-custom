<?php
function AIDUSA_enqueue() {
    if($_SERVER['SERVER_NAME'] != 'localhost'){
      wp_enqueue_style('style', get_template_directory_uri() . '/style.min.css');
    } else{
      wp_enqueue_style('style', get_template_directory_uri() . '/style.css');
    }
    wp_enqueue_style('opensans', "https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,800");
    wp_enqueue_style('fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css');
    wp_enqueue_script( 'rellax', get_template_directory_uri() . '/js/rellax.min.js', null, '', true );
    wp_enqueue_script( 'customjs', get_template_directory_uri() . '/js/custom.js', array('jquery', 'rellax'), '', true );

  }
add_action('wp_enqueue_scripts', 'AIDUSA_enqueue');

add_theme_support( 'title-tag' );
add_theme_support( 'post-thumbnails' );
add_theme_support('align-wide');
add_theme_support('custom-logo', array(
  'height'      =>  60,
  'width'       =>  300,
  'flex-height' =>  true,
  'flex-width'  =>  true
));

// customize appearance options
function aidusa_customize_register( $wp_customize ) {
  $wp_customize->add_setting('aidusa_color_main', array(
    'default'   =>  '#255A9B',
    'transport' =>  'refresh'
  ));

  $wp_customize->add_setting('aidusa_color_second', array(
    'default'   =>  '#71D0E1',
    'transport' =>  'refresh'
  ));

  $wp_customize->add_section('aidusa_theme_opts', array(
    'title'     =>  'Theme Options',
    'priority'  =>  30
  ));

  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'aidusa_color_main_control', array(
    'label'     =>  'Main Color',
    'section'   =>  'aidusa_theme_opts',
    'settings'  =>  'aidusa_color_main'
  )));

  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'aidusa_color_second_control', array(
    'label'     =>  'Secondary Color',
    'section'   =>  'aidusa_theme_opts',
    'settings'  =>  'aidusa_color_second'
  )));
}
add_action( 'customize_register', 'aidusa_customize_register');
//

// use customized colors
function aidusa_custom_css(){
  ?>
  <style type='text/css'>
  body{
    --col-main: <?php echo get_theme_mod('aidusa_color_main', '#255A9B'); ?>;
    --col-second: <?php echo get_theme_mod('aidusa_color_second', '#71D0E1'); ?>;
  }
  </style>
  <?php
}
add_action( 'wp_head', 'aidusa_custom_css');
//

register_nav_menus( array(
  'header' => 'Primary Menu',
) );

function AIDUSA_widgets_init() {

  register_sidebar( array(
    'name'          => 'Footer',
    'id'            => 'footer',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h4 class="ttl">',
    'after_title'   => '</h4>',
  ) );
  register_sidebar( array(
    'name'          => 'Sidebar',
    'id'            => 'sidebar',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h4 class="ttl">',
    'after_title'   => '</h4>',
  ) );
  register_sidebar( array(
    'name'          => 'Header Top',
    'id'            => 'header_top',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h4 class="ttl">',
    'after_title'   => '</h4>',
  ) );
  register_sidebar( array(
    'name'          => 'Header Right',
    'id'            => 'header_right',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h4 class="ttl">',
    'after_title'   => '</h4>',
  ) );
  register_sidebar( array(
    'name'          => 'Content Bottom',
    'id'            => 'content_bottom',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h4 class="ttl">',
    'after_title'   => '</h4>',
  ) );

}
add_action( 'widgets_init', 'AIDUSA_widgets_init' );

/** dequeue default block styling */
function aidusa_deregister_styles() {
	wp_dequeue_style( 'wp-block-library' );
};
add_action( 'wp_print_styles', 'aidusa_deregister_styles', 100 );

// Breadcrumbs
function custom_breadcrumbs() {

  // Settings
  $separator          = '/';
  $breadcrums_id      = 'breadcrumbs';
  $breadcrums_class   = 'breadcrumbs';
  $home_title         = 'Homepage';

  // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
  $custom_taxonomy    = 'product_cat';

  // Get the query & post information
  global $post,$wp_query;

  // Do not display on the homepage
  if ( !is_front_page() ) {

      // Build the breadcrums
      echo '<ul id="' . $breadcrums_id . '" class="' . $breadcrums_class . '">';

      // Home page
      echo '<li class="item-home"><a class="bread-link bread-home" href="' . get_home_url() . '" title="' . $home_title . '">' . $home_title . '</a></li>';
      echo '<li class="separator separator-home"> ' . $separator . ' </li>';

      if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {

          echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . post_type_archive_title($prefix, false) . '</strong></li>';

      } else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {

          // If post is a custom post type
          $post_type = get_post_type();

          // If it is a custom post type display name and link
          if($post_type != 'post') {

              $post_type_object = get_post_type_object($post_type);
              $post_type_archive = get_post_type_archive_link($post_type);

              echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
              echo '<li class="separator"> ' . $separator . ' </li>';

          }

          $custom_tax_name = get_queried_object()->name;
          echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . $custom_tax_name . '</strong></li>';

      } else if ( is_single() ) {

          // If post is a custom post type
          $post_type = get_post_type();

          // If it is a custom post type display name and link
          if($post_type != 'post') {

              $post_type_object = get_post_type_object($post_type);
              $post_type_archive = get_post_type_archive_link($post_type);

              echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
              echo '<li class="separator"> ' . $separator . ' </li>';

          }

          // Get post category info
          $category = get_the_category();

          if(!empty($category)) {

              // Get last category post is in
              $last_category = end(array_values($category));

              // Get parent any categories and create array
              $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
              $cat_parents = explode(',',$get_cat_parents);

              // Loop through parent categories and store in variable $cat_display
              $cat_display = '';
              foreach($cat_parents as $parents) {
                  $cat_display .= '<li class="item-cat">'.$parents.'</li>';
                  $cat_display .= '<li class="separator"> ' . $separator . ' </li>';
              }

          }

          // If it's a custom post type within a custom taxonomy
          $taxonomy_exists = taxonomy_exists($custom_taxonomy);
          if(empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {

              $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
              $cat_id         = $taxonomy_terms[0]->term_id;
              $cat_nicename   = $taxonomy_terms[0]->slug;
              $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
              $cat_name       = $taxonomy_terms[0]->name;

          }

          // Check if the post is in a category
          if(!empty($last_category)) {
              echo $cat_display;
              echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';

          // Else if post is in a custom taxonomy
          } else if(!empty($cat_id)) {

              echo '<li class="item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '"><a class="bread-cat bread-cat-' . $cat_id . ' bread-cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a></li>';
              echo '<li class="separator"> ' . $separator . ' </li>';
              echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';

          } else {

              echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';

          }

      } else if ( is_category() ) {

          // Category page
          echo '<li class="item-current item-cat"><strong class="bread-current bread-cat">' . single_cat_title('', false) . '</strong></li>';

      } else if ( is_page() ) {

          // Standard page
          if( $post->post_parent ){

              // If child page, get parents
              $anc = get_post_ancestors( $post->ID );

              // Get parents in the right order
              $anc = array_reverse($anc);

              // Parent page loop
              if ( !isset( $parents ) ) $parents = null;
              foreach ( $anc as $ancestor ) {
                  $parents .= '<li class="item-parent item-parent-' . $ancestor . '"><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                  $parents .= '<li class="separator separator-' . $ancestor . '"> ' . $separator . ' </li>';
              }

              // Display parent pages
              echo $parents;

              // Current page
              echo '<li class="item-current item-' . $post->ID . '"><strong title="' . get_the_title() . '"> ' . get_the_title() . '</strong></li>';

          } else {

              // Just display current page if not parents
              echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '"> ' . get_the_title() . '</strong></li>';

          }

      } else if ( is_tag() ) {

          // Tag page

          // Get tag information
          $term_id        = get_query_var('tag_id');
          $taxonomy       = 'post_tag';
          $args           = 'include=' . $term_id;
          $terms          = get_terms( $taxonomy, $args );
          $get_term_id    = $terms[0]->term_id;
          $get_term_slug  = $terms[0]->slug;
          $get_term_name  = $terms[0]->name;

          // Display the tag name
          echo '<li class="item-current item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '"><strong class="bread-current bread-tag-' . $get_term_id . ' bread-tag-' . $get_term_slug . '">' . $get_term_name . '</strong></li>';

      } elseif ( is_day() ) {

          // Day archive

          // Year link
          echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
          echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';

          // Month link
          echo '<li class="item-month item-month-' . get_the_time('m') . '"><a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></li>';
          echo '<li class="separator separator-' . get_the_time('m') . '"> ' . $separator . ' </li>';

          // Day display
          echo '<li class="item-current item-' . get_the_time('j') . '"><strong class="bread-current bread-' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</strong></li>';

      } else if ( is_month() ) {

          // Month Archive

          // Year link
          echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
          echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';

          // Month display
          echo '<li class="item-month item-month-' . get_the_time('m') . '"><strong class="bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</strong></li>';

      } else if ( is_year() ) {

          // Display year archive
          echo '<li class="item-current item-current-' . get_the_time('Y') . '"><strong class="bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</strong></li>';

      } else if ( is_author() ) {

          // Auhor archive

          // Get the author information
          global $author;
          $userdata = get_userdata( $author );

          // Display author name
          echo '<li class="item-current item-current-' . $userdata->user_nicename . '"><strong class="bread-current bread-current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '">' . 'Author: ' . $userdata->display_name . '</strong></li>';

      } else if ( get_query_var('paged') ) {

          // Paginated archives
          echo '<li class="item-current item-current-' . get_query_var('paged') . '"><strong class="bread-current bread-current-' . get_query_var('paged') . '" title="Page ' . get_query_var('paged') . '">'.__('Page') . ' ' . get_query_var('paged') . '</strong></li>';

      } else if ( is_search() ) {

          // Search results page
          echo '<li class="item-current item-current-' . get_search_query() . '"><strong class="bread-current bread-current-' . get_search_query() . '" title="Search results for: ' . get_search_query() . '">Search results for: ' . get_search_query() . '</strong></li>';

      } elseif ( is_404() ) {

          // 404 page
          echo '<li>' . 'Error 404' . '</li>';
      }

      echo '</ul>';

  }

}

// custom blocks
// function aidusa_register_blocks(){
//   wp_register_script(
//     'aidusa-accordion',
//     get_template_directory_uri() . '/js/blocks/accordion/npmaccordion.js',
//     array('wp-blocks', 'wp-element')
//   );
//   register_block_type( 'aidusa/accordion', array(
//     'editor_script'   => 'aidusa-accordion'
//   ) );
// }

// add_action( 'init', 'aidusa_register_blocks' );


/// custom post type / tax
function register_product_entities() {
  $product_args = array(
    'public' => true,
    'show_in_nav_menus'=> true,
    'label'  => 'Products',
    'taxonomies' => array( 'product_category' ),
    'supports'  => array(
      'title',
      'thumbnail',
      'editor',
      'excerpt'
    ),
    'show_in_rest'  => true,
    'has_archive' => true,
    'rewrite' => array('slug' => 'products')
  );
  register_post_type( 'product', $product_args );

  // Register Custom Taxonomy


	$labels = array(
		'name'                       => _x( 'Product Categories', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Product Category', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Product Category', 'text_domain' ),
		'all_items'                  => __( 'All Items', 'text_domain' ),
		'parent_item'                => __( 'Parent Item', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
		'new_item_name'              => __( 'New Item Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Item', 'text_domain' ),
		'edit_item'                  => __( 'Edit Item', 'text_domain' ),
		'update_item'                => __( 'Update Item', 'text_domain' ),
		'view_item'                  => __( 'View Item', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Items', 'text_domain' ),
		'search_items'               => __( 'Search Items', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
		'no_terms'                   => __( 'No items', 'text_domain' ),
		'items_list'                 => __( 'Items list', 'text_domain' ),
		'items_list_navigation'      => __( 'Items list navigation', 'text_domain' ),
	);
	$rewrite = array(
		'with_front'                 => true,
		'hierarchical'               => true,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'rewrite'                    => $rewrite,
    'show_in_rest'               => true,
	);
  register_taxonomy( 'product_category', array( 'product' ), $args );

}

add_action( 'init', 'register_product_entities' );
