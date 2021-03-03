<?php
/**
 * The template for displaying archive-books pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */

get_header();
?>

<main id="site-content" role="main">

<?php global $wp_query;

 $wp_query = new WP_Query( array ('numberposts' => 20, 'post_type' => 'books', 'orderby' => 'date') ); ?>

<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
			
	<div>
  <!-- the posts here -->
  </div>

<?php endwhile;
 ?>
<?php wp_reset_postdata(); ?>

</main>

<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php
get_footer();
