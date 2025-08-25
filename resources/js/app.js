import 'jquery';
import '@popperjs/core';
import 'bootstrap';

document.querySelectorAll('.nav-item.dropdown').forEach(function (dropdown) {
    if (window.innerWidth >= 992) {
        // Desktop: Hover buka menu
        dropdown.addEventListener('mouseenter', function () {
            this.querySelector('.dropdown-menu').classList.add('show');
        });

        dropdown.addEventListener('mouseleave', function () {
            this.querySelector('.dropdown-menu').classList.remove('show');
        });
    }
    // Di HP, biarkan Bootstrap yang handle klik hamburger & dropdown
});
