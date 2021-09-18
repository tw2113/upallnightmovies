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
		<div class="top-wrap">
			<div class="logo-title">
				<a class="sitelogo" href="<?php echo home_url( '/' ) ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
					<?php echo uanm_header_logo(); ?>
				</a>
				<div class="titledesc">
					<h1>
						<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
					</h1>
					<p><?php bloginfo( 'description' ); ?></p>
				</div>
			</div>
			<div class="header-searchform">
				<?php echo get_search_form(); ?>
				<nav id="social" aria-label="Social">
					<?php
					wp_nav_menu( [
						'theme_location' => 'social',
						'container'      => '',
						'walker'         => new UANM_Primary_Menu_Walker()
					] );
					?>
				</nav>
			</div>
		</div>

		<div hidden data-menu-button>
			Menu
		</div>
		<nav id="access" role="navigation" aria-label="Main">
			<?php
			wp_nav_menu( [
				'theme_location' => 'primary',
				'container'      => '',
				'walker'         => new UANM_Primary_Menu_Walker()
			] );
			?>
		</nav>
	</header>