// Premium Navbar & Bottom Navigation Handler
document.addEventListener('DOMContentLoaded', function() {
  // Detect current page and activate appropriate bottom nav item
  const currentPage = window.location.pathname.split('/').pop() || 'index.html';
  const navItems = document.querySelectorAll('.bottom-nav-item');

  navItems.forEach(item => {
    const href = item.getAttribute('href');
    if (href === currentPage || (currentPage === '' && href === 'index.html')) {
      item.classList.add('active');
    } else {
      item.classList.remove('active');
    }
  });

  // Add bottom padding to body for mobile/tablet
  const addBottomNavPadding = () => {
    if (window.innerWidth <= 991) {
      document.body.classList.add('has-bottom-nav');
    } else {
      document.body.classList.remove('has-bottom-nav');
    }
  };

  addBottomNavPadding();
  window.addEventListener('resize', addBottomNavPadding);

  // Smooth scroll effect for navbar on scroll (Desktop only)
  const menuDesktop = document.querySelector('.wrap-menu-desktop');
  if (menuDesktop && window.innerWidth > 991) {
    window.addEventListener('scroll', () => {
      const scrollY = window.scrollY;

      if (scrollY > 50) {
        menuDesktop.classList.add('scrolled');
      } else {
        menuDesktop.classList.remove('scrolled');
      }
    });
  }

  // ===== AUTO-HIDE MOBILE HEADER ON SCROLL =====
  if (window.innerWidth <= 1199) {
    const headerMobile = document.querySelector('.wrap-header-mobile');
    const bottomNav = document.querySelector('.bottom-nav-mobile');
    let lastScrollY = 0;
    let isHeaderHidden = false;

    window.addEventListener('scroll', () => {
      const currentScrollY = window.scrollY;
      const scrollDirection = currentScrollY > lastScrollY ? 'down' : 'up';
      const scrollDifference = Math.abs(currentScrollY - lastScrollY);

      // Only hide/show after scrolling more than 5px to avoid flickering
      if (scrollDifference > 5) {
        if (scrollDirection === 'down' && currentScrollY > 100) {
          // Scroll down - hide header and nav
          if (!isHeaderHidden) {
            headerMobile?.classList.add('hide-header');
            bottomNav?.classList.add('hide-nav');
            isHeaderHidden = true;
          }
        } else {
          // Scroll up - show header and nav
          if (isHeaderHidden) {
            headerMobile?.classList.remove('hide-header');
            bottomNav?.classList.remove('hide-nav');
            isHeaderHidden = false;
          }
        }
        lastScrollY = currentScrollY;
      }
    }, { passive: true });
  }

  // ===== CART PREVIEW DRAWER =====
  const cartButton = document.querySelector('.js-show-cart');
  const cartPreviewOverlay = document.querySelector('.cart-preview-overlay');
  const cartPreviewDrawer = document.querySelector('.cart-preview-drawer');
  const cartPreviewClose = document.querySelector('.cart-preview-close');

  if (cartButton && cartPreviewDrawer) {
    cartButton.addEventListener('click', (e) => {
      // If this button is an anchor link (navigates to cart), allow the browser to follow it.
      if (e.currentTarget && e.currentTarget.tagName && e.currentTarget.tagName.toLowerCase() === 'a') {
        return; // let the navigation happen
      }

      if (window.innerWidth <= 1199) {
        cartPreviewOverlay?.classList.add('active');
        cartPreviewDrawer.classList.add('active');
        document.body.style.overflow = 'hidden';
      }
    });
  }

  if (cartPreviewClose) {
    cartPreviewClose.addEventListener('click', () => {
      cartPreviewOverlay?.classList.remove('active');
      cartPreviewDrawer?.classList.remove('active');
      document.body.style.overflow = 'auto';
    });
  }

  if (cartPreviewOverlay) {
    cartPreviewOverlay.addEventListener('click', () => {
      cartPreviewOverlay.classList.remove('active');
      cartPreviewDrawer?.classList.remove('active');
      document.body.style.overflow = 'auto';
    });
  }

  // ===== RESPONSIVE NAV ITEMS (hide labels on very small screens) =====
  const updateNavItemsForScreenSize = () => {
    const navItems = document.querySelectorAll('.bottom-nav-item');
    if (window.innerWidth < 360) {
      navItems.forEach(item => item.classList.add('label-hidden'));
    } else {
      navItems.forEach(item => item.classList.remove('label-hidden'));
    }
  };

  updateNavItemsForScreenSize();
  window.addEventListener('resize', updateNavItemsForScreenSize);
});
