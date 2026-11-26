document.addEventListener('DOMContentLoaded', function() {
    const toast = document.getElementById('cart-toast');

    function updateCartBadge(count) {
        const cartLink = document.querySelector('.cart-icon');

        if (!cartLink) return;

        let badge = cartLink.querySelector('.cart-badge');

        if (count > 0) {
            if (!badge) {
                badge = document.createElement('span');
                badge.className = 'cart-badge';
                cartLink.appendChild(badge);
            }

            badge.textContent = count;
        } else if (badge) {
            badge.remove();
        }
    }

    function showToast(message, success) {
        toast.textContent = message;
        toast.className = 'cart-toast show ' + (success ? 'success' : 'error');

        clearTimeout(window.cartToastTimer);

        window.cartToastTimer = setTimeout(function() {
            toast.className = 'cart-toast';
        }, 3000);
    }

    document.addEventListener('submit', async function(event) {
        const form = event.target.closest('.add-to-cart-form');

        if (!form) return;

        event.preventDefault();

        const button = form.querySelector('button');
        const originalText = button.textContent;

        button.disabled = true;
        button.textContent = 'Adding...';

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (!response.ok || !data.success) {
                throw new Error(data.message || 'Unable to add product.');
            }

            showToast(data.message, true);
            updateCartBadge(data.cartCount);
        } catch (error) {
            showToast(error.message, false);
        } finally {
            button.disabled = false;
            button.textContent = originalText;
        }
    });
});
