<?php

function uanm_setup() {

	require_once get_stylesheet_directory() . '/inc/primary-menu-walker.php';

	load_theme_textdomain( 'uanm', get_template_directory() . '/languages' );

	add_theme_support( 'post-thumbnails' ); // This theme uses Featured Images
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'html5', [
		'comment-list',
		'comment-form',
		'search-form',
		'gallery',
		'caption',
		'style',
		'script'
	] );

	register_nav_menus( [ 'primary' => 'Primary Navigation' ] );
	register_nav_menus( [ 'social' => 'Social Navigation' ] );
}
add_action( 'after_setup_theme', 'uanm_setup' );

function uanm_comment_enqueue() {
	if ( get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'comment_form_before', 'uanm_comment_enqueue' );

/*Register and enqueue javascript/styles*/

function uanm_load_scripts() {
	wp_enqueue_style( 'normalize', get_stylesheet_directory_uri() . '/css/normalize.css', null, 'all' );
	wp_enqueue_style( 'style', get_bloginfo( 'stylesheet_url' ), 'normalize', null, 'all' );
}
add_action( 'wp_enqueue_scripts', 'uanm_load_scripts' );

/* Get wp_nav_menu() fallback, wp_page_menu(), to show home link. */
function uanm_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'uanm_page_menu_args' );

function uanm_posted_on() {
	printf( __( '<div class="post-meta">On: <time class="entry-date" datetime="%1$s" pubdate>%2$s</time><span class="by-author"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%3$s" rel="author">%4$s</a></span></span> | %5$s</div>', 'uanm' ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		get_the_author(),
		do_shortcode( '[rt_reading_time label="Reading Time: " postfix="minutes" postfix_singular="minute"]' )
	);
}

function uanm_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	$cat_list = get_the_category_list( ', ' );
	$posted_in = [];
	if ( $cat_list ) {
		$posted_in[] = 'Categories: ' . $cat_list;
	}
	if ( $tag_list ) {
		$posted_in[] = 'Tags: ' . $tag_list;
	}

	$posted_in[] = 'Bookmark the <a href="' . esc_url( get_the_permalink() ) . '" rel="bookmark">permalink</a>.';

	echo implode( ', ', $posted_in );
}

function uanm_remove_watched_tag( $terms, $post_id, $taxonomy ) {
	if ( 'post_tag' !== $taxonomy ) {
		return $terms;
	}

	if ( ! empty( $terms ) && is_array( $terms ) ) {
		foreach ( $terms as $key => $term ) {
			if ( in_array( $term->term_id, [ 26 ] ) ) {
				unset( $terms[ $key ] );
			}
		}
	}
	return $terms;
}
add_filter( 'get_the_terms', 'uanm_remove_watched_tag', 10, 3 );

function uanm_browser_body_class($classes) {
	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

	if ( $is_lynx ) {
		$classes[] = 'lynx';
	} elseif ( $is_gecko ) {
		$classes[] = 'firefox';
	} elseif ( $is_opera ) {
		$classes[] = 'opera';
	} elseif ( $is_NS4 ) {
		$classes[] = 'ns4';
	} elseif ( $is_safari ) {
		$classes[] = 'safari';
	} elseif ( $is_chrome ) {
		$classes[] = 'chrome';
	} elseif ( $is_IE ) {
		$classes[] = 'ie';
	} else {
		$classes[] = 'unknown';
	}

	if ( $is_iphone ) {
		$classes[] = 'iphone';
	}

	//Adds a class of singular too when appropriate
	if ( is_singular() && ! is_home() ) {
		$classes[] = 'singular';
	}

	return $classes;
}
add_filter('body_class','uanm_browser_body_class');

// Post numbering via post_class
function uanm_add_post_classes( $classes ) {
	global $wp_query;

	if ( $wp_query->found_posts < 1 ) {
		return $classes;
	}
	if ( $wp_query->current_post == 0 ) {
		$classes[] = 'post-first';
	}

	if ( $wp_query->current_post % 2 ) {
		$classes[] = 'post-even';
	} else {
		$classes[] = 'post-odd';
	}
	if ( $wp_query->current_post == ( $wp_query->post_count - 1 ) ) {
		$classes[] = 'post-last';
	}

	return $classes;
}
add_filter( 'post_class', 'uanm_add_post_classes' );

add_filter('widget_text', 'do_shortcode');

function add_uanm_admin_bar_link($wp_admin_bar) {
	if ( ! is_super_admin() || ! is_admin_bar_showing() ) {
		return;
	}

	$wp_admin_bar->add_node( [
		'parent' => 'site-name',
		'id'     => 'ab-plugins',
		'title'  => 'Plugins',
		'href'   => admin_url( 'plugins.php' )
	] );
}
add_action('admin_bar_menu', 'add_uanm_admin_bar_link', 35);


function uanm_headcleanup() {
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' );
}
add_action( 'init', 'uanm_headcleanup' );

function uanm_filter_ptags_on_images( $content ) {
	return preg_replace( '/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content );
}
add_filter( 'the_content', 'uanm_filter_ptags_on_images' );

function wpst_widgets_init() {
	// Area 1, located at the top of the sidebar.
	register_sidebar( [
		'name'          => 'Footer Column 1',
		'id'            => 'footer-column-1',
		'description'   => 'Footer column 1',
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	] );

	register_sidebar( [
		'name'          => 'Footer Column 2',
		'id'            => 'footer-column-2',
		'description'   => 'Footer column 2',
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	] );

	register_sidebar( [
		'name'          => 'Footer Column 3',
		'id'            => 'footer-column-3',
		'description'   => 'Footer column 3',
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	] );
}
add_action( 'widgets_init', 'wpst_widgets_init' );

function uanm_copyright_date() {
	if ( '2021' === date( 'Y' ) ) {
		return date( 'Y' );
	}

	return '2021 - ' . date( 'Y' );
}

function uanm_custom_excerpt_length( $length ) {
	return 150;
}
add_filter( 'excerpt_length', 'uanm_custom_excerpt_length', 999 );

function uanm_excerpt_more( $more ) {
	$permalink = esc_url( get_the_permalink( get_the_ID() ) );
	return sprintf(
		'<p><a href="%s">%s</a></p>',
		$permalink,
		'Keep reading...'
	);
}
add_filter( 'excerpt_more', 'uanm_excerpt_more' );

function uanm_poll_thumbnail() {
	return '<?xml version="1.0" encoding="UTF-8" standalone="no"?> <svg xmlns:dc="http://purl.org/dc/elements/1.1/"xmlns:cc="http://creativecommons.org/ns#"xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"xmlns:svg="http://www.w3.org/2000/svg"xmlns="http://www.w3.org/2000/svg"xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape"version="1.1"width="210"height="295"viewBox="0 0 210 295"xml:space="preserve"id="svg82"sodipodi:docname="uanm-chart.svg"inkscape:version="1.0.2 (e86c8708, 2021-01-15)"inkscape:export-filename="/Users/tw2113/polls.png"inkscape:export-xdpi="79.580002"inkscape:export-ydpi="79.580002"><metadata id="metadata86"><rdf:RDF><cc:Work rdf:about=""><dc:format>image/svg+xml</dc:format><dc:type rdf:resource="http://purl.org/dc/dcmitype/StillImage" /><dc:title></dc:title></cc:Work></rdf:RDF></metadata><sodipodi:namedview pagecolor="#ffffff"bordercolor="#666666"borderopacity="1"objecttolerance="10"gridtolerance="10"guidetolerance="10"inkscape:pageopacity="0"inkscape:pageshadow="2"inkscape:window-width="1339"inkscape:window-height="836"id="namedview84"showgrid="false"inkscape:zoom="1.8257143"inkscape:cx="134.46791"inkscape:cy="137.12852"inkscape:window-x="78"inkscape:window-y="25"inkscape:window-maximized="0"inkscape:current-layer="icon"inkscape:document-rotation="0" /> <desc id="desc67">Created with Fabric.js 1.7.22</desc> <defs id="defs69"> </defs> <g id="icon"style="opacity:1;fill:none;fill-rule:nonzero;stroke:none;stroke-width:1;stroke-linecap:butt;stroke-linejoin:miter;stroke-miterlimit:10;stroke-dasharray:none"transform="matrix(3.89,0,0,3.89,-38.25788,-56.44363)"> <rect style="fill:#d40000;stroke:#ffffff;stroke-width:0.51413882;stroke-linecap:round;stroke-miterlimit:10;stroke-opacity:1;stroke-dasharray:none"id="rect20"width="10.859265"height="23.782967"x="10.044316"y="66.488617"ry="2.9187541"rx="2.9187541" /><rect style="fill:#d40000;stroke:#ffffff;stroke-width:0.51413882;stroke-linecap:round;stroke-miterlimit:10;stroke-opacity:1;stroke-dasharray:none"id="rect22"width="10.859265"height="67.714081"x="52.717789"y="22.557512"ry="2.9187541"rx="2.9187541" /><rect style="fill:#d40000;stroke:#ffffff;stroke-width:0.51413882;stroke-linecap:round;stroke-miterlimit:10;stroke-opacity:1;stroke-dasharray:none"id="rect24"width="10.859265"height="42.650814"x="38.493298"y="47.620766"ry="2.9187541"rx="2.9187541" /><rect style="fill:#d40000;stroke:#ffffff;stroke-width:0.51413882;stroke-linecap:round;stroke-miterlimit:10;stroke-opacity:1;stroke-dasharray:none"id="rect26"width="10.859265"height="55.041637"x="24.268806"y="35.229939"ry="2.9187539"rx="2.9187541" /></g> </svg>';
}

function uanm_sponsored_spot() {

	if ( ! is_single() ) {
		return;
	}

	if ( ! has_term( 'show', 'sponsored_content', get_the_ID() ) ) {
		return;
	}

	$bookmarks = get_bookmarks( [
		'orderby'  => 'rand',
		'limit'    => 1,
		'category' => 12,
	] );

	$link = '<a href="%s" target="_blank" rel="noopener">%s</a>';
	$link = sprintf(
		$link,
		esc_url( $bookmarks[0]->link_url ),
		esc_html( $bookmarks[0]->link_name )
	);

	$sponsor = "<div class=\"sponsor\">This post was sponsored by {$link}. {$bookmarks[0]->link_description}</div>";

	return $sponsor;
}
