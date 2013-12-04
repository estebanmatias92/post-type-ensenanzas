<?php
/**
 * Taxonomy-categoria template page (to display the post of a given term of this taxonomy).
 *
 *
 */
get_header(); ?>

<section id="primary" class="site-content span9" role="main">

	<section class="content row wrap">

		<?php if ( have_posts() ) : ?>

			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php //get_template_part( 'content', get_post_type() ); ?>
				<?php include( PTE_PLUGIN_ROOT . 'views/templates/content.php' ); ?>

			<?php endwhile; ?>

			<?php themetest_paging_nav(); ?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

	</section>
</section> <!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
