import lottie from 'lottie-web/build/player/lottie_light.js';

class SplashScreen {
    constructor() {
        this.animation = null;
        this.container = null;
        this.overlay = null;
        this.isVisible = false;
        this.hasShown = false;
    }

    init() {
        if (!sessionStorage.getItem('splashShown')) {
            this.createOverlay();
            this.show();
            sessionStorage.setItem('splashShown', 'true');

            setTimeout(() => {
                this.hide();
            }, 2100);
        }
    }

    createOverlay() {
        this.overlay = document.createElement('div');
        this.overlay.id = 'splashscreen-overlay';
        this.overlay.className = 'fixed inset-0 z-50 flex flex-col items-center justify-center bg-white dark:bg-gray-900';
        this.overlay.style.minHeight = '100vh';
        this.overlay.innerHTML = `
            <div class="text-center max-w-md mx-auto px-6">
                <div class="mb-8 translate-y-12">
                    <img src="/logo.png" alt="SmurfExpress Logo" class="w-20 h-20 rounded-full mx-auto mb-4">
                    <h1 class="text-3xl font-bold text-primary-900 dark:text-primary-100">SmurfExpress</h1>
                    <p class="text-gray-600 dark:text-gray-300">Trang tin tức hàng đầu Việt Nam</p>
                </div>

                <div id="lottie-splashscreen" class="w-72 h-72 mx-auto -translate-y-6"></div>

            </div>
        `;

        document.body.appendChild(this.overlay);
        this.container = document.getElementById('lottie-splashscreen');
        this.loadAnimation();
    }

    loadAnimation() {
        if (!this.container) {
            return;
        }

        try {
            this.animation = lottie.loadAnimation({
                container: this.container,
                renderer: 'svg',
                loop: true,
                autoplay: true,
                path: '/news.json'
            });

            this.animation.addEventListener('DOMLoaded', () => {
                //
            });

            this.animation.addEventListener('error', () => {
                this.showFallbackContent();
            });
        } catch (error) {
            this.showFallbackContent();
        }
    }

    showFallbackContent() {
        if (this.container) {
            this.container.innerHTML = `
                <div class="text-center">
                    <div class="w-32 h-32 mx-auto mb-4 bg-primary-900 dark:bg-primary-100-dark rounded-full flex items-center justify-center">
                        <svg class="w-20 h-20 text-white dark:text-primary-900-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2m-4-3v9M9 3h6v3H9V3z"/>
                        </svg>
                    </div>
                </div>
            `;
        }
    }

    show() {
        if (!this.overlay) return;

        this.isVisible = true;
        this.overlay.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    hide() {
        if (!this.overlay) return;

        this.isVisible = false;

        this.overlay.style.opacity = '0';
        this.overlay.style.transition = 'opacity 0.5s ease-out';

        setTimeout(() => {
            if (this.overlay && this.overlay.parentNode) {
                this.overlay.parentNode.removeChild(this.overlay);
            }
            document.body.style.overflow = '';
            this.showMainContent();
        }, 500);
    }

    showMainContent() {
        const mainContent = document.querySelector('main');
        if (mainContent) {
            mainContent.style.opacity = '0';
            mainContent.style.transition = 'opacity 0.5s ease-in';
            setTimeout(() => {
                mainContent.style.opacity = '1';
            }, 100);
        }

        const body = document.body;
        if (body) {
            body.classList.add('dark:bg-gray-900', 'dark:text-white');
        }
    }

    destroy() {
        if (this.animation) {
            this.animation.destroy();
        }
        if (this.overlay && this.overlay.parentNode) {
            this.overlay.parentNode.removeChild(this.overlay);
        }
        document.body.style.overflow = '';
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const splash = new SplashScreen();
    splash.init();

    window.splashScreen = splash;
});