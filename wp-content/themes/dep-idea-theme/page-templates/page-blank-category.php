<?php
/**
 * Template Name: Blank category template
 *
 * Plantilla para mostrar los dashboards de Power BI
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

if ( have_posts() ) : while ( have_posts() ) : the_post();

get_sidebar();

?>
<?php if ( comments_open() && !post_password_required() ) { comments_template( '', true ); } ?>
<?php endwhile; endif; ?>
<?php get_footer(); ?>
