/**
 * Video Testimonials Carousel
 */

// Scroll testimonials carousel
function scrollTestimonials(direction) {
    const track = document.getElementById('videoTestimonialsTrack');
    if (!track) return;

    const scrollAmount = 300; // Pixels to scroll
    const currentScroll = track.scrollLeft;

    if (direction === 'left') {
        track.scrollTo({
            left: currentScroll - scrollAmount,
            behavior: 'smooth'
        });
    } else {
        track.scrollTo({
            left: currentScroll + scrollAmount,
            behavior: 'smooth'
        });
    }
}

// Open video modal
function openVideoModal(card) {
    const videoUrl = card.getAttribute('data-video');

    // Only open modal if there's a video
    if (!videoUrl) return;

    const modal = document.getElementById('videoModal');
    const modalVideo = document.getElementById('modalVideo');

    if (modal && modalVideo) {
        // Set video source
        modalVideo.src = videoUrl;

        // Show modal
        modal.classList.add('active');

        // Play video
        modalVideo.play();

        // Prevent body scroll
        document.body.style.overflow = 'hidden';
    }
}

// Close video modal
function closeVideoModal(event) {
    // Only close if clicking on overlay or close button
    if (event.target.id === 'videoModal' ||
        event.target.classList.contains('video-modal-close') ||
        event.target.closest('.video-modal-close')) {

        const modal = document.getElementById('videoModal');
        const modalVideo = document.getElementById('modalVideo');

        if (modal && modalVideo) {
            // Hide modal
            modal.classList.remove('active');

            // Stop video
            modalVideo.pause();
            modalVideo.currentTime = 0;

            // Restore body scroll
            document.body.style.overflow = '';
        }
    }
}

// Close modal on ESC key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const modal = document.getElementById('videoModal');
        if (modal && modal.classList.contains('active')) {
            closeVideoModal({ target: modal });
        }
    }
});

// Auto-scroll functionality with infinite loop
let autoScrollInterval;
let scrollSpeed = 1; // Pixels per frame

function startAutoScroll() {
    const track = document.getElementById('videoTestimonialsTrack');
    if (!track) return;

    // Clone all cards for infinite scroll effect
    const cards = track.querySelectorAll('.video-testimonial-card');
    if (cards.length === 0) return;

    // Clone the cards and append them to create seamless loop
    cards.forEach(card => {
        const clone = card.cloneNode(true);
        track.appendChild(clone);
    });

    // Continuous smooth scrolling
    autoScrollInterval = setInterval(() => {
        track.scrollLeft += scrollSpeed;

        // Reset position when halfway through (seamless loop)
        const halfWidth = track.scrollWidth / 2;
        if (track.scrollLeft >= halfWidth) {
            track.scrollLeft = 0;
        }
    }, 16); // 60fps for smooth animation
}

function stopAutoScroll() {
    if (autoScrollInterval) {
        clearInterval(autoScrollInterval);
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const track = document.getElementById('videoTestimonialsTrack');

    if (track) {
        // Stop auto-scroll on user interaction
        track.addEventListener('mouseenter', stopAutoScroll);
        track.addEventListener('touchstart', stopAutoScroll);

        // Start auto-scroll
        startAutoScroll();

        // Enable touch/mouse drag scrolling
        let isDown = false;
        let startX;
        let scrollLeft;

        track.addEventListener('mousedown', (e) => {
            isDown = true;
            track.style.cursor = 'grabbing';
            startX = e.pageX - track.offsetLeft;
            scrollLeft = track.scrollLeft;
        });

        track.addEventListener('mouseleave', () => {
            isDown = false;
            track.style.cursor = 'grab';
        });

        track.addEventListener('mouseup', () => {
            isDown = false;
            track.style.cursor = 'grab';
        });

        track.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - track.offsetLeft;
            const walk = (x - startX) * 2;
            track.scrollLeft = scrollLeft - walk;
        });
    }
});

