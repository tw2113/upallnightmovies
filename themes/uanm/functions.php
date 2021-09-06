<?php

function uanm_setup() {
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
	printf( __( '<span class="sep">Posted on </span><a href="%1$s" rel="bookmark"><time class="entry-date" datetime="%2$s" pubdate>%3$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%4$s" rel="author">%5$s</a></span></span>', 'uanm' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		get_the_author()
	);
}

function uanm_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.';
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.';
	} else {
		$posted_in = 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.';
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}

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
