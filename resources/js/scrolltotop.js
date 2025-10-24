document.addEventListener('DOMContentLoaded', function () {
    const scrollToTopBtn = document.createElement('button');
    scrollToTopBtn.id = 'scrollToTopBtn';
    scrollToTopBtn.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
    `;
    scrollToTopBtn.setAttribute('aria-label', 'Scroll to top');
    scrollToTopBtn.classList.add('scroll-to-top-btn', 'hidden');

    document.body.appendChild(scrollToTopBtn);

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

    scrollToTopBtn.addEventListener('click', function () {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });

        scrollToTopBtn.classList.add('clicked');
        setTimeout(() => {
            scrollToTopBtn.classList.remove('clicked');
        }, 300);
    });

    scrollToTopBtn.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            scrollToTopBtn.click();
        }
    });
});
