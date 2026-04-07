(function() {
    function initTestimonialsSwiper() {
        if (typeof Swiper === 'undefined') return;
        var el = document.querySelector('.testimonials-swiper');
        if (!el || el.swiper) return;
        new Swiper('.testimonials-swiper', {
            slidesPerView: 1,
            slidesPerGroup: 1,
            spaceBetween: 16,
            loop: true,
            navigation: {
                nextEl: '.testimonials-next',
                prevEl: '.testimonials-prev',
            },
            pagination: {
                el: '.testimonials-pagination',
                clickable: true,
            },
            breakpoints: {
                640: { slidesPerView: 2, slidesPerGroup: 1, spaceBetween: 20 },
                992: { slidesPerView: 3, slidesPerGroup: 1, spaceBetween: 24 },
            },
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
        });
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initTestimonialsSwiper);
    } else {
        initTestimonialsSwiper();
    }
    window.addEventListener('load', function() {
        if (document.querySelector('.testimonials-swiper') && !document.querySelector('.testimonials-swiper').swiper) {
            initTestimonialsSwiper();
        }
    });
})();
