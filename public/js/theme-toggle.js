function initTheme() {
    const themeToggle = document.getElementById('theme-toggle');
    const html = document.documentElement;
    const sunIcon = document.getElementById('sun-icon');
    const moonIcon = document.getElementById('moon-icon');

    // Function to set theme
    function setTheme(theme) {
        html.setAttribute('data-theme', theme);
        localStorage.setItem('theme', theme);

        // Update icons - Re-fetch icons to ensure we have the current DOM elements
        const currentSunIcon = document.getElementById('sun-icon');
        const currentMoonIcon = document.getElementById('moon-icon');

        if (theme === 'night') {
            currentSunIcon?.classList.add('hidden');
            currentMoonIcon?.classList.remove('hidden');
        } else {
            currentSunIcon?.classList.remove('hidden');
            currentMoonIcon?.classList.add('hidden');
        }
    }

    // Initialize theme from localStorage or system preference
    const savedTheme = localStorage.getItem('theme');
    const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

    // Apply theme immediately on init
    if (savedTheme) {
        setTheme(savedTheme);
    } else if (systemPrefersDark) {
        setTheme('night');
    } else {
        setTheme('light');
    }

    // Toggle theme on click
    if (themeToggle) {
        // Remove old listener if any to prevent double firing
        themeToggle.replaceWith(themeToggle.cloneNode(true));
        const newToggle = document.getElementById('theme-toggle');

        newToggle.addEventListener('click', () => {
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'night' ? 'light' : 'night';
            setTheme(newTheme);
        });
    }
}

// Support for standard page load
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initTheme);
} else {
    initTheme();
}

// Support for Livewire wire:navigate
document.addEventListener('livewire:navigated', initTheme);

// Listen for system theme changes
window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
    if (!localStorage.getItem('theme')) {
        const html = document.documentElement;
        const newTheme = e.matches ? 'night' : 'light';
        html.setAttribute('data-theme', newTheme);

        // Update icons if elements exist
        const sunIcon = document.getElementById('sun-icon');
        const moonIcon = document.getElementById('moon-icon');
        if (newTheme === 'night') {
            sunIcon?.classList.add('hidden');
            moonIcon?.classList.remove('hidden');
        } else {
            sunIcon?.classList.remove('hidden');
            moonIcon?.classList.add('hidden');
        }
    }
});
