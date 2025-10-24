// Scroll to Top Functionality
document.addEventListener('DOMContentLoaded', function () {
    // Create scroll to top button
    const scrollToTopBtn = document.createElement('button');
    scrollToTopBtn.id = 'scrollToTopBtn';
    scrollToTopBtn.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
    `;
    scrollToTopBtn.setAttribute('aria-label', 'Scroll to top');
    scrollToTopBtn.classList.add('scroll-to-top-btn', 'hidden');

    // Append button to body
    document.body.appendChild(scrollToTopBtn);

    // Show/hide button on scroll
    let scrollTimeout;
    window.addEventListener('scroll', function () {
        clearTimeout(scrollTimeout);

        if (window.pageYOffset > 300) {
            scrollToTopBtn.classList.remove('hidden');
            scrollToTopBtn.classList.add('show');
        } else {
            scrollToTopBtn.classList.remove('show');
            scrollTimeout = setTimeout(() => {
                scrollToTopBtn.classList.add('hidden');
            }, 300);
        }
    });

    // Scroll to top on click with smooth animation
    scrollToTopBtn.addEventListener('click', function () {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });

        // Add click animation
        scrollToTopBtn.classList.add('clicked');
        setTimeout(() => {
            scrollToTopBtn.classList.remove('clicked');
        }, 300);
    });

    // Add keyboard accessibility
    scrollToTopBtn.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            scrollToTopBtn.click();
        }
    });
});
