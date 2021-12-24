<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="<?php bloginfo('description'); ?>" />

<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="preconnect" href="https://trexthepirate.com/traffic/" rel="preconnect">
<link rel="preconnect" href="https://i.ytimg.com" rel="preconnect">
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

        <button aria-expanded="false" aria-controls="menu" class="mobile-nav-toggle">Menu</button>
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
	<?php
	if ( has_action( 'uanm_notification' ) ) {
	?>
        <div class="notification">
			<?php do_action( 'uanm_notification' ); ?>
        </div>
    <?php
	}
    ?>