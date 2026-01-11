/**
 * Global Loading Spinner Handler
 * Handles forms with 'data-loading' attribute
 */
document.addEventListener('submit', function(e) {
    const form = e.target.closest('form[data-loading]');
    if (!form) return;

    const submitBtn = form.querySelector('button[type="submit"]');
    if (!submitBtn) return;

    // Prevent double submission if already loading
    if (submitBtn.disabled) return;

    const spinner = submitBtn.querySelector('.loading');
    const btnText = submitBtn.querySelector('.btn-text');
    const loadingText = form.getAttribute('data-loading-text') || 'Menyimpan...';

    submitBtn.disabled = true;
    if (spinner) spinner.classList.remove('hidden');
    if (btnText) btnText.innerText = loadingText;
});
