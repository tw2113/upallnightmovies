<?php get_header(); ?>
<div class="content" role="main">
	<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
	<article role="article" <?php post_class(); ?>>
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
			if ( ! has_category( 'poll' ) ) {
				echo apply_filters( 'the_excerpt', wpautop( get_the_excerpt() ) );
			} else {
				the_content();
			}
			?>

			</div>
		</article>
		<?php endwhile; endif; ?>
</div>
<?php get_footer(); ?>
