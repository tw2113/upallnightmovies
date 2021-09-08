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
	</div>
	<p>
		<small>&copy;<?php echo uanm_copyright_date(); ?>
			<a href="<?php echo home_url( '/' ) ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
		</small>
		<br/>
		<small>This I believe in... I believe in death. I believe in disease. I believe in injustice and inhumanity, torture and anger and hate... I believe in murder. I believe in pain. I believe in cruelty and infidelity. I believe in slime and stink and every crawling, putrid thing... every possible ugliness and corruption, you son of a bitch. I believe... in you.</small>
	</p>
</footer>
</div><!--End Container-->

<?php wp_footer(); ?>

</body>
</html>
