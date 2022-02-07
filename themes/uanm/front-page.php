<?php get_header(); ?>

<?php
	global $wp_query;
?>
<div class="content" role="main">
    <h2>The Movies</h2>
    <p>Check out what we have covered already:</p>
    <div class="movies">
	<?php if ( have_posts() ) : while( have_posts() ) : the_post(); ?>
	    <article role="article" <?php post_class( 'h-entry' ); ?>>
			<div class="front-archive-wrap">
				<div class="<?php echo esc_attr( implode( ' ', [ 'frontpage-featured' ] ) ); ?>">
                    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'medium' ); ?></a>
                </div>
			</div>
		</article>
		<?php endwhile; endif; ?>
    </div>
	<?php
		if (  $wp_query->max_num_pages > 1 ) :
			echo '<div class="posts-nav footer">';
			previous_posts_link( '&larr; Recent movies' );
			next_posts_link( 'Past movies &rarr;' );
			echo '</div>';
		endif;
	?>

        <h2>Polls and Trailers</h2>
        <p>Help choose what we cover in the future:</p>
        <div class="polls-trailers">
            <?php
                $args = [
                    'category__in' => [
                        21,
                        40,
                    ],
                    'posts_per_page' => 2
                ];
                $polls_trailers = new WP_Query( $args );

            while( $polls_trailers->have_posts() ) : $polls_trailers->the_post();
            ?>
            <article role="article" <?php post_class( 'h-entry' ); ?>>
                <header>
                   <h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
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
                        <?php echo uanm_poll_thumbnail(); ?>
                    </div>
                </div>

            </article>
            <?php
                endwhile; wp_reset_postdata();
            ?>
        </div>
</div>
<?php get_footer(); ?>
