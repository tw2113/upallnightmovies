<?php
namespace upallnightmovies;

function uanm_patterns() {
	register_block_pattern(
		'uanm/imdbpoll',
		[
			'title'       => __( 'IMDb & Poll', 'uanm' ),
			'description' => _x( 'Your Description.', 'Block pattern description', 'uanm' ),
			'categories'  => [ 'uanm' ],
			'content'     => "<!-- wp:group -->\n<div class=\"wp-block-group\"><!-- wp:columns -->\n<div class=\"wp-block-columns\"><!-- wp:column -->\n<div class=\"wp-block-column\"><!-- wp:heading -->\n<h2 class=\"has-text-align-center\">IMDb Links</h2>\n<!-- /wp:heading -->\n\n<!-- wp:list -->\n<ul><li>Movie 1</li><li>Movie 2</li><li>Movie 3</li><li>Movie 4</li></ul>\n<!-- /wp:list --></div>\n<!-- /wp:column -->\n\n<!-- wp:column -->\n<div class=\"wp-block-column\"><!-- wp:heading -->\n<h2 class=\"has-text-align-center\">Poll</h2>\n<!-- /wp:heading -->\n\n<!-- wp:poll-maker/poll {\"metaFieldValue\":4,\"shortcode\":\"[ays_poll id=4]\"} -->\n[ays_poll id=\"4\"]\n<!-- /wp:poll-maker/poll --></div>\n<!-- /wp:column --></div>\n<!-- /wp:columns --></div>\n<!-- /wp:group -->",
		]
	);

	register_block_pattern(
		'uanm/movie-descriptions',
		[
			'title'       => __( 'UANM Movie Descriptions', 'uanm' ),
			'description' => _x( 'Movie descriptions', 'Block pattern description', 'uanm' ),
			'categories'  => [ 'uanm' ],
			'content'     => "<!-- wp:group --> <div class=\"wp-block-group\"><!-- wp:heading --> <h2 id=\"movie-descriptions\">Movie Descriptions</h2> <!-- /wp:heading --> <!-- wp:paragraph --> <p>All descriptions care of IMDb.com</p> <!-- /wp:paragraph --> <!-- wp:heading {\"level\":3} --> <h3>Title 1</h3> <!-- /wp:heading --> <!-- wp:paragraph --> <p>Description 1</p> <!-- /wp:paragraph --> <!-- wp:heading {\"level\":3} --> <h3>Title 2</h3> <!-- /wp:heading --> <!-- wp:paragraph --> <p>Description 2</p> <!-- /wp:paragraph --> <!-- wp:heading {\"level\":3} --> <h3>Title 3</h3> <!-- /wp:heading --> <!-- wp:paragraph --> <p>Description 3</p> <!-- /wp:paragraph --> <!-- wp:heading {\"level\":3} --> <h3>Title 4</h3> <!-- /wp:heading --> <!-- wp:paragraph --> <p>Description 4</p> <!-- /wp:paragraph --></div> <!-- /wp:group -->",
		]
	);

	register_block_pattern(
		'uanm/extras',
		[
			'title'       => __( 'UANM Extras', 'uanm' ),
			'description' => _x( 'Streaming and Extra links', 'Block pattern description', 'uanm' ),
			'categories'  => [ 'uanm' ],
			'content'     => "<!-- wp:heading -->\n<h2>Extras</h2>\n<!-- /wp:heading -->\n\n<!-- wp:heading {\"level\":3} -->\n<h3>Trailer</h3>\n<!-- /wp:heading -->\n\n<!-- wp:embed {\"providerNameSlug\":\"youtube\",\"responsive\":true} /-->\n\n<!-- wp:heading {\"level\":3} -->\n<h3>Streaming information</h3>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph -->\n<p>TubiTV: <a href=\"#\" target=\"_blank\" rel=\"noreferrer noopener\">URL Here</a></p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Shudder: <a href=\"#\" target=\"_blank\" rel=\"noreferrer noopener\">URL Here</a></p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Amazon: <a href=\"#\" target=\"_blank\" rel=\"noreferrer noopener\">URL Here</a></p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Netflix: <a href=\"#\" target=\"_blank\" rel=\"noreferrer noopener\">URL Here</a></p>\n<!-- /wp:paragraph -->",
		]
	);

	register_block_pattern_category(
		'uanm',
		[ 'label' => _x( 'UANM', 'Block pattern category' ) ],
	);
}
add_action( 'init', __NAMESPACE__ . '\uanm_patterns' );