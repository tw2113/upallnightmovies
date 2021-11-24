<?php
namespace upallnightmovies;

function uanm_patterns() {
	register_block_pattern(
		'uanm/imdbpoll',
		[
			'title'       => __( 'IMDb & Poll', 'uanm' ),
			'description' => _x( 'Your Description.', 'Block pattern description', 'uanm' ),
			'categories'  => [ 'uanm' ],
			'content'     => "<!-- wp:group -->\n<div class=\"wp-block-group\"><!-- wp:columns -->\n<div class=\"wp-block-columns\"><!-- wp:column -->\n<div class=\"wp-block-column\"><!-- wp:heading -->\n<h2>IMDb Links</h2>\n<!-- /wp:heading -->\n\n<!-- wp:list -->\n<ul><li><a rel=\"noreferrer noopener\" href=\"https://www.imdb.com/title/tt2784512/\" data-type=\"URL\" data-id=\"https://www.imdb.com/title/tt2784512/\" target=\"_blank\">Zombeavers</a></li><li><a rel=\"noreferrer noopener\" href=\"https://www.imdb.com/title/tt0090094/\" data-type=\"URL\" data-id=\"https://www.imdb.com/title/tt0090094/\" target=\"_blank\">The Stuff</a></li><li><a href=\"https://www.imdb.com/title/tt0096142/\" data-type=\"URL\" data-id=\"https://www.imdb.com/title/tt0096142/\" target=\"_blank\" rel=\"noreferrer noopener\">Sorority Babes in the Slimeball Bowl-O-Rama</a></li><li><a rel=\"noreferrer noopener\" href=\"https://www.imdb.com/title/tt1807020/\" data-type=\"URL\" data-id=\"https://www.imdb.com/title/tt1807020/\" target=\"_blank\">Steampunk Samurai Biker Chicks</a></li></ul>\n<!-- /wp:list --></div>\n<!-- /wp:column -->\n\n<!-- wp:column -->\n<div class=\"wp-block-column\"><!-- wp:heading -->\n<h2>Poll</h2>\n<!-- /wp:heading -->\n\n<!-- wp:poll-maker/poll {\"metaFieldValue\":7,\"shortcode\":\"[ays_poll id=7]\"} -->\n[ays_poll id=\"7\"]\n<!-- /wp:poll-maker/poll --></div>\n<!-- /wp:column --></div>\n<!-- /wp:columns --></div>\n<!-- /wp:group -->",
		]
	);

	register_block_pattern_category(
		'uanm',
		[ 'label' => _x( 'UANM', 'Block pattern category' ) ],
	);
}
add_action( 'init', __NAMESPACE__ . '\uanm_patterns' );