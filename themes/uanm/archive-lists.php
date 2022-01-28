<?php get_header(); ?>
	<div class="content" role="main">
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
        <div id="list-grid">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<article role="article" <?php post_class( 'h-entry' ); ?>>
				<header>
					<h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
					<?php uanm_posted_on(); ?>
				</header>

				<?php
				$featured_cats = [ 'frontpage-featured' ];
				?>

				<div class="front-archive-wrap">
					<?php
					if ( has_post_thumbnail() ) {
						?>
							<div class="<?php echo esc_attr( implode( ' ', $featured_cats ) ); ?>">
								<?php
								if ( has_post_thumbnail() ) {
									the_post_thumbnail( 'medium' );
								}
								?>
							</div>
						<?php
					}

                    echo apply_filters( 'the_excerpt', wpautop( get_the_excerpt() ) )
					?>
				</div>
			</article>
		<?php endwhile; endif; ?>
        </div>
		<?php
			if (  $wp_query->max_num_pages > 1 ) :
				echo '<div class="posts-nav footer">';
				next_posts_link( '&larr; Older posts' );
				previous_posts_link( 'Newer posts &rarr;' );
				echo '</div>';
			endif;
		?>
	</div>
<?php get_footer(); ?>
