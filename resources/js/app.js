import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// Keep CSRF token fresh on pages left open a long time (prevents 419 Page Expired)
const refreshCsrfToken = async () => {
    try {
        const res = await fetch('/csrf-token', { headers: { 'Accept': 'application/json' } });
        if (!res.ok) return;
        const { token } = await res.json();
        document.querySelector('meta[name="csrf-token"]')?.setAttribute('content', token);
        document.querySelectorAll('input[name="_token"]').forEach(el => el.value = token);
    } catch (e) { /* offline — try again next interval */ }
};
setInterval(refreshCsrfToken, 10 * 60 * 1000);
// Also refresh when the user returns to a backgrounded tab
document.addEventListener('visibilitychange', () => {
    if (document.visibilityState === 'visible') refreshCsrfToken();
});

document.addEventListener('DOMContentLoaded', () => {
    const targets = document.querySelectorAll('[data-reveal]');
    if (!targets.length) return;

    if (!('IntersectionObserver' in window)) {
        targets.forEach(el => el.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15 });

    targets.forEach(el => observer.observe(el));
});
