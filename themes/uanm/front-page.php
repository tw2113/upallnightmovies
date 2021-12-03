<?php get_header(); ?>

<?php
	global $wp_query;
	if ( $wp_query->max_num_pages > 1 ) :
        echo '<div class="posts-nav header">';
		next_posts_link( '&larr; Older posts' );
		previous_posts_link( 'Newer posts &rarr;' );
		echo '</div>';
	endif;
?>
<div class="content" role="main">
	<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
	<article role="article" <?php post_class( 'h-entry' ); ?>>
			<header>
			<h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			<?php uanm_posted_on(); ?>
			</header>

			<?php
			$has_poll = has_category( 'poll' );
			$featured_cats = [ 'frontpage-featured' ];
			if ( $has_poll ) {
				$featured_cats[] = 'poll';
			}
			?>

			<div class="front-archive-wrap">
				<?php
				if ( has_post_thumbnail() || has_category( 'poll' ) ) {
					?>
					<div class="<?php echo esc_attr( implode( ' ', $featured_cats ) ); ?>">
						<?php
						if ( has_post_thumbnail() ) {
							the_post_thumbnail( 'medium' );
						} else if ( has_category( 'poll' ) ) {
							echo uanm_poll_thumbnail();
						}
						?>
					</div>
					<?php
				}
			if ( ! has_category( 'poll' ) ) {
				echo apply_filters( 'the_excerpt', wpautop( get_the_excerpt() ) );
			} else {
				the_content();
			}
			?>

			</div>
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
<?php get_footer(); ?>
