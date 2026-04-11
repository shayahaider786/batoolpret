/* ====================================
   FLOATING CARDS PARALLAX EFFECT
   ==================================== */

document.addEventListener('DOMContentLoaded', function () {
    const floatingCardsGrid = document.querySelector('.floating-cards-grid');
    const floatingCards = document.querySelectorAll('.floating-card');

    if (!floatingCardsGrid) return;

    // Parallax effect on mouse move
    document.addEventListener('mousemove', function (e) {
        const mouseX = e.clientX / window.innerWidth;
        const mouseY = e.clientY / window.innerHeight;

        floatingCards.forEach((card, index) => {
            // Calculate parallax offset
            const offsetX = (mouseX - 0.5) * 20 * (index % 2 === 0 ? 1 : -1);
            const offsetY = (mouseY - 0.5) * 20 * (index % 2 === 0 ? 1 : -1);

            // Apply transform
            card.style.setProperty('--parallax-x', offsetX + 'px');
            card.style.setProperty('--parallax-y', offsetY + 'px');

            // Update transform (combine with existing parallax)
            const currentTransform = card.style.transform;
            if (!currentTransform.includes('translate3d')) {
                card.style.transform = `${currentTransform} translate3d(${offsetX}px, ${offsetY}px, 0)`;
            }
        });
    });

    // Reset on mouse leave
    document.addEventListener('mouseleave', function () {
        floatingCards.forEach((card) => {
            card.style.transform = card.dataset.originalTransform || '';
        });
    });

    // Store original positions
    floatingCards.forEach((card) => {
        card.dataset.originalTransform = card.style.transform;
    });

    // Mobile Swipe Support
    let touchStart = null;
    let touchEnd = null;

    function handleSwipe() {
        if (!touchStart || !touchEnd) return;
        const distance = touchStart - touchEnd;
        const isLeftSwipe = distance > 50;
        const isRightSwipe = distance < -50;

        if (isLeftSwipe || isRightSwipe) {
            console.log(isLeftSwipe ? 'Swiped left' : 'Swiped right');
            // You can add carousel logic here if needed
        }
    }

    floatingCardsGrid.addEventListener('touchstart', (e) => {
        touchStart = e.changedTouches[0].screenX;
    }, false);

    floatingCardsGrid.addEventListener('touchend', (e) => {
        touchEnd = e.changedTouches[0].screenX;
        handleSwipe();
    }, false);

    // Add click handlers to cards
    floatingCards.forEach((card) => {
        card.addEventListener('click', function (e) {
            e.preventDefault();
            const link = card.getAttribute('data-link');
            if (link) {
                window.location.href = link;
            }
        });

        // Add cursor pointer on hover
        card.style.cursor = 'pointer';
    });

    // Add intersection observer for fade-in on scroll
    const observerOptions = {
        threshold: 0.2,
        rootMargin: '0px 0px -50px 0px',
    };

    const observer = new IntersectionObserver(function (entries) {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = entry.target.dataset.originalTransform || '';
            }
        });
    }, observerOptions);

    floatingCards.forEach((card) => {
        observer.observe(card);
    });
});

// Parallax scroll effect for cards (optional)
window.addEventListener('scroll', function () {
    const floatingCards = document.querySelectorAll('.floating-card');
    const scrollY = window.scrollY;

    floatingCards.forEach((card, index) => {
        const speed = 0.3 + (index * 0.05);
        const yPos = -(scrollY * speed) % 200;
        
        // Only apply on desktop
        if (window.innerWidth > 768) {
            // Subtle parallax on scroll
            card.style.setProperty('--scroll-offset', yPos + 'px');
        }
    });
});
