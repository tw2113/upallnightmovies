<!doctype html>
<!--[if lte IE 8]><html class="no-js ie7 lte8" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8]><html class="no-js ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 9]><html class="no-js ie9" <?php language_attributes(); ?>><![endif]-->
<!--[if !(IE)]><html class="no-js" <?php language_attributes(); ?>><![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<meta name="description" content="<?php bloginfo('description'); ?>" />

<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<script src="<?php echo get_template_directory_uri(); ?>/js/prefixfree.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/modernizr.custom.js"></script>
<!--[if (gte IE 6)&(lte IE 8)]>
<script src="<?php echo get_template_directory_uri(); ?>/js/selectivizr.js"></script>
<![endif]-->

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="container">
	<header id="branding" role="banner">
		<div class="flexwrap">
			<a href="<?php echo home_url( '/' ) ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
				<img class="sitelogo" src="<?php echo get_stylesheet_directory_uri() . '/i/logoheader.png'; ?>" alt="<?php esc_attr_e( 'Up All Night Movies logo', 'uanm' ); ?>" />
			</a>
			<div class="titledesc">
				<h1>
					<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
				</h1>
				<p><?php bloginfo( 'description' ); ?></p>
			</div>
		</div>
		<nav id="access" role="navigation">
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => '' ) ); ?>
		</nav>
	</header>
