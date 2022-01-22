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

	wp_enqueue_script( 'mobile-menu', get_stylesheet_directory_uri() . '/js/mobile-menu.js', [], '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'uanm_load_scripts' );

/* Get wp_nav_menu() fallback, wp_page_menu(), to show home link. */
function uanm_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'uanm_page_menu_args' );

function uanm_posted_on() {
	printf( __( '<div class="post-meta">When: <time class="dt-published entry-date" datetime="%1$s" pubdate>%2$s</time><span class="by-author"> <span class="sep"> | Who: </span> <span class="author vcard"><a class="url fn n" href="%3$s" rel="author">%4$s</a></span></span> | %5$s</div>', 'uanm' ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		get_the_author(),
		do_shortcode( '[rt_reading_time label="How long: " postfix="minutes" postfix_singular="minute"]' )
	);
}

function uanm_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	$cat_list = get_the_category_list( ', ' );
	$posted_in = [];
	if ( $cat_list ) {
		$posted_in[] = 'Categories: <span class="p-category">' . $cat_list . '</span>';
	}
	if ( $tag_list ) {
		$posted_in[] = 'Tags: ' . $tag_list;
	}

	$posted_in[] = 'Bookmark the <a class="u-url" href="' . esc_url( get_the_permalink() ) . '" rel="bookmark">permalink</a>.';

    $posted_in[] = 'This post has a <a class="cclicense" rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/"><img alt="Creative Commons License" style="border-width:0" src="https://i.creativecommons.org/l/by-sa/4.0/80x15.png" /></a> <a rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/">Creative Commons Attribution-ShareAlike 4.0 International License</a>';

	echo implode( ', ', $posted_in );
}

function uanm_encourage_comments() {
    ob_start();
    ?>
    <div class="encourage-comments">
    <h2>Did you like this content?</h2>
    <?php
    if ( comments_open() ) {
        ?>
        <p>Give us an earful below.</p>
        <?php
    } else {
        ?>
            <p>Let us know what you think over on our <a href="https://twitter.com/uanmovies" target="_blank" rel="me noopener">UANM Twitter account</a>.</p>
        <?php
    }
    ?>
    </div>
    <?php

    echo ob_get_clean();
}

