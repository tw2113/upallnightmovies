<?php get_header(); ?>
<div class="content" role="main">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div class="single-post-nav">
					<?php previous_post_link( '%link', '' . _x( '&larr;', 'Previous post link', 'twentyten' ) . ' %title' ); ?>
					<?php next_post_link( '%link', '%title ' . _x( '&rarr;', 'Next post link', 'twentyten' ) . '' ); ?>
				</div>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				    <header>
				    <h1><?php the_title(); ?></h1>
				    <?php uanm_posted_on(); ?>
				    </header>

				    <?php the_content(); ?>
				    <footer>
				    <?php wp_link_pages( array( 'before' => '' . 'Pages:', 'after' => '' ) ); ?>

					<?php uanm_posted_in(); ?>

					<?php edit_post_link( 'Edit', '', '' ); ?>

					<?php echo uanm_sponsored_spot(); ?>

					<div class="single-post-nav">
					<?php previous_post_link( '%link', '' . _x( '&larr;', 'Previous post link', 'twentyten' ) . ' %title' ); ?>
					<?php next_post_link( '%link', '%title ' . _x( '&rarr;', 'Next post link', 'twentyten' ) . '' ); ?>
					</div>
					</footer>
                </article>

				<?php comments_template( '', true ); ?>
<?php endwhile; // end of the loop. ?>

</div>
<?php get_footer(); ?>
