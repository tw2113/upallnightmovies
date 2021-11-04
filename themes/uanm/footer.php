<footer id="colophon" role="contentinfo">
	<div class="footer-widgets">
		<div class="footer-widget footer-column-1">
			<?php dynamic_sidebar( 'footer-column-1' ) ?>
		</div>
		<div class="footer-widget footer-column-2">
			<?php dynamic_sidebar( 'footer-column-2' ) ?>
		</div>
		<div class="footer-widget footer-column-3">
			<?php dynamic_sidebar( 'footer-column-3' ) ?>
		</div>
        <div class="footer-widget footer-column-4">
			<?php dynamic_sidebar( 'footer-column-4' ) ?>
        </div>
	</div>
	<p>
		<small>&copy;<?php echo uanm_copyright_date(); ?>
			<a href="<?php echo home_url( '/' ) ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
		</small>
		<br/>

		<?php
		$quote = new WP_Query(
			[
				'post_type' => 'quotes',
				'posts_per_page' => 1,
				'orderby' => 'RAND',
			]
		);

		#var_dump($quote);

		if ( $quote->posts[0] ) {
			echo str_replace(
				['<p>','</p>'],
				['<small>','</small>'],
				$quote->posts[0]->post_content
			);
			wp_reset_postdata();
		}
		?>
	</p>
</footer>
</div><!--End Container-->

<?php wp_footer(); ?>

</body>
</html>
