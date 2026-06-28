<?php
/**
 * Template Name: Home
 * Full-width Elementor canvas.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
while ( have_posts() ) : the_post();
    the_content();
endwhile;
get_footer();
