<?php

/**
 * Register and Enqueue Styles.
 */
function twentytwenty_child_register_styles() {
   wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
   wp_enqueue_style( 'twentytwenty-child-custom', get_stylesheet_directory_uri() . '/assets/css/custom.css' );
}

add_action( 'wp_enqueue_scripts', 'twentytwenty_child_register_styles' );

/**
 * Register and Enqueue Scripts.
 */
function twentytwenty_child_register_scripts() {

  wp_enqueue_script( 'twentytwenty-child-custom', get_stylesheet_directory_uri() . '/assets/js/custom.js', array('jquery'), '20151215', true );

}

add_action( 'wp_enqueue_scripts', 'twentytwenty_child_register_scripts' );

/**
 * Customizer
 */
function twentytwenty_child_customize_register( $wp_customize ) {
  $wp_customize->add_setting( 'navbar-color' , array(
    'default'   => '#fff',
    'transport' => 'refresh',
  ) );

	$wp_customize->add_section( 'custom_color_section' , array(
    'title'      => __( 'Navbar Color', 'twentytwenty_child' ),
    'priority'   => 30,
 ) );
 $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_color', array(
	'label'      => __( 'Choose color', 'twentytwenty_child' ),
	'section'    => 'custom_color_section',
	'settings'   => 'navbar-color',
) ) );

}
add_action( 'customize_register', 'twentytwenty_child_customize_register' );

function twentytwenty_child_customize_css()
{
    ?>
         <style type="text/css">
             #site-header { background-color: <?php echo get_theme_mod('navbar-color', '#fff'); ?>; }
         </style>
    <?php
}
add_action( 'wp_head', 'twentytwenty_child_customize_css');

/**
 * Hooks
 */
add_action( 'woocommerce_before_shop_loop_item_title', 'quadlayers_woocommerce_hooks');
function quadlayers_woocommerce_hooks() {
echo '<span><b>NEW!</b></span>'; 
}

function display_version() {
  $version = 5;
	echo '<p>Welcome to version of {$version} Visionmate</p>';
}
add_filter( 'display_current_version', 'display_version' );

/**
 * Custom Post
 */
function create_post_type() {
  $labels = array(
      'name'                  => _x( 'Books', 'Post type general name', 'textdomain' ),
      'singular_name'         => _x( 'Book', 'Post type singular name', 'textdomain' ),
      'menu_name'             => _x( 'Books', 'Admin Menu text', 'textdomain' ),
      'name_admin_bar'        => _x( 'Book', 'Add New on Toolbar', 'textdomain' ),
      'add_new'               => __( 'Add New', 'textdomain' ),
      'add_new_item'          => __( 'Add New Book', 'textdomain' ),
      'new_item'              => __( 'New Book', 'textdomain' ),
      'edit_item'             => __( 'Edit Book', 'textdomain' ),
      'view_item'             => __( 'View Book', 'textdomain' ),
      'all_items'             => __( 'All Books', 'textdomain' ),
      'search_items'          => __( 'Search Books', 'textdomain' ),
      'parent_item_colon'     => __( 'Parent Books:', 'textdomain' ),
      
  );

  $args = array(
      'labels'             => $labels,
      'public'             => true,
      'publicly_queryable' => true,
      'show_ui'            => true,
      'show_in_menu'       => true,
      'query_var'          => true,
      'rewrite'            => array( 'slug' => 'book' ),
      'capability_type'    => 'post',
      'has_archive'        => true,
      'menu_icon'          => 'dashicons-format-image',
      'hierarchical'       => false,
      'menu_position'      => null,
      'supports'           => array( 'title', 'editor', 'thumbnail'),
  );

  register_post_type( 'book', $args );
}

add_action( 'init', 'create_post_type' );

/**
 * create a daily post
 */
function new_post_article() {

  $begin = new DateTime("2021-03-03");
  $end = new DateTime("2021-03-30");

  $interval = DateInterval::createFromDateString("1 day");
  $period = new DatePeriod($begin, $interval, $end);

  foreach ($period as $dt) {
      $publishDate = $dt->format("Y-m-d");

      if ( !get_page_by_title( $postTitle, "OBJECT", "post" ) ){
          $args = array(
              "post_title"=> "Hello", 
              "post_content" => "world!",
              "post_type"=>"post", 
              "post_date" => $publishDate,
              "post_status"=>"future"
          );        
          $time = strtotime( $postdate . " GMT" );
          $post_id = wp_insert_post( $args );
          wp_schedule_single_event( $time, "publish_future_post", array( $post_id ) );
      }
  }
}
add_action("wp", "new_post_article");
?>