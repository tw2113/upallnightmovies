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

        <div class="movie-roll">
            <?php dynamic_sidebar( 'movie-roll' ) ?>
        </div>
        <p>
            <small>&copy;<?php echo uanm_copyright_date(); ?>
                <?php bloginfo( 'name' ); ?>
            </small>
            <br/>
            Posts are <a class="cclicense" rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/"><img alt="Creative Commons License" style="border-width:0" src="https://i.creativecommons.org/l/by-sa/4.0/80x15.png" /></a> <a rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/">Creative Commons Attribution-ShareAlike 4.0 International License</a>.
            <br/>
            <small id="quotecontainer"></small>
        </p>
    </footer>
</div><!--End Container-->

<?php wp_footer(); ?>

</body>
</html>
