(function () {
    document.addEventListener('DOMContentLoaded', function () {
        let toggle = document.querySelector('.mobile-nav-toggle');
        let menu = document.querySelector('#access');
        let isMobile = ('ontouchstart' in document.documentElement && navigator.userAgent.match(/Mobi/));

        toggle.addEventListener('click', function () {
            let expanded = this.getAttribute('aria-expanded') === 'true' || false;
            this.setAttribute('aria-expanded', !expanded);
            menu.hidden = !menu.hidden;
        });

        if ( isMobile ) {
            menu.hidden = true;
        }
    }, false);
})();