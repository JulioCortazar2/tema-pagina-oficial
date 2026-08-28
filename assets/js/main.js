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

    // Botón flotante "Volver arriba" con progreso de scroll
    var backToTop = document.getElementById('gg-back-to-top');

    if (backToTop) {
        var ringBar = backToTop.querySelector('.gg-btt-ring-bar');
        var iconFill = backToTop.querySelector('.gg-btt-icon-fill');
        var ringCircumference = 2 * Math.PI * 27;
        var ticking = false;

        function updateBackToTop() {
            var scrollTop = window.scrollY || document.documentElement.scrollTop;
            var docHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            var progress = docHeight > 0 ? Math.min(Math.max(scrollTop / docHeight, 0), 1) : 0;

            ringBar.style.strokeDashoffset = ringCircumference * (1 - progress);
            iconFill.style.clipPath = 'inset(' + ((1 - progress) * 100) + '% -10px -10px -10px)';

            if (scrollTop > 400) {
                backToTop.classList.add('is-visible');
            } else {
                backToTop.classList.remove('is-visible');
            }

            ticking = false;
        }

        window.addEventListener('scroll', function () {
            if (!ticking) {
                window.requestAnimationFrame(updateBackToTop);
                ticking = true;
            }
        }, { passive: true });

        updateBackToTop();

        backToTop.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

});