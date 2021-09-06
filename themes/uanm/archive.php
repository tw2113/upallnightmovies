<?php get_header(); ?>
<div class="content" role="main">
<?php if ( have_posts() ) the_post(); ?>
	<h1>
		<?php esc_html__( 'Archives', 'uanm' ); ?>
	</h1>

<?php
	rewind_posts();
	get_template_part( 'loop', 'archive' );
?>
</div><!--End content-->
<?php get_footer(); ?>
