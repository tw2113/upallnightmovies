<?php

namespace upallnightmovies;

function svg_favicon() {
	?>
	<link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🍿</text></svg>">
	<?php
}
add_action( 'wp_head', __NAMESPACE__ . '\svg_favicon' );
add_action( 'admin_head', __NAMESPACE__ . '\svg_favicon' );

function atom_links() {
	$tmpl = '<link rel="%s" type="%s" title="%s" href="%s" />';

	printf(
		$tmpl,
		esc_attr( 'alternate' ),
		esc_attr( 'application/atom+xml' ),
		esc_attr( get_bloginfo( 'name' ) . ' &raquo; Atom Feed link'  ),
		get_bloginfo( 'atom_url' )
	);
}
add_action( 'wp_head', __NAMESPACE__ . '\atom_links' );

function mtm_wp_to_twitter( $args ) {
    $new_args = [
	    'mtm_campaign' => $args['utm_campaign'],
	    'mtm_source'   => $args['utm_source'],
    ];
    return $new_args;
}
add_filter( 'wpt_analytics_arguments', __NAMESPACE__ . '\mtm_wp_to_twitter' );

function scheeles_admin_color_scheme() {
	$theme_dir = get_stylesheet_directory_uri();

	//Scheeles
	wp_admin_css_color( 'scheeles', __( 'Scheeles' ),
		$theme_dir . '/css/scheeles.css',
		array( '#00478a', '#fff', '#8a0047' , '#478800')
	);
}
add_action('admin_init', __NAMESPACE__ . '\scheeles_admin_color_scheme');
