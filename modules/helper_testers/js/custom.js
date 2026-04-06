// 1. Instantly apply the theme to block rendering of the wrong color
(function() {
    const savedColorScheme = localStorage.getItem('color-scheme');
    if (savedColorScheme === 'dark') {
        document.documentElement.style.colorScheme = 'dark';
    } else if (savedColorScheme === 'light') {
        document.documentElement.style.colorScheme = 'light';
    } else {
        // Fallback to system preference
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            document.documentElement.style.colorScheme = 'dark';
        } else {
            document.documentElement.style.colorScheme = 'light';
        }
    }
})();

// 2. Add event listeners once DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.getElementById('darkModeToggle');
    if (!toggle) return;

    // Sync toggle switch state with what was set instantly above
    if (document.documentElement.style.colorScheme === 'dark') {
        toggle.checked = true;
    } else {
        toggle.checked = false;
    }

    // Delay adding transition class to avoid initial splash transition
    setTimeout(() => {
        document.body.classList.add('theme-transitions-enabled');
    }, 50);

    toggle.addEventListener('change', function() {
        if (this.checked) {
            document.documentElement.style.colorScheme = 'dark';
            localStorage.setItem('color-scheme','dark');
        } else {
            document.documentElement.style.colorScheme = 'light';
            localStorage.setItem('color-scheme','light');
        }
    });
});
