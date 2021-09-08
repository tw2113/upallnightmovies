<form role="search" action="<?php bloginfo('url'); ?>" id="searchform" method="get">
    <label for="s"><?php esc_html_e( 'Search:', 'uanm' ); ?></label>
    <input type="search" class="primary-search" id="s" name="s" value="" placeholder="<?php esc_attr_e( 'some movie title', 'uanm' ); ?>" />
    <input type="submit" value="<?php esc_attr_e( 'Go', 'uanm' ); ?>" id="searchsubmit" />
</form>
