import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Dark mode initialization
if (localStorage.getItem('darkMode') === 'true') {
    document.documentElement.classList.add('dark');
}
