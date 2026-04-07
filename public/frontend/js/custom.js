// Slider functionality
        let wfCurrentSlide = 1; // Start with middle card
        const wfSliderTrack = document.getElementById('wfSliderTrack');
        const wfCards = document.querySelectorAll('.wf-cards-slider .wf-video-card');
        const wfDots = document.querySelectorAll('.wf-dot');

        function wfUpdateSlider() {
            if (window.innerWidth <= 1199) {
                const cardWidth = wfCards[0].offsetWidth;
                const gap = 20;
                const offset = -(wfCurrentSlide * (cardWidth + gap));
                
                wfSliderTrack.style.transform = `translateX(${offset}px)`;

                // Update center card styling
                wfCards.forEach((card, index) => {
                    if (index === wfCurrentSlide) {
                        card.classList.add('wf-center-card');
                    } else {
                        card.classList.remove('wf-center-card');
                    }
                });

                // Update dots
                wfDots.forEach((dot, index) => {
                    if (index === wfCurrentSlide) {
                        dot.classList.add('wf-active');
                    } else {
                        dot.classList.remove('wf-active');
                    }
                });
            }
        }

        function wfGoToSlide(index) {
            wfCurrentSlide = index;
            wfUpdateSlider();
        }

        // Touch events for mobile swipe
        let wfTouchStartX = 0;
        let wfTouchEndX = 0;

        if (wfSliderTrack) {
            wfSliderTrack.addEventListener('touchstart', (e) => {
                wfTouchStartX = e.changedTouches[0].screenX;
            }, { passive: true });

            wfSliderTrack.addEventListener('touchend', (e) => {
                wfTouchEndX = e.changedTouches[0].screenX;
                wfHandleSwipe();
            }, { passive: true });
        }

        function wfHandleSwipe() {
            if (wfTouchEndX < wfTouchStartX - 50 && wfCurrentSlide < wfCards.length - 1) {
                wfCurrentSlide++;
                wfUpdateSlider();
            }
            if (wfTouchEndX > wfTouchStartX + 50 && wfCurrentSlide > 0) {
                wfCurrentSlide--;
                wfUpdateSlider();
            }
        }

        // Initialize slider on load and resize
        window.addEventListener('load', wfUpdateSlider);
        window.addEventListener('resize', wfUpdateSlider);

        // Removed hover play/pause handlers so videos always play

        // Ensure videos attempt to autoplay on load (muted required for autoplay)
        window.addEventListener('load', function() {
            document.querySelectorAll('video').forEach(video => {
                try {
                    video.muted = true;
                    const playPromise = video.play();
                    if (playPromise && playPromise.catch) playPromise.catch(()=>{});
                } catch (e) {
                    // ignore errors
                }
            });
        });

        // ==================== Collections Slider ====================
        let collectionsCurrentSlide = 0;
        const collectionsSliderTrack = document.getElementById('collectionsSliderTrack');
        const collectionsItems = document.querySelectorAll('.collections-slider-item');
        const collectionsDots = document.querySelectorAll('.collections-dot');
        const collectionsNextBtn = document.getElementById('collectionsNextBtn');
        const collectionsPrevBtn = document.getElementById('collectionsPrevBtn');

        function getCollectionsItemsPerView() {
            if (window.innerWidth >= 1200) return 4;
            if (window.innerWidth >= 992) return 3;
            if (window.innerWidth >= 768) return 2;
            return 1;
        }

        function collectionsUpdateSlider() {
            if (!collectionsItems || collectionsItems.length === 0 || !collectionsSliderTrack) {
                return;
            }
            
            const itemsPerView = getCollectionsItemsPerView();
            const maxSlides = collectionsItems.length - itemsPerView;

            // Clamp current slide
            if (collectionsCurrentSlide > maxSlides) {
                collectionsCurrentSlide = maxSlides;
            }

            const itemWidth = collectionsItems[0].offsetWidth;
            const gap = parseFloat(window.getComputedStyle(collectionsSliderTrack).gap) || 20;
            const offset = -(collectionsCurrentSlide * (itemWidth + gap));

            collectionsSliderTrack.style.transform = `translateX(${offset}px)`;

            // Update dots
            collectionsDots.forEach((dot, index) => {
                if (index === collectionsCurrentSlide) {
                    dot.classList.add('collections-dot-active');
                } else {
                    dot.classList.remove('collections-dot-active');
                }
            });

            // Enable/disable buttons
            collectionsPrevBtn.disabled = collectionsCurrentSlide === 0;
            collectionsNextBtn.disabled = collectionsCurrentSlide === maxSlides;

            collectionsPrevBtn.style.opacity = collectionsCurrentSlide === 0 ? '0.5' : '1';
            collectionsNextBtn.style.opacity = collectionsCurrentSlide === maxSlides ? '0.5' : '1';
        }

        function collectionsGoToSlide(index) {
            collectionsCurrentSlide = index;
            collectionsUpdateSlider();
        }

        function collectionsNextSlide() {
            const itemsPerView = getCollectionsItemsPerView();
            const maxSlides = collectionsItems.length - itemsPerView;
            if (collectionsCurrentSlide < maxSlides) {
                collectionsCurrentSlide++;
                collectionsUpdateSlider();
            }
        }

        function collectionsPrevSlide() {
            if (collectionsCurrentSlide > 0) {
                collectionsCurrentSlide--;
                collectionsUpdateSlider();
            }
        }

        // Add button event listeners
        if (collectionsNextBtn) {
            collectionsNextBtn.addEventListener('click', collectionsNextSlide);
        }
        if (collectionsPrevBtn) {
            collectionsPrevBtn.addEventListener('click', collectionsPrevSlide);
        }

        // Touch events for collections slider
        let collectionsTouchStartX = 0;
        let collectionsTouchEndX = 0;

        if (collectionsSliderTrack) {
            collectionsSliderTrack.addEventListener('touchstart', (e) => {
                collectionsTouchStartX = e.changedTouches[0].screenX;
            }, { passive: true });

            collectionsSliderTrack.addEventListener('touchend', (e) => {
                collectionsTouchEndX = e.changedTouches[0].screenX;
                collectionsHandleSwipe();
            }, { passive: true });
        }

        function collectionsHandleSwipe() {
            const itemsPerView = getCollectionsItemsPerView();
            const maxSlides = collectionsItems.length - itemsPerView;

            if (collectionsTouchEndX < collectionsTouchStartX - 50 && collectionsCurrentSlide < maxSlides) {
                collectionsCurrentSlide++;
                collectionsUpdateSlider();
            }
            if (collectionsTouchEndX > collectionsTouchStartX + 50 && collectionsCurrentSlide > 0) {
                collectionsCurrentSlide--;
                collectionsUpdateSlider();
            }
        }

        // Initialize collections slider
        window.addEventListener('load', collectionsUpdateSlider);
        window.addEventListener('resize', collectionsUpdateSlider);

        // ==================== Circle Slider ====================
        // Enable drag to scroll functionality
        const rtwSlider = document.querySelector('.rtw-categories-wrapper');
        if (rtwSlider) {
            let rtwIsDown = false;
            let rtwStartX;
            let rtwScrollLeft;

            rtwSlider.addEventListener('mousedown', (e) => {
            rtwIsDown = true;
            rtwSlider.style.cursor = 'grabbing';
            rtwStartX = e.pageX - rtwSlider.offsetLeft;
            rtwScrollLeft = rtwSlider.scrollLeft;
        });

        rtwSlider.addEventListener('mouseleave', () => {
            rtwIsDown = false;
            rtwSlider.style.cursor = 'grab';
        });

        rtwSlider.addEventListener('mouseup', () => {
            rtwIsDown = false;
            rtwSlider.style.cursor = 'grab';
        });

            rtwSlider.addEventListener('mousemove', (e) => {
                if (!rtwIsDown) return;
                e.preventDefault();
                const x = e.pageX - rtwSlider.offsetLeft;
                const walk = (x - rtwStartX) * 2;
                rtwSlider.scrollLeft = rtwScrollLeft - walk;
            });
        }
        // new slider javascript
           let heroCurrentSlide = 0;
        let heroSlideInterval;
        const heroSlides = document.querySelectorAll('.hero-slide-item');
        const heroDots = document.querySelectorAll('.hero-pagination-dot');

        function heroShowSlide(index) {
            // Remove active class from all slides and dots
            heroSlides.forEach(slide => slide.classList.remove('hero-active-slide'));
            heroDots.forEach(dot => dot.classList.remove('hero-dot-active'));

            // Add active class to current slide and dot
            heroSlides[index].classList.add('hero-active-slide');
            heroDots[index].classList.add('hero-dot-active');
        }

        function heroChangeSlide(direction) {
            heroCurrentSlide += direction;

            // Loop slides
            if (heroCurrentSlide >= heroSlides.length) {
                heroCurrentSlide = 0;
            } else if (heroCurrentSlide < 0) {
                heroCurrentSlide = heroSlides.length - 1;
            }

            heroShowSlide(heroCurrentSlide);
            heroResetInterval();
        }

        // Touch swipe support
        let heroTouchStartX = 0;
        let heroTouchEndX = 0;

        document.querySelector('.hero-slider-container').addEventListener('touchstart', (e) => {
            heroTouchStartX = e.changedTouches[0].screenX;
        });

        document.querySelector('.hero-slider-container').addEventListener('touchend', (e) => {
            heroTouchEndX = e.changedTouches[0].screenX;
            heroHandleSwipe();
        });

        function heroHandleSwipe() {
            if (heroTouchEndX < heroTouchStartX - 50) {
                heroChangeSlide(1); // Swipe left
            }
            if (heroTouchEndX > heroTouchStartX + 50) {
                heroChangeSlide(-1); // Swipe right
            }
        }
        //
        function heroGoToSlide(index) {
            heroCurrentSlide = index;
            heroShowSlide(heroCurrentSlide);
            heroResetInterval();
        }

        function heroAutoSlide() {
            heroCurrentSlide++;
            if (heroCurrentSlide >= heroSlides.length) {
                heroCurrentSlide = 0;
            }
            heroShowSlide(heroCurrentSlide);
        }

        function heroResetInterval() {
            clearInterval(heroSlideInterval);
            heroSlideInterval = setInterval(heroAutoSlide, 5000);
        }

        // Auto slide every 5 seconds
        heroSlideInterval = setInterval(heroAutoSlide, 5000);

        // Pause on hover
        document.querySelector('.hero-slider-container').addEventListener('mouseenter', () => {
            clearInterval(heroSlideInterval);
        });

        document.querySelector('.hero-slider-container').addEventListener('mouseleave', () => {
            heroSlideInterval = setInterval(heroAutoSlide, 5000);
        });
        	