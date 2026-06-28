<?php
/**
 * Default page template.
 * Full-width canvas — Elementor controls the entire layout.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>
<?php while ( have_posts() ) : the_post(); ?>
<div id="post-<?php the_ID(); ?>" <?php post_class( 'hfrcm-page-content' ); ?>>
    <?php the_content(); ?>
</div>
<?php endwhile; ?>
<?php get_footer();
