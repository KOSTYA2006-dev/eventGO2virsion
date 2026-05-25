var menu = document.getElementById('mobileMenu');

function closeToggleMenu() {
    if (menu) {
        menu.style.right = '-1000px';
    }
}

function toggleMenu() {
    if (menu) {
        menu.style.display = 'block';
        menu.style.right = '0';
    }
}

document.addEventListener('DOMContentLoaded', function () {
    var openBtn = document.querySelector('[data-menu-open]');
    var closeBtn = document.querySelector('[data-menu-close]');

    if (openBtn) {
        openBtn.addEventListener('click', toggleMenu);
    }
    if (closeBtn) {
        closeBtn.addEventListener('click', closeToggleMenu);
    }
});