function uanm_remove_watched_tag( $terms, $post_id, $taxonomy ) {
	if ( is_admin() ) {
		return $terms;
	}
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

	register_sidebar( [
		'name'          => 'Footer Column 4',
		'id'            => 'footer-column-4',
		'description'   => 'Footer column 4',
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	] );

	register_sidebar( [
		'name'          => 'Movie Roll',
		'id'            => 'movie-roll',
		'description'   => 'Movie Roll',
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

function uanm_header_logo() {
	return '<?xml version="1.0" encoding="UTF-8" standalone="no"?> <svg xmlns:dc="http://purl.org/dc/elements/1.1/"xmlns:cc="http://creativecommons.org/ns#"xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"xmlns:svg="http://www.w3.org/2000/svg"xmlns="http://www.w3.org/2000/svg"xmlns:xlink="http://www.w3.org/1999/xlink"xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape"width="145mm"height="145mm"viewBox="0 0 145 145"version="1.1"id="svg912"inkscape:version="1.0.2 (e86c8708, 2021-01-15)"sodipodi:docname="logoheader.svg"> <defs id="defs906"> <radialGradient inkscape:collect="always"xlink:href="#linearGradient884"id="radialGradient886"cx="410"cy="517.14355"fx="410"fy="517.14355"r="269.98633"gradientTransform="matrix(0.99817005,1.4516105e-7,-1.4196791e-7,1.0000038,0.75031262,-0.00197102)"gradientUnits="userSpaceOnUse" /> <linearGradient inkscape:collect="always"id="linearGradient884"> <stop style="stop-color:#f0f0f0;stop-opacity:1"offset="0"id="stop880" /> <stop style="stop-color:#8c8c8c;stop-opacity:1"offset="1"id="stop882" /> </linearGradient> <filter inkscape:collect="always"style="color-interpolation-filters:sRGB"id="filter948"x="-0.00094080169"width="1.0018816"y="-0.00094079826"height="1.0018816"> <feGaussianBlur inkscape:collect="always"stdDeviation="0.21166966"id="feGaussianBlur950" /> </filter> </defs> <sodipodi:namedview id="base"pagecolor="#ffffff"bordercolor="#666666"borderopacity="1.0"inkscape:pageopacity="0.0"inkscape:pageshadow="2"inkscape:zoom="0.35"inkscape:cx="400"inkscape:cy="560"inkscape:document-units="mm"inkscape:current-layer="layer1"inkscape:document-rotation="0"showgrid="false"inkscape:window-width="1252"inkscape:window-height="847"inkscape:window-x="48"inkscape:window-y="25"inkscape:window-maximized="0" /> <metadata id="metadata909"> <rdf:RDF> <cc:Work rdf:about=""> <dc:format>image/svg+xml</dc:format> <dc:type rdf:resource="http://purl.org/dc/dcmitype/StillImage" /> <dc:title></dc:title> </cc:Work> </rdf:RDF> </metadata> <g inkscape:label="Layer 1"inkscape:groupmode="layer"id="layer1"> <g id="g1509"transform="translate(-0.88754751,-0.88729281)"> <circle style="display:inline;fill:#502d16;stroke:#000000;stroke-width:0.5;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"id="circle872"cx="72.571419"cy="72.571259"r="41.825188"inkscape:export-xdpi="35.43322"inkscape:export-ydpi="35.43322"inkscape:export-filename="/Users/tw2113/Desktop/logotest.png" /> <path id="path846"style="display:inline;opacity:0.993;fill:url(#radialGradient886);fill-opacity:1;stroke:none;stroke-width:0.999999;stroke-opacity:1;filter:url(#filter948)"d="M 410,247.15625 C 260.89086,247.15671 140.01413,368.03344 140.01367,517.14258 140.01306,666.25248 260.8901,787.1304 410,787.13086 559.1099,787.1304 679.98694,666.25248 679.98633,517.14258 679.98587,368.03344 559.10914,247.15671 410,247.15625 Z m 0,48.24805 73.25586,73.2539 L 410,441.91406 V 395.61425 H 336.99668 V 368.6582 l 1.63584,-22.03556 71.0085,-0.63921 z M 263.14062,443.88867 c 40.45676,6.2e-4 73.25329,32.79715 73.25391,73.25391 4.6e-4,40.45752 -32.79639,73.25524 -73.25391,73.25586 -40.45828,4.5e-4 -73.25631,-32.79758 -73.25585,-73.25586 6.2e-4,-40.45752 32.79833,-73.25436 73.25585,-73.25391 z m 294.0918,0 c 40.45676,6.2e-4 73.25329,32.79715 73.25391,73.25391 4.6e-4,40.45752 -32.79639,73.25524 -73.25391,73.25586 -40.45828,4.6e-4 -73.25632,-32.79758 -73.25586,-73.25586 6.2e-4,-40.45752 32.79834,-73.25437 73.25586,-73.25391 z M 410,593.63281 l 0.48585,51.17604 h 74.30736 V 666.88867 692.201 L 410,693.07714 v 47.06544 l -73.25586,-73.25391 z"transform="matrix(0.26458333,0,0,0.26458333,-35.907736,-64.256132)"sodipodi:nodetypes="cccsccccccccccccccccccccccccccccc"inkscape:export-xdpi="35.43322"inkscape:export-ydpi="35.43322"inkscape:export-filename="/Users/tw2113/Desktop/logotest.png" /> <path id="path903"style="display:inline;fill:none;stroke:#646464;stroke-width:0.499999;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"d="M 72.571429,1.1372923 C 33.119636,1.1374133 1.137669,33.119381 1.137547,72.571174 1.137386,112.02316 33.119435,144.00545 72.571429,144.00557 112.02342,144.00545 144.00547,112.02316 144.00531,72.571174 144.00519,33.119381 112.02322,1.1374133 72.571429,1.1372923 Z m 0,12.7656287 19.382282,19.381761 -19.382282,19.38228 -0.07801,-12.378021 H 53.442295 V 27.404143 H 72.526188 Z M 33.714885,53.18941 c 10.704185,1.64e-4 19.3816,8.67758 19.381764,19.381764 1.22e-4,10.70439 -8.677378,19.38212 -19.381764,19.38228 -10.704586,1.2e-4 -19.382398,-8.67769 -19.382276,-19.38228 C 14.332773,61.866789 23.0105,53.189291 33.714885,53.18941 Z m 77.811785,0 c 10.70419,1.64e-4 19.3816,8.67758 19.38177,19.381764 1.2e-4,10.70439 -8.67738,19.38212 -19.38177,19.38228 -10.70458,1.2e-4 -19.382399,-8.67769 -19.382279,-19.38228 1.7e-4,-10.704385 8.677899,-19.381885 19.382279,-19.381764 z M 72.571429,92.809214 v 13.625036 h 19.966232 l -0.0549,12.74463 -19.911315,0.0945 v 12.29989 L 53.18915,112.1915 Z"sodipodi:nodetypes="cccsccccccccccccccccccccccccccc"inkscape:export-xdpi="35.43322"inkscape:export-ydpi="35.43322"inkscape:export-filename="/Users/tw2113/Desktop/logotest.png" /> <path id="rect883"style="display:inline;fill:#ffffff;stroke:#b4b4b4;stroke-width:0.257937;stroke-opacity:1"d="M 4.719942,61.481118 H 140.50769 V 83.193194 H 4.719942 Z"inkscape:export-xdpi="35.43322"inkscape:export-ydpi="35.43322"inkscape:export-filename="/Users/tw2113/Desktop/logotest.png" /> </g> </g> </svg>';
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

/** Template for comments and pingbacks. */
function uanm_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' : ?>
			<li class="post pingback">
			<p><?php _e( 'Pingback:', 'uanm' ); ?><?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'uanm' ), ' ' ); ?></p>
			<?php
			break;
		default : ?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<article id="comment-<?php comment_ID(); ?>" class="comment">
				<footer class="comment-meta">
					<div class="comment-author vcard">
						<?php
						echo get_avatar( $comment, 68 );

						printf(
							'<span class="fn">%s</span>',
							get_comment_author_link()
						);

						?>
					</div>
					<div class="comment-meta-time">
						<?php
						printf(
							'<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
							esc_url( get_comment_link( $comment->comment_ID ) ),
							get_comment_time( 'c' ),
							sprintf(
								__( '%1$s at %2$s ', 'uanm' ),
								get_comment_date(),
								get_comment_time()
							)
						);
						?>
					</div>

					<?php if ( $comment->comment_approved == '0' ) : ?>
						<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'uanm' ); ?></em>
						<br />
					<?php endif; ?>

				</footer>

				<div class="comment-content"><?php comment_text(); ?></div>

				<div class="reply">
					<?php comment_reply_link( array_merge( $args, array(
						'reply_text' => __( 'Reply &darr;', 'uanm' ),
						'depth'      => $depth,
						'max_depth'  => $args['max_depth']
					) ) ); ?>
				</div><!-- .reply -->
			</article><!-- #comment-## -->

			<?php
			break;
	endswitch;
}

