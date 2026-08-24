document.addEventListener('DOMContentLoaded', function () {

    // Menú hamburguesa móvil
    var mobileToggle = document.getElementById('gg-mobile-toggle');
    var navContainer = document.getElementById('gg-site-navigation');

    if (mobileToggle && navContainer) {
        mobileToggle.addEventListener('click', function (e) {
            e.stopPropagation();
            mobileToggle.classList.toggle('is-active');
            navContainer.classList.toggle('is-active');
        });
    }

    // Submenús del mega menú en móvil
    var navItemsWithChildren = document.querySelectorAll('.nav-item.menu-item-has-children');

    navItemsWithChildren.forEach(function (item) {
        var parentLink = item.querySelector(':scope > .nav-link');

        if (parentLink) {
            parentLink.addEventListener('click', function (e) {
                if (window.innerWidth <= 900) {
                    var megaDrop = item.querySelector(':scope > .megamenu-dropdown');
                    if (megaDrop) {
                        e.preventDefault();
                        e.stopPropagation();

                        var isOpen = item.classList.contains('is-open');

                        navItemsWithChildren.forEach(function (otherItem) {
                            if (otherItem !== item) {
                                otherItem.classList.remove('is-open');
                            }
                        });

                        if (!isOpen) {
                            item.classList.add('is-open');
                        } else {
                            item.classList.remove('is-open');
                        }
                    }
                }
            });
        }
    });

    // Clic fuera del menú para cerrarlo
    document.addEventListener('click', function (e) {
        if (navContainer && mobileToggle) {
            if (navContainer.classList.contains('is-active')) {
                if (!navContainer.contains(e.target) && !mobileToggle.contains(e.target)) {
                    navContainer.classList.remove('is-active');
                    mobileToggle.classList.remove('is-active');
                    navItemsWithChildren.forEach(function (item) {
                        item.classList.remove('is-open');
                    });
                }
            }
        }
    });

    // Tecla ESC para cerrar el menú
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' || e.key === 'Esc') {
            if (navContainer && navContainer.classList.contains('is-active')) {
                navContainer.classList.remove('is-active');
                if (mobileToggle) mobileToggle.classList.remove('is-active');
                navItemsWithChildren.forEach(function (item) {
                    item.classList.remove('is-open');
                });
            }
        }
    });

    // Widget de redes sociales flotantes
    var floatingToggle = document.getElementById('gg-floating-socials-toggle');
    var floatingWidget = document.getElementById('gg-floating-socials');

    if (floatingToggle && floatingWidget) {
        floatingToggle.addEventListener('click', function (e) {
            e.stopPropagation();
            var isOpen = floatingWidget.classList.contains('is-open');
            floatingWidget.classList.toggle('is-open');
            floatingToggle.setAttribute('aria-expanded', !isOpen);
        });

        document.addEventListener('click', function (e) {
            if (floatingWidget.classList.contains('is-open')) {
                if (!floatingWidget.contains(e.target)) {
                    floatingWidget.classList.remove('is-open');
                    floatingToggle.setAttribute('aria-expanded', 'false');
                }
            }
        });
    }

});