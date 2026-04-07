(function ($) {
    "use strict";

    /*==================================================================
    [ Swiper Hero (replaces Slick1) ]*/
    $('.wrap-slick1').each(function(){
        var $wrap = $(this);
        // ensure Swiper CSS rules apply by adding core swiper class to container
        $wrap.addClass('swiper');
        var actionTimeouts = [];

        var swiper = new Swiper(this, {
            // keep existing markup classes but also include Swiper's expected classes
            wrapperClass: 'slick1 swiper-wrapper',
            slideClass: 'item-slick1 swiper-slide',
            effect: 'fade',
            speed: 1000,
            loop: true,
            autoplay: { delay: 6000, disableOnInteraction: false },
            navigation: {
                nextEl: $wrap.find('.next-slick1')[0],
                prevEl: $wrap.find('.prev-slick1')[0]
            },
            pagination: {
                el: $wrap.find('.wrap-slick1-dots')[0],
                clickable: true,
                renderBullet: function (index, className) {
                    var $slide = $($wrap.find('.item-slick1')[index]);
                }
            },
            on: {
                init: function(){
                    var layerCurrent = $($wrap.find('.item-slick1')[0]).find('.layer-slick1');
                    clearLayerTimeouts();
                    $wrap.find('.layer-slick1').each(function(){
                        $(this).removeClass($(this).data('appear') + ' visible-true');
                    });
                    layerCurrent.each(function(i,el){
                        actionTimeouts[i] = setTimeout(function(){
                            $(el).addClass($(el).data('appear') + ' visible-true');
                        }, $(el).data('delay') || 0);
                    });
                },
                slideChange: function(){
                    var idx = this.realIndex;
                    var layerCurrent = $($wrap.find('.item-slick1')[idx]).find('.layer-slick1');
                    clearLayerTimeouts();
                    $wrap.find('.layer-slick1').each(function(){
                        $(this).removeClass($(this).data('appear') + ' visible-true');
                    });
                    layerCurrent.each(function(i,el){
                        actionTimeouts[i] = setTimeout(function(){
                            $(el).addClass($(el).data('appear') + ' visible-true');
                        }, $(el).data('delay') || 0);
                    });
                }
            }
        });

        function clearLayerTimeouts(){
            for(var i=0;i<actionTimeouts.length;i++) clearTimeout(actionTimeouts[i]);
            actionTimeouts = [];
        }
    });

    /*==================================================================
    [ DUPLICATED INNER IIFE — LEFT UNCHANGED ]
    ==================================================================*/
    (function ($) {
        "use strict";

        /*==================================================================
        [ Swiper Hero (replaces Slick1) ]*/
        $('.wrap-slick1').each(function(){
            var $wrap = $(this);
            var actionTimeouts = [];

            var swiper = new Swiper(this, {
                wrapperClass: 'slick1',
                slideClass: 'item-slick1',
                effect: 'fade',
                speed: 1000,
                loop: true,
                autoplay: { delay: 6000, disableOnInteraction: false },
                navigation: {
                    nextEl: $wrap.find('.next-slick1')[0],
                    prevEl: $wrap.find('.prev-slick1')[0]
                },
                pagination: {
                    el: $wrap.find('.wrap-slick1-dots')[0],
                    clickable: true,
                    renderBullet: function (index, className) {
                        var $slide = $($wrap.find('.item-slick1')[index]);
                        var thumb = $slide.data('thumb') || '';
                        var caption = $slide.data('caption') || '';
                        return '<span class="' + className + '">' +
                               (thumb ? '<img src="'+thumb+'">' : '') +
                               '<span class="caption-dots-slick1">'+caption+'</span></span>';
                    }
                },
                on: {
                    init: function(){
                        var layerCurrent = $($wrap.find('.item-slick1')[0]).find('.layer-slick1');
                        clearLayerTimeouts();
                        $wrap.find('.layer-slick1').each(function(){
                            $(this).removeClass($(this).data('appear') + ' visible-true');
                        });
                        layerCurrent.each(function(i,el){
                            actionTimeouts[i] = setTimeout(function(){
                                $(el).addClass($(el).data('appear') + ' visible-true');
                            }, $(el).data('delay') || 0);
                        });
                    },
                    slideChange: function(){
                        var idx = this.realIndex;
                        var layerCurrent = $($wrap.find('.item-slick1')[idx]).find('.layer-slick1');
                        clearLayerTimeouts();
                        $wrap.find('.layer-slick1').each(function(){
                            $(this).removeClass($(this).data('appear') + ' visible-true');
                        });
                        layerCurrent.each(function(i,el){
                            actionTimeouts[i] = setTimeout(function(){
                                $(el).addClass($(el).data('appear') + ' visible-true');
                            }, $(el).data('delay') || 0);
                        });
                    }
                }
            });

            function clearLayerTimeouts(){
                for(var i=0;i<actionTimeouts.length;i++) clearTimeout(actionTimeouts[i]);
                actionTimeouts = [];
            }
        });

        /*==================================================================
        [ Swiper Carousel (replaces Slick2) ]*/
        $('.wrap-slick2').each(function(){
            var $wrap = $(this);
            $wrap.addClass('swiper');

            var swiper = new Swiper(this, {
                wrapperClass: 'slick2 swiper-wrapper',
                slideClass: 'item-slick2 swiper-slide',
                slidesPerView: 4,
                slidesPerGroup: 1,
                spaceBetween: 20,
                loop: false,
                navigation: {
                    nextEl: $wrap.find('.next-slick2')[0],
                    prevEl: $wrap.find('.prev-slick2')[0]
                },
                breakpoints: {
                    1200: { slidesPerView: 4, slidesPerGroup: 1, spaceBetween: 20 },
                    992: { slidesPerView: 3, slidesPerGroup: 1, spaceBetween: 20 },
                    768: { slidesPerView: 2, slidesPerGroup: 1, spaceBetween: 15 },
                    576: { slidesPerView: 1, slidesPerGroup: 1, spaceBetween: 10 }
                }
            });

            $(document).on('shown.bs.tab', function () {
                swiper.update();
            });
        });

        /*==================================================================
        [ Swiper Single (replaces Slick3) ]*/
        $('.wrap-slick3').each(function(){
            var $wrap = $(this);
            $wrap.addClass('swiper');

            var swiper = new Swiper(this, {
                wrapperClass: 'slick3 swiper-wrapper',
                slideClass: 'item-slick3 swiper-slide',
                slidesPerView: 1,
                effect: 'fade',
                loop: true,
                navigation: {
                    nextEl: $wrap.find('.next-slick3')[0],
                    prevEl: $wrap.find('.prev-slick3')[0]
                },
                pagination: {
                    el: $wrap.find('.wrap-slick3-dots')[0],
                    clickable: true,
                    renderBullet: function(index, className){
                        var portrait = $($wrap.find('.item-slick3')[index]).data('thumb') || '';
                        return '<span class="'+className+'"><img src="'+portrait+'"/><div class="slick3-dot-overlay"></div></span>';
                    }
                }
            });
        });

    })(jQuery);

})(jQuery);