function uanm_body_classes( $classes ) {
	if ( wp_is_mobile() ) {
		$classes[] = 'is-mobile';
	} else {
	    $classes[] = 'no-mobile';
    }
	return $classes;
}
add_filter( 'body_class', 'uanm_body_classes' );

function uanm_social_menu() {
    return wp_nav_menu( [
	    'theme_location'       => 'social',
	    'container'            => 'nav',
	    'echo'                 => false,
	    'container_aria_label' => 'Social',
	    'walker'               => new UANM_Primary_Menu_Walker(),
    ] );
}
add_shortcode( 'uanm_social', 'uanm_social_menu' );

function uanm_default_notification() {
    printf(
        '<p>Find our latest poll over at <a href="%s">%s</a>.',
        esc_url( 'https://upallnightmovies.com/uanm-poll/' ),
	    esc_url( 'https://upallnightmovies.com/uanm-poll/' )
    );
}
#add_action( 'uanm_notification', 'uanm_default_notification' );

function uanm_rss_campaign( $permalink ) {
    return $permalink . '?mtm_campaign=traffic&mtm_source=rss';
}
add_filter( 'the_permalink_rss', 'uanm_rss_campaign', 10, 1 );

function uanm_attachment_redirect() {
    global $post;

    if ( $post && is_attachment() ) {
        if ( ! empty( $post->post_parent ) ) {
            wp_safe_redirect( get_permalink( $post->post_parent ), 301 );
            exit;
        } else {
            $url = wp_get_attachment_url( $post->ID );
            if ( $url ) {
                wp_safe_redirect( $url, 301 );
                exit;
            }
        }
    }
}
add_action( 'template_redirect', 'uanm_attachment_redirect', 0 );

function uanm_get_poll_by_id( $poll_id ) {
	global $wpdb;
	$args_id    = absint( intval( $poll_id ) );
	$poll_table = esc_sql( $wpdb->prefix . "ayspoll_polls" );
	$sql        = "SELECT * FROM ".$poll_table." WHERE id=%d";

	$wpdb->get_row(
		$wpdb->prepare( $sql, $args_id),
		'ARRAY_A'
	);
}

function uanm_is_poll_expired( $poll_id ) {
    $is_expired = true;

    $poll = uanm_get_poll_by_id( $poll_id );

    if ( ! empty( $poll['styles'] ) ) {
	    $poll_settings = json_decode( $poll['styles'] );

	    $expiration_date = strtotime( "{$poll_settings['deactiveInterval']} {$poll_settings['deactiveIntervalSec']}" );
        $timestamp = time();

        if ( $timestamp < $expiration_date ) {
            $is_expired = false;
        }
    }

    return $is_expired;
}
