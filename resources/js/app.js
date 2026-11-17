import Alpine from 'alpinejs';

// Global Theme Store with persistent dark/light mode
Alpine.store('theme', {
    dark: localStorage.getItem('bisa_theme') === 'dark' ||
          (!('bisa_theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),

    init() {
        if (this.dark) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    },

    toggle() {
        document.documentElement.classList.add('theme-transitioning');
        this.dark = !this.dark;
        if (this.dark) {
            document.documentElement.classList.add('dark');
            localStorage.setItem('bisa_theme', 'dark');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('bisa_theme', 'light');
        }
        setTimeout(() => {
            document.documentElement.classList.remove('theme-transitioning');
        }, 300);
    }
});

window.Alpine = Alpine;
Alpine.start();

