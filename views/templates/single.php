<?php
/**
 * Single-ensenanzas template page (single post of custom-post: ensenanzas).
 *
 *
 */
get_header(); ?>

<section id="primary" class="site-content span9" role="main">
	<section class="content column wrap">

		<?php if ( have_posts() ) : ?>

	        <?php /* The loop */ ?>
	        <?php while ( have_posts() ) : the_post(); ?>

	           <?php //get_template_part( 'content', get_post_type() ); ?>
				<?php include( PTE_PLUGIN_ROOT . 'views/templates/content.php' ); ?>

	        <?php endwhile; ?>

	        <?php themetest_post_nav(); ?>

	    <?php else : ?>
	        <?php get_template_part( 'content', 'none' ); ?>
	    <?php endif; ?>

	</section>
</section> <!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
