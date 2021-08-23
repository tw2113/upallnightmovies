<?php

add_filter( 'verbosa_editor_styles', '__return_empty_string' );

function verbosa_comments_on() {
	$verbosa_meta_comment = cryout_get_option( 'verbosa_meta_comment' );
	// Only show comments if they're open, or are closed but with comments already posted, if the theme's meta comments are enabled and if it's not a single post
	if ( ( comments_open() || get_comments_number() ) && ! post_password_required() && $verbosa_meta_comment && ! is_single() ) :

		echo '<span class="comments-link"><i class="icon-bubbles4 icon-metas" title="' . __('Comments', 'verbosa') . '"></i><strong>';
		comments_popup_link(
			__( 'Leave a comment', 'verbosa' ),
			__( 'One Comment', 'verbosa' ),
			sprintf( _n( '%1$s Comment', '%1$s Comments', get_comments_number(), 'verbosa' ), number_format_i18n( get_comments_number() ) ),
			'',
			''
		);
		echo '</strong></span>';

	endif;
}

function verbosa_header_section() { ?>
    <div id="sidebar">

        <header id="header" <?php cryout_schema_microdata('header') ?>>
            <nav id="mobile-menu">
                <?php cryout_mobilemenu_hook(); ?>
                <button type="button" id="nav-cancel"><i class="icon-cross"></i></button>
            </nav>
            <div id="branding" role="banner">
                <?php if ( has_nav_menu( 'primary' ) || ( true == cryout_get_option('verbosa_pagesmenu') ) ) { ?>
                    <button type="button" id="nav-toggle"><span>&nbsp;</span></button>
                <?php } ?>
                <?php cryout_branding_hook();?>
                <?php cryout_headerimage_hook(); ?>
                <?php get_sidebar('before-menu'); ?>
                <?php if ( has_nav_menu( 'primary' ) || ( true == cryout_get_option('verbosa_pagesmenu') ) ) { ?>
                    <nav id="access" aria-label="Primary Menu" <?php cryout_schema_microdata('menu'); ?>>
                        <h3 class="widget-title menu-title"><span><?php _e("Menu", "verbosa");?></span></h3>
                        <?php cryout_access_hook();?>
                    </nav><!-- #access -->
                <?php } ?>

            </div><!-- #branding -->
        </header><!-- #header -->

        <?php get_sidebar('after-menu'); ?>
        <?php get_sidebar('conditional'); ?>
        <?php cryout_master_footer_hook(); ?>

    </div><!--sidebar-->
    <div id="sidebar-back"></div>
<?php
}

add_action( 'cryout_post_meta_hook', function() {
    echo '<i class="icon-clock icon-metas" title="Reading Time"></i>';
    echo do_shortcode('[rt_reading_time postfix="minutes" postfix_singular="minute"]');
}, 15 );