<?php

global $wp_query;
if ( $wp_query->max_num_pages > 1 ) :
	next_posts_link( '&larr; Older posts' );
	previous_posts_link( 'Newer posts &rarr;' );
endif;

if ( ! have_posts() ) : ?>
	<article role="article">
		<h1>Not Found</h1>
		<p>Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.</p>
		<?php get_search_form(); ?>
	</article>
<?php
endif;

while ( have_posts() ) : the_post(); ?>
	<article role="article" <?php post_class(); ?>>
		<header>
			<h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			<?php uanm_posted_on(); ?>
		</header>
		<?php if ( is_archive() || is_search() ) :
			the_excerpt();
		else :
			the_content( 'Continue reading &rarr;' );
			wp_link_pages( array( 'before' => '' . 'Pages:', 'after' => '' ) );
		endif; ?>
		<footer>
			<?php
			if ( count( get_the_category() ) ) :
				printf( 'Posted in %2$s', 'entry-utility-prep entry-utility-prep-cat-links', get_the_category_list( ', ' ) );
			?> | <?php
			endif;

			$tags_list = get_the_tag_list( '', ', ' );
			if ( $tags_list ):
				printf( 'Tagged %2$s', 'entry-utility-prep entry-utility-prep-tag-links', $tags_list ); ?> | <?php
			endif;

			comments_popup_link( 'Leave a comment', '1 Comment', '% Comments' );
			edit_post_link( 'Edit', '| ', '' );

			comments_template( '', true ); ?>
		</footer>
	</article>

<?php
endwhile;

if (  $wp_query->max_num_pages > 1 ) :
	next_posts_link( '&larr; Older posts' );
	previous_posts_link( 'Newer posts &rarr;' );
endif;
