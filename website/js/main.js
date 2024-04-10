'use strict';

(() => {
    const folders = document.querySelectorAll('.section-accordion__folder');
    for (let folder of folders) {
        folder.addEventListener('click', () => {
            folder.classList.toggle('section-accordion__folder--active');
            const panel = folder.nextElementSibling;
            panel.style.maxHeight = panel.style.maxHeight ? null : panel.scrollHeight + 'px';
        });
    }
})();