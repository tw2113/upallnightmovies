<?php get_header(); ?>
	<div class="content" role="main">
        <div class="watched-flex">
        <?php
	        if ( is_post_type_archive() ) {
		        ?>
                <div class="archive-description">
			        <?php echo get_the_post_type_description(); ?>
                </div>
		        <?php
	        }

	        global $wp_query;
	        if ( $wp_query->max_num_pages > 1 ) :
		        echo '<div class="posts-nav header">';
		        next_posts_link( '&larr; Older posts' );
		        previous_posts_link( 'Newer posts &rarr;' );
		        echo '</div>';
	        endif;
        ?>
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<article role="article" <?php post_class( 'h-entry' ); ?>>
                <a href="<?php the_permalink(); ?>">
				<?php
                    the_post_thumbnail( 'large' );
				?>
                </a>
			</article>
		<?php endwhile; endif; ?>
		<?php
			if (  $wp_query->max_num_pages > 1 ) :
				echo '<div class="posts-nav footer">';
				next_posts_link( '&larr; Older posts' );
				previous_posts_link( 'Newer posts &rarr;' );
				echo '</div>';
			endif;
		?>
        </div>
	</div>
<?php get_footer(); ?>
