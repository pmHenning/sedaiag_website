'use strict';

/**
 * Setup accordion
 */
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

/**
 * Setup contact form
 */
(() => {
    const contactForm = document.querySelector('#contact-form');
    if(contactForm) {
        const formOverlay = contactForm.querySelector('.form__overlay');
        const buttonSubmit = contactForm.querySelector('button[type=submit]');
        contactForm.addEventListener('submit', (event) => {
            event.preventDefault();
            buttonSubmit.disabled = true;
            const data = new FormData(event.target);
            const dataObject = Object.fromEntries(data.entries());
            fetch('/contact.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(dataObject)
            })
                .then(res => res.json())
                .then(res => {
                    if(res.status) {
                        showContactFormSuccessMessage(formOverlay);
                        contactForm.reset();
                    } else {
                        showContactFormErrorMessage(formOverlay);
                    }
                    buttonSubmit.disabled = false;
                })
                .catch(err => {
                    showContactFormErrorMessage(formOverlay);
                    buttonSubmit.disabled = false;
                })
        });
    }

    function showContactFormErrorMessage(formOverlay) {
        showContactFormMessage(
            formOverlay,
            formOverlay.getAttribute('data-message-error'),
            ['form__overlay--error', 'show'],
            3000
        );
    }

    function showContactFormSuccessMessage(formOverlay) {
        showContactFormMessage(
            formOverlay,
            formOverlay.getAttribute('data-message-success'),
            ['form__overlay--success', 'show'],
            3000
        );
    }

    function showContactFormMessage(formOverlay, text, classList, duration) {
        formOverlay.textContent = text;
        formOverlay.classList.add(...classList);
        setTimeout(() => {
            formOverlay.textContent = null;
            formOverlay.classList.remove(...classList);
        }, duration);
    }
})();

/**
 * Setup scroll buttons
 */
(() => {
    const scrollToButtons = document.querySelectorAll('[data-scrollTo]');
    if(scrollToButtons.length) {
        scrollToButtons.forEach(button => {
            button.addEventListener('click', (event) => {
                const targetSelector = button.getAttribute('data-scrollTo');
                const target = document.querySelector(targetSelector);
                if(target) {
                    target.scrollIntoView({ behavior: "smooth" });
                }
            })
        })
    }
})();