(function () {
    document.addEventListener('DOMContentLoaded', function () {
        const body = document.querySelector('body');
        const fakeButton = document.querySelector('[data-menu-button]');
        const menu = document.querySelector('#access');

        const toggleMenuButton = document.createElement('button');
        toggleMenuButton.textContent = fakeButton.textContent;
        toggleMenuButton.setAttribute('aria-expanded', false);
        toggleMenuButton.setAttribute('aria-controls', 'menu');
        toggleMenuButton.classList.add('mobile-nav-toggle');

        fakeButton.parentNode.replaceChild(toggleMenuButton, fakeButton);

        toggleMenuButton.addEventListener('click', function () {
            let expanded = this.getAttribute('aria-expanded') === 'true' || false;
            this.setAttribute('aria-expanded', !expanded);
            menu.hidden = !menu.hidden;
        });

        menu.hidden = true;
    }, false);
})();