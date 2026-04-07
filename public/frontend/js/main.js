
(function ($) {
    "use strict";

    /*[ Load page ]
    ===========================================================*/
    $(".animsition").animsition({
        inClass: 'fade-in',
        outClass: 'fade-out',
        inDuration: 1500,
        outDuration: 800,
        linkElement: '.animsition-link',
        loading: true,
        loadingParentElement: 'html',
        loadingClass: 'animsition-loading-1',
        loadingInner: '<div class="loader05"></div>',
        timeout: false,
        timeoutCountdown: 5000,
        onLoadEvent: true,
        browser: [ 'animation-duration', '-webkit-animation-duration'],
        overlay : false,
        overlayClass : 'animsition-overlay-slide',
        overlayParentElement : 'html',
        transition: function(url){ window.location.href = url; }
    });

    /*[ Back to top ]*/
    var windowH = $(window).height()/2;

    $(window).on('scroll',function(){
        if ($(this).scrollTop() > windowH) {
            $("#myBtn").css('display','flex');
        } else {
            $("#myBtn").css('display','none');
        }
    });

    $('#myBtn').on("click", function(){
        $('html, body').animate({scrollTop: 0}, 300);
    });


        /*==================================================================
        [ Fixed Header ]*/
        var headerDesktop = $('.container-menu-desktop');
        var wrapMenu = $('.wrap-menu-desktop');

        if($('.top-bar').length > 0) {
            var posWrapHeader = $('.top-bar').height();
        }
        else {
            var posWrapHeader = 0;
        }


        if($(window).scrollTop() > posWrapHeader) {
            $(headerDesktop).addClass('fix-menu-desktop');
            $(wrapMenu).css('top',0);
        }
        else {
            $(headerDesktop).removeClass('fix-menu-desktop');
            $(wrapMenu).css('top',posWrapHeader - $(this).scrollTop());
        }

        $(window).on('scroll',function(){
            if($(this).scrollTop() > posWrapHeader) {
                $(headerDesktop).addClass('fix-menu-desktop');
                $(wrapMenu).css('top',0);
            }
            else {
                $(headerDesktop).removeClass('fix-menu-desktop');
                $(wrapMenu).css('top',posWrapHeader - $(this).scrollTop());
            }
        });


        /*==================================================================
        [ Menu mobile ]*/
        // Mobile menu handler moved to mobile-menu.js for better organization
        // $('.btn-show-menu-mobile').on('click', function(){
        //     $(this).toggleClass('is-active');
        //     $('.menu-mobile').slideToggle();
        // });

        var arrowMainMenu = $('.arrow-main-menu-m');

        for(var i=0; i<arrowMainMenu.length; i++){
            $(arrowMainMenu[i]).on('click', function(){
                $(this).parent().find('.sub-menu-m').slideToggle();
                $(this).toggleClass('turn-arrow-main-menu-m');
            })
        }

        // Window resize handler moved to mobile-menu.js
        // $(window).resize(function(){
        //     if($(window).width() >= 992){
        //         if($('.menu-mobile').css('display') == 'block') {
        //             $('.menu-mobile').css('display','none');
        //             $('.btn-show-menu-mobile').toggleClass('is-active');
        //         }

        //         $('.sub-menu-m').each(function(){
        //             if($(this).css('display') == 'block') { console.log('hello');
        //                 $(this).css('display','none');
        //                 $(arrowMainMenu).removeClass('turn-arrow-main-menu-m');
        //             }
        //         });

        //     }
        // });


        /*==================================================================
        [ Show / hide modal search ]*/
        $('.js-show-modal-search').on('click', function(){
            $('.modal-search-header').addClass('show-modal-search');
            $(this).css('opacity','0');
            $('.search-input').focus();
        });

        $('.js-hide-modal-search').on('click', function(){
            $('.modal-search-header').removeClass('show-modal-search');
            $('.js-show-modal-search').css('opacity','1');
            $('.search-input').val('');
            $('#searchResults').html('<div class="search-no-results">Start typing to search for products...</div>').removeClass('show');
        });

        $('.container-search-header').on('click', function(e){
            e.stopPropagation();
        });

        // Close modal when clicking outside
        $('.modal-search-header').on('click', function(e){
            if (e.target === this) {
                $('.js-hide-modal-search').click();
            }
        });

        // Search input functionality with AJAX
        let searchTimeout;
        let isSearching = false;

        $('#search-input').on('keyup', function(){
            clearTimeout(searchTimeout);
            let searchTerm = $(this).val().trim();

            if(searchTerm.length === 0) {
                $('#searchResults').html('<div class="search-no-results">Start typing to search for products...</div>').removeClass('show');
                return;
            }

            if(searchTerm.length < 2) {
                $('#searchResults').html('<div class="search-no-results">Please enter at least 2 characters...</div>').removeClass('show');
                return;
            }

            // Debounce search - wait 300ms after user stops typing
            searchTimeout = setTimeout(function(){
                if(!isSearching) {
                    performSearch(searchTerm);
                }
            }, 300);
        });

        function performSearch(searchTerm) {
            isSearching = true;
            $('#searchResults').html('<div class="search-loading">Searching...</div>').addClass('show');

            $.ajax({
                url: '/search/products',
                method: 'GET',
                data: { q: searchTerm },
                success: function(response) {
                    isSearching = false;
                    if(response.success && response.products.length > 0) {
                        displaySearchResults(response.products);
                    } else {
                        $('#searchResults').html('<div class="search-no-results">No products found matching "' + searchTerm + '"</div>').addClass('show');
                    }
                },
                error: function(xhr) {
                    isSearching = false;
                    $('#searchResults').html('<div class="search-no-results">Error searching products. Please try again.</div>').addClass('show');
                }
            });
        }

        function displaySearchResults(products) {
            let html = '<div class="search-results-list">';

            products.forEach(function(product) {
                let price = product.discount_price ? product.discount_price : product.price;
                let originalPrice = product.discount_price && product.discount_price < product.price
                    ? '<span class="search-product-original-price">Rs. ' + parseInt(product.price).toLocaleString() + '</span>'
                    : '';

                html += '<a href="' + product.url + '" class="search-result-item">';
                html += '<div class="search-result-image">';
                html += '<img src="' + product.image + '" alt="' + product.name + '" loading="lazy">';
                html += '</div>';
                html += '<div class="search-result-info">';
                html += '<div class="search-result-name">' + product.name + '</div>';
                html += '<div class="search-result-price">';
                html += 'Rs. ' + parseInt(price).toLocaleString();
                if(originalPrice) {
                    html += ' ' + originalPrice;
                }
                html += '</div>';
                html += '</div>';
                html += '</a>';
            });

            html += '</div>';
            $('#searchResults').html(html).addClass('show');
        }

        // Handle search form submission - redirect to shop page with search term
        $('#search-form').on('submit', function(e){
            e.preventDefault();
            let searchTerm = $('#search-input').val().trim();
            if(searchTerm.length >= 2) {
                window.location.href = '/shop?search=' + encodeURIComponent(searchTerm);
            }
        });


        /*==================================================================
        [ Removed Isotope and Filter functionality for lightweight shop page ]*/




        /*==================================================================
        [ Cart ]*/
        $('.js-show-cart').on('click',function(e){
            // If this element is an anchor link to the cart page, allow navigation and do not open the drawer.
            if ($(this).is('a') && $(this).attr('href')) {
                return; // let browser handle navigation
            }
            $('.js-panel-cart').addClass('show-header-cart');
        });

        $('.js-hide-cart').on('click',function(){
            $('.js-panel-cart').removeClass('show-header-cart');
        });

        /*==================================================================
        [ Sidebar - Removed - Not used in this project ]*/

        /*==================================================================
        [ +/- num product ]*/
        // Removed - handled by page-specific scripts to avoid conflicts

        /*==================================================================
        [ Rating ]*/
        $('.wrap-rating').each(function(){
            var item = $(this).find('.item-rating');
            var rated = -1;
            var input = $(this).find('input');
            $(input).val(0);

            $(item).on('mouseenter', function(){
                var index = item.index(this);
                var i = 0;
                for(i=0; i<=index; i++) {
                    $(item[i]).removeClass('zmdi-star-outline');
                    $(item[i]).addClass('zmdi-star');
                }

                for(var j=i; j<item.length; j++) {
                    $(item[j]).addClass('zmdi-star-outline');
                    $(item[j]).removeClass('zmdi-star');
                }
            });

            $(item).on('click', function(){
                var index = item.index(this);
                rated = index;
                $(input).val(index+1);
            });

            $(this).on('mouseleave', function(){
                var i = 0;
                for(i=0; i<=rated; i++) {
                    $(item[i]).removeClass('zmdi-star-outline');
                    $(item[i]).addClass('zmdi-star');
                }

                for(var j=i; j<item.length; j++) {
                    $(item[j]).addClass('zmdi-star-outline');
                    $(item[j]).removeClass('zmdi-star');
                }
            });
        });

        /*==================================================================
        [ Product Card Click Handler ]*/
        // clicking the product image/card should navigate to product-detail
        $(document).on('click', '.product-card .product-image', function(e){
            var href = $(this).closest('.product-card').find('.product-name a').attr('href');
            if (href) window.location = href;
        });

        /*==================================================================
        [ Image Zoom - Removed - Not used in this project ]*/

        $('.js-hide-modal1').on('click',function(){
            $('.js-modal1').removeClass('show-modal1');
        });


        /*[ Hero Slider ]
        ===========================================================*/
        // Hero Slider Variables
        let heroCurrentSlide = 0;
        const heroSlides = document.querySelectorAll('.hero-slide-item');
        const heroDots = document.querySelectorAll('.hero-pagination-dot');
        const heroSliderContainer = document.querySelector('.hero-slider-container');
        let heroAutoSlideTimeout;

        // Touch and Drag variables
        let heroTouchStartX = 0;
        let heroTouchEndX = 0;
        let heroDragStartX = 0;
        let heroDragging = false;

        // Function to show a specific slide
        function heroGoToSlide(slideIndex) {
            // Remove active class from all slides
            heroSlides.forEach(slide => slide.classList.remove('hero-active-slide'));
            heroDots.forEach(dot => dot.classList.remove('hero-dot-active'));

            // Add active class to current slide
            if (slideIndex >= heroSlides.length) {
                heroCurrentSlide = 0;
            } else if (slideIndex < 0) {
                heroCurrentSlide = heroSlides.length - 1;
            } else {
                heroCurrentSlide = slideIndex;
            }

            heroSlides[heroCurrentSlide].classList.add('hero-active-slide');
            heroDots[heroCurrentSlide].classList.add('hero-dot-active');

            // Reset auto-slide timer
            clearTimeout(heroAutoSlideTimeout);
            heroAutoSlideTimeout = setTimeout(heroAutoSlide, 5000);
        }

        // Function to auto-advance slides
        function heroAutoSlide() {
            heroGoToSlide(heroCurrentSlide + 1);
        }

        // Touch Events for Mobile Swipe
        if (heroSliderContainer) {
            heroSliderContainer.addEventListener('touchstart', (e) => {
                heroTouchStartX = e.changedTouches[0].screenX;
                heroDragging = true;
            }, { passive: true });

            heroSliderContainer.addEventListener('touchmove', (e) => {
                heroTouchEndX = e.changedTouches[0].screenX;
            }, { passive: true });

            heroSliderContainer.addEventListener('touchend', (e) => {
                heroDragging = false;
                heroHandleSwipe();
            }, { passive: true });

            // Mouse Events for Desktop Drag
            heroSliderContainer.addEventListener('mousedown', (e) => {
                heroDragStartX = e.clientX;
                heroDragging = true;
                heroSliderContainer.style.cursor = 'grabbing';
            });

            heroSliderContainer.addEventListener('mousemove', (e) => {
                if (heroDragging) {
                    heroTouchEndX = e.clientX;
                }
            });

            heroSliderContainer.addEventListener('mouseup', (e) => {
                heroDragging = false;
                heroSliderContainer.style.cursor = 'grab';
                heroHandleSwipe();
            });

            heroSliderContainer.addEventListener('mouseleave', () => {
                if (heroDragging) {
                    heroDragging = false;
                    heroSliderContainer.style.cursor = 'grab';
                    heroHandleSwipe();
                }
            });

            // Set initial cursor style
            heroSliderContainer.style.cursor = 'grab';
        }

        // Function to handle swipe direction
        function heroHandleSwipe() {
            const swipeThreshold = 50; // Minimum swipe distance in pixels
            const swipeDifference = heroTouchStartX - heroTouchEndX;

            // Swipe left - go to next slide
            if (swipeDifference > swipeThreshold) {
                heroGoToSlide(heroCurrentSlide + 1);
            }
            // Swipe right - go to previous slide
            else if (swipeDifference < -swipeThreshold) {
                heroGoToSlide(heroCurrentSlide - 1);
            }
        }

        // Initialize hero slider
        if (heroSlides.length > 0) {
            heroGoToSlide(0);
        }




    })(jQuery);
