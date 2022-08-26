<?php get_header(); ?>

<?php
    $main_query = new WP_Query( [
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'category__in'   => [ 25 ],
        'posts_per_page' => 5,
    ] );
?>

<div class="content" role="main">
    <h2 id="movies">The Movies</h2>
    <p>Check out what we have covered recently:</p>
    <div class="movies">
	<?php if ( $main_query->have_posts() ) : while( $main_query->have_posts() ) : $main_query->the_post(); ?>
	    <article role="article" <?php post_class( 'h-entry' ); ?>>
			<div class="front-archive-wrap">
				<div class="<?php echo esc_attr( implode( ' ', [ 'frontpage-featured' ] ) ); ?>">
                    <?php $title = strip_tags( get_the_title() ); ?>
                    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'medium', [ 'alt' => "Film poster for {$title}" ] ); ?></a>
                </div>
			</div>
		</article>
		<?php endwhile; endif; ?>
    </div>
	<div class="moremovieslink">
    <a href="<?php echo get_tag_link( 26 ); ?>">See all covered movies</a>
	</div>
        <h2 id="polltrailersinterviews">Polls, Trailers, Announcements &amp; Interviews</h2>
        <p>Help choose what we cover in the future and read our discussions:</p>
        <div class="polls-trailers-interviews">
            <?php
                $args = [
                    'category__in' => [
                        21,
                        28,
                        40,
                    ],
                    'posts_per_page' => 2
                ];
                $polls_trailers = new WP_Query( $args );

            while( $polls_trailers->have_posts() ) : $polls_trailers->the_post();
            ?>
            <article role="article" <?php post_class( [ 'h-entry', 'polls' ] ); ?>>
                <header>
                   <h3><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
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

	        $args       = [
		        'category__in'   => [
			        31
		        ],
		        'posts_per_page' => 1
	        ];
	        $interviews = new WP_Query( $args );

	        while ( $interviews->have_posts() ) : $interviews->the_post();
		        ?>
				<article role="article" <?php post_class( [ 'h-entry', 'interview' ] ); ?>>
					<header>
						<h3><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
					</header>
					<div class="front-archive-wrap">
						<div class="<?php echo esc_attr( implode( ' ', [ 'frontpage-featured' ] ) ); ?>">
							<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'medium' ); ?></a>
						</div>
					</div>

				</article>
	        <?php
	        endwhile;
	        wp_reset_postdata();
	        ?>
        </div>
</div>
<?php get_footer(); ?>
