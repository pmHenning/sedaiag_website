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
        const buttonSubmit = contactForm.querySelector('button[type=submit]');
        const formOverlay = contactForm.querySelector('.form__overlay');
        contactForm.addEventListener('submit', (event) => {
            event.preventDefault();
            buttonSubmit.disabled = true;
            const data = new FormData(event.target);
            const dataObject = Object.fromEntries(data.entries());
            console.log(dataObject);
            fetch('/contact', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(dataObject)
            })
                .then(res => res.json())
                .then(res => {
                    let messageText;
                    let classList = [];
                    if(res.status) {
                        contactForm.reset();
                        messageText = formOverlay.getAttribute('data-message-success');
                        classList = ['form__overlay--success', 'show'];
                    } else {
                        messageText = formOverlay.getAttribute('data-message-error');
                        classList = ['form__overlay--error', 'show'];
                    }
                    formOverlay.textContent = messageText;
                    formOverlay.classList.add(...classList);
                    setTimeout(() => {
                        formOverlay.textContent = null;
                        formOverlay.classList.remove(...classList);
                    }, 3000);
                    buttonSubmit.disabled = false;
                })
        });
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