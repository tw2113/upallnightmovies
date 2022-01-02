<?php get_header(); ?>
<div class="content" role="main">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div class="single-post-nav header">
					<?php previous_post_link( '%link', '' . _x( '&larr;', 'Previous post link', 'uanm' ) . ' %title' ); ?>
					<?php next_post_link( '%link', '%title ' . _x( '&rarr;', 'Next post link', 'uanm' ) . '' ); ?>
				</div>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'h-entry' ); ?>>
				    <header>
				    <h1><?php the_title(); ?></h1>
				    <?php uanm_posted_on(); ?>
				    </header>

				    <?php the_content(); ?>

					<?php echo uanm_sponsored_spot(); ?>

                    <div class="authorbio">
                        <div class="avatarwrap"><?php echo get_avatar( get_the_author_meta( 'ID' ), 64 ); ?></div>
                        <div class="biowrap"><?php echo get_the_author_meta( 'user_description' ); ?></div>
                    </div>

				    <footer>
				    <?php wp_link_pages( array( 'before' => '' . 'Pages:', 'after' => '' ) ); ?>

					<?php uanm_posted_in(); ?>

					<?php edit_post_link( 'Edit', '', '' ); ?>

					</footer>
                </article>

                <div class="single-post-nav footer">
                    <?php previous_post_link( '%link', '' . _x( '&larr;', 'Previous post link', 'uanm' ) . ' %title' ); ?>
                    <?php next_post_link( '%link', '%title ' . _x( '&rarr;', 'Next post link', 'uanm' ) . '' ); ?>
                </div>

				<?php comments_template( '', true ); ?>
<?php endwhile; // end of the loop. ?>

</div>
<?php get_footer(); ?>
