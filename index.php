<?php
/**
 * The main template file (fallback)
 */
if (!defined('ABSPATH')) exit;
get_header();
?>
<section class="section">
  <div class="container">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <h1 class="section-title"><?php the_title(); ?></h1>
        <div class="entry-content"><?php the_content(); ?></div>
      </article>
    <?php endwhile; else : ?>
      <h1 class="section-title">Nothing Found</h1>
      <p>The page you are looking for does not exist.</p>
    <?php endif; ?>
  </div>
</section>
<?php get_footer(); ?>
