const addToCartButtons = document.querySelectorAll('.add-to-cart-button');
const cartFeedback = document.querySelector('.cart-feedback');

addToCartButtons.forEach((button) => {
    button.addEventListener('click', () => {
        const originalLabel = 'Add to cart';
        button.textContent = 'Added';
        button.classList.add('is-added');
        cartFeedback.textContent = `${button.dataset.product} added to your cart.`;

        window.setTimeout(() => {
            button.textContent = originalLabel;
            button.classList.remove('is-added');
        }, 1800);
    });
});

const newsletterForm = document.querySelector('.newsletter-form');

if (newsletterForm) {
    const emailInput = newsletterForm.querySelector('input[type="email"]');
    const feedback = newsletterForm.querySelector('.newsletter-feedback');

    newsletterForm.addEventListener('submit', (event) => {
        event.preventDefault();
        feedback.classList.remove('is-error');

        if (!emailInput.value.trim() || !emailInput.validity.valid) {
            emailInput.setAttribute('aria-invalid', 'true');
            feedback.classList.add('is-error');
            feedback.textContent = 'Please enter a valid email address.';
            emailInput.focus();
            return;
        }

        emailInput.removeAttribute('aria-invalid');
        feedback.textContent = 'Thanks for subscribing! You are on the list.';
        newsletterForm.reset();
    });

    emailInput.addEventListener('input', () => {
        if (emailInput.validity.valid) {
            emailInput.removeAttribute('aria-invalid');
            feedback.classList.remove('is-error');
            feedback.textContent = '';
        }
    });
}
