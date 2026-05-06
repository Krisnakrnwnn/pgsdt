document.addEventListener('DOMContentLoaded', function() {
    // ── Intersection Observer (AOS Replacement) ───────────────────────────
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                const delay = entry.target.dataset.aosDelay || 0;
                setTimeout(() => {
                    entry.target.classList.add('aos-animate');
                }, parseInt(delay));
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

    document.querySelectorAll('[data-aos]').forEach((el) => observer.observe(el));

    // ── Mobile Menu ──────────────────────────────────────────────────────
    const toggle = document.getElementById('mobile-toggle');
    const overlay = document.getElementById('mobile-overlay');
    const backdrop = document.getElementById('mobile-backdrop');

    if (toggle && overlay && backdrop) {
        const openMobileMenu = () => {
            backdrop.style.display = 'block';
            overlay.style.display = 'flex';
            document.body.style.overflow = 'hidden';
            toggle.setAttribute('aria-expanded', 'true');
            toggle.classList.add('is-open');
        };

        const closeMobileMenu = () => {
            backdrop.style.display = 'none';
            overlay.style.display = 'none';
            document.body.style.overflow = '';
            toggle.setAttribute('aria-expanded', 'false');
            toggle.classList.remove('is-open');
        };

        toggle.addEventListener('click', () => {
            const isOpen = toggle.getAttribute('aria-expanded') === 'true';
            isOpen ? closeMobileMenu() : openMobileMenu();
        });

        // Close on escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeMobileMenu();
        });

        // Attach to window for legacy onclick attributes in Blade
        window.closeMobileMenu = closeMobileMenu;
    }

    // ── Profile Dropdown ─────────────────────────────────────────────────
    const profileDropdown = document.getElementById('profile-dropdown');
    if (profileDropdown) {
        window.toggleProfileDropdown = () => {
            profileDropdown.style.display = profileDropdown.style.display === 'none' || profileDropdown.style.display === '' ? 'block' : 'none';
        };

        document.addEventListener('click', (event) => {
            if (profileDropdown.style.display === 'block') {
                const trigger = profileDropdown.previousElementSibling;
                if (!profileDropdown.contains(event.target) && !trigger.contains(event.target)) {
                    profileDropdown.style.display = 'none';
                }
            }
        });
    }

    // ── Flash Messages ───────────────────────────────────────────────────
    const flashToast = document.getElementById('flash-toast');
    if (flashToast) {
        setTimeout(() => {
            flashToast.style.transition = 'opacity 0.5s ease';
            flashToast.style.opacity = '0';
            setTimeout(() => flashToast.remove(), 500);
        }, 5000);
    }

    // ── Form Loading State ───────────────────────────────────────────────
    document.addEventListener('submit', (e) => {
        const form = e.target;
        if (form.dataset.noLoading) return;

        const btn = form.querySelector('button[type="submit"]');
        if (!btn) return;

        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = `<span style="display:inline-flex;align-items:center;gap:8px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="animation:spin 1s linear infinite;">
                <path d="M21 12a9 9 0 11-6.219-8.56"/>
            </svg>Memproses...</span>`;

        window.addEventListener('pageshow', () => {
            btn.disabled = false;
            btn.innerHTML = originalText;
        });
    });
});
