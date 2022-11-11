<?php get_header(); ?>
	<div class="content" role="main">
        <?php
	        global $wp_query;
	        if ( $wp_query->max_num_pages > 1 ) :
		        echo '<div class="posts-nav header">';
		        next_posts_link( '&larr; Older posts' );
		        previous_posts_link( 'Newer posts &rarr;' );
		        echo '</div>';
	        endif;
        ?>

		<?php
			$years = [];
			$terms = get_terms( [
				'taxonomy' => 'release_year',
			] );
			if ( ! empty( $terms ) && is_array( $terms ) ) {
				foreach ( $terms as $term ) {
					$years[] = sprintf(
						'<a href="%s">%s</a>',
						get_term_link( $term->term_id ),
						$term->name
					);
				}
			}
			echo '<p>Browse by Year: ' . implode( ', ', $years ) . '</p>';
		?>

        <div class="watched-flex">

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<article role="article" <?php post_class( 'h-entry' ); ?>>
                <a href="<?php the_permalink(); ?>">
				<?php
                    the_post_thumbnail( 'large' );
				?>
                </a>
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
