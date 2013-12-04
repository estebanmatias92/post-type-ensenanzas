	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<header class="entry-header">
			<?php if ( is_single() ) : ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php else : ?>
			<h2 class="entry-title">
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
			</h2>
			<?php endif; // is_single() ?>
		</header> <!-- .entry-header -->

		<?php if ( ! is_home() ) : ?>
		<aside class="entry-meta">
			<?php themetest_entry_meta(); ?>
		</aside> <!-- .entry-meta -->
		<?php endif; // ! is_home() ?>

		<section class="entry-content">
	        <?php if ( is_single() ) : ?>
	        	<?php if ( has_post_thumbnail() ) : ?>

	            <figure class="entry-thumbnail">
		            <?php the_post_thumbnail( 'thumbnail' ); ?>
		        </figure>

	            <?php endif; // has_thubnail() ?>
			<?php endif; // is_single() ?>

			<?php if ( is_single() ) : ?>
				<?php the_content(); ?>
			<?php else : ?>
				<?php the_excerpt(); ?>
				<?php //the_read_more_button(); ?>
			<?php endif; // is_single() ?>

			<?php if ( ! is_single() && ! is_home() ) : ?>
				<?php if ( has_post_thumbnail() ) : ?>

	            <figure class="entry-thumbnail">
	                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'thumbnail', array( 'class' => 'alignright' ) ); ?></a>
	            </figure>

	            <?php endif; // has_thubnail() ?>
	        <?php endif; // ! is_single() ?>
		</section> <!-- .entry-content -->

		<!--<hr>-->

	</article> <!-- #post -->
