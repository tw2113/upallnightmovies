<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<meta name="description" content="<?php bloginfo('description'); ?>" />

<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="container">
	<header id="branding" role="banner">
		<div class="flexwrap">
			<a class="sitelogo" href="<?php echo home_url( '/' ) ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
				<img src="<?php echo get_stylesheet_directory_uri() . '/i/logoheader.png'; ?>" alt="<?php esc_attr_e( 'Up All Night Movies logo', 'uanm' ); ?>" />
			</a>
			<div class="titledesc">
				<h1>
					<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
				</h1>
				<p><?php bloginfo( 'description' ); ?></p>
			</div>
		</div>
		<div class="flexsocialsearch">
			<nav id="access" role="navigation">
				<?php
				wp_nav_menu( [
					'theme_location' => 'primary',
					'container' => '',
					'walker' => new UANM_Primary_Menu_Walker()
				] );
				?>
			</nav>
			<?php echo get_search_form(); ?>
		</div>
	</header>
