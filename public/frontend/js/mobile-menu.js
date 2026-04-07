/**
 * Mobile Menu Handler
 * Beautiful and responsive mobile menu with smooth animations
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        
        // Mobile Menu Toggle
        $('.btn-show-menu-mobile').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            toggleMobileMenu();
        });

        // Close menu when clicking overlay
        $('.menu-mobile-overlay').on('click', function() {
            closeMobileMenu();
        });

        // Close menu when clicking a link (except for links with submenus)
        $('.menu-mobile .main-menu-m > li > a').on('click', function(e) {
            // Don't close if it's a submenu toggle
            if (!$(this).parent().hasClass('has-submenu')) {
                setTimeout(function() {
                    closeMobileMenu();
                }, 300);
            }
        });

        // Handle window resize
        $(window).on('resize', function() {
            if ($(window).width() >= 992) {
                closeMobileMenu();
            }
        });

        // Prevent body scroll when menu is open
        function toggleMobileMenu() {
            const $menu = $('.menu-mobile');
            const $overlay = $('.menu-mobile-overlay');
            const $hamburger = $('.btn-show-menu-mobile');
            const $body = $('body');

            if ($menu.hasClass('show')) {
                closeMobileMenu();
            } else {
                openMobileMenu();
            }
        }

        function openMobileMenu() {
            const $menu = $('.menu-mobile');
            const $overlay = $('.menu-mobile-overlay');
            const $hamburger = $('.btn-show-menu-mobile');
            const $body = $('body');

            $menu.addClass('show');
            $overlay.addClass('show');
            $hamburger.addClass('is-active');
            $body.addClass('menu-open');
        }

        function closeMobileMenu() {
            const $menu = $('.menu-mobile');
            const $overlay = $('.menu-mobile-overlay');
            const $hamburger = $('.btn-show-menu-mobile');
            const $body = $('body');

            $menu.removeClass('show');
            $overlay.removeClass('show');
            $hamburger.removeClass('is-active');
            $body.removeClass('menu-open');
        }

        // Close menu on ESC key
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' || e.keyCode === 27) {
                closeMobileMenu();
            }
        });

        // Smooth scroll for anchor links
        $('.menu-mobile a[href^="#"]').on('click', function(e) {
            const target = $(this.getAttribute('href'));
            if (target.length) {
                e.preventDefault();
                closeMobileMenu();
                
                setTimeout(function() {
                    $('html, body').stop().animate({
                        scrollTop: target.offset().top - 80
                    }, 800);
                }, 400);
            }
        });

        // Add active class to current page link
        const currentPath = window.location.pathname;
        $('.menu-mobile .main-menu-m > li > a').each(function() {
            const linkPath = $(this).attr('href');
            if (linkPath && currentPath.includes(linkPath) && linkPath !== '/') {
                $(this).addClass('active');
            }
        });

        // Highlight home link on homepage
        if (currentPath === '/' || currentPath === '') {
            $('.menu-mobile .main-menu-m > li > a[href="/"]').addClass('active');
        }

        // Add touch-friendly hover effects for mobile
        if ('ontouchstart' in window) {
            $('.menu-mobile .main-menu-m > li > a').on('touchstart', function() {
                $(this).addClass('touch-active');
            }).on('touchend', function() {
                const $this = $(this);
                setTimeout(function() {
                    $this.removeClass('touch-active');
                }, 300);
            });
        }

        // Prevent menu from closing when clicking inside (but not on links)
        $('.menu-mobile').on('click', function(e) {
            e.stopPropagation();
        });

        // Add swipe to close functionality
        let touchStartX = 0;
        let touchEndX = 0;

        $('.menu-mobile').on('touchstart', function(e) {
            touchStartX = e.changedTouches[0].screenX;
        });

        $('.menu-mobile').on('touchend', function(e) {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        });

        function handleSwipe() {
            if (touchEndX < touchStartX - 50) {
                // Swipe left - close menu
                closeMobileMenu();
            }
        }

    });

})(jQuery);

