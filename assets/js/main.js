/**
 * Tema GanaGana Custom - Lógica JavaScript Principal
 * Mega Menu Walker + Hamburguesa Móvil
 */

document.addEventListener('DOMContentLoaded', function () {

    // =============================================
    // 1. MENÚ HAMBURGUESA MÓVIL
    // =============================================
    var mobileToggle = document.getElementById('gg-mobile-toggle');
    var navContainer = document.getElementById('gg-site-navigation');

    if (mobileToggle && navContainer) {
        mobileToggle.addEventListener('click', function (e) {
            e.stopPropagation();
            mobileToggle.classList.toggle('is-active');
            navContainer.classList.toggle('is-active');
        });
    }

    // =============================================
    // 2. MEGA MENU - SUBMENÚS EN MÓVIL
    // En móvil, los items con .megamenu-dropdown
    // se abren/cierran con click en el nav-link
    // =============================================
    var navItemsWithChildren = document.querySelectorAll('.nav-item.menu-item-has-children');

    navItemsWithChildren.forEach(function (item) {
        var parentLink = item.querySelector(':scope > .nav-link');

        if (parentLink) {
            parentLink.addEventListener('click', function (e) {
                // Solo en pantallas donde está activa la hamburguesa (móvil)
                if (window.innerWidth <= 900) {
                    var megaDrop = item.querySelector(':scope > .megamenu-dropdown');
                    if (megaDrop) {
                        e.preventDefault();
                        e.stopPropagation();

                        var isOpen = item.classList.contains('is-open');

                        // Cerrar todos los demás mega menus abiertos
                        navItemsWithChildren.forEach(function (otherItem) {
                            if (otherItem !== item) {
                                otherItem.classList.remove('is-open');
                            }
                        });

                        // Alternar este
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

    // =============================================
    // 3. CERRAR MENÚ MÓVIL AL HACER CLIC FUERA
    // =============================================
    document.addEventListener('click', function (e) {
        if (navContainer && mobileToggle) {
            if (navContainer.classList.contains('is-active')) {
                if (!navContainer.contains(e.target) && !mobileToggle.contains(e.target)) {
                    navContainer.classList.remove('is-active');
                    mobileToggle.classList.remove('is-active');
                    // Cerrar mega menus abiertos
                    navItemsWithChildren.forEach(function (item) {
                        item.classList.remove('is-open');
                    });
                }
            }
        }
    });

    // =============================================
    // 4. TECLA ESCAPE PARA CERRAR MENÚ
    // =============================================
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

    // =============================================
    // 5. WIDGET FLOTANTE DE REDES SOCIALES
    // =============================================
    var floatingToggle = document.getElementById('gg-floating-socials-toggle');
    var floatingWidget = document.getElementById('gg-floating-socials');

    if (floatingToggle && floatingWidget) {
        floatingToggle.addEventListener('click', function (e) {
            e.stopPropagation();
            var isOpen = floatingWidget.classList.contains('is-open');
            floatingWidget.classList.toggle('is-open');
            floatingToggle.setAttribute('aria-expanded', !isOpen);
        });

        // Cerrar al hacer clic fuera
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