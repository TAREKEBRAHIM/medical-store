document.addEventListener('DOMContentLoaded', function() {
    const cartContent = document.getElementById('cart-content');
    const messageBox = document.getElementById('cart-message');

    function showMessage(message, success = true) {
        messageBox.textContent = message;
        messageBox.className = 'cart-message ' + (success ? 'success' : 'error');
        messageBox.hidden = false;
    }

    function formatPrice(value) {
        return 'EGP ' + Number(value).toLocaleString('en-EG', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    async function sendCartForm(form) {
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
            throw new Error(data.message || 'Something went wrong.');
        }

        return data;
    }

    function updateSummary(data) {
        document.getElementById('cart-total').textContent =
            formatPrice(data.total);

        document.getElementById('cart-count').textContent =
            data.cartCount;
    }

    cartContent.addEventListener('click', async function(event) {
        const button = event.target.closest('.quantity-btn');

        if (!button) return;

        const item = button.closest('.cart-item');
        const form = item.querySelector('.cart-quantity-form');
        const input = form.querySelector('.quantity-input');
        const valueElement = item.querySelector('.quantity-value');

        let quantity = parseInt(input.value, 10);

        if (button.classList.contains('increase-btn')) {
            quantity++;
        } else {
            quantity--;
        }

        if (quantity < 1) {
            showMessage('Minimum quantity is 1.', false);
            return;
        }

        input.value = quantity;
        button.disabled = true;

        try {
            const data = await sendCartForm(form);

            valueElement.textContent = data.quantity;
            item.querySelector('.item-subtotal').textContent =
                formatPrice(data.subtotal);

            updateSummary(data);
            showMessage(data.message);
        } catch (error) {
            input.value = valueElement.textContent;
            showMessage(error.message, false);
        } finally {
            button.disabled = false;
        }
    });

    cartContent.addEventListener('submit', async function(event) {
        const form = event.target.closest('[data-cart-action="remove"]');

        if (!form) return;

        event.preventDefault();

        const item = form.closest('.cart-item');
        const button = form.querySelector('button');

        button.disabled = true;

        try {
            const data = await sendCartForm(form);

            item.remove();
            updateSummary(data);
            showMessage(data.message);

            if (data.cartCount === 0) {
                const productsUrl = cartContent.dataset.productsUrl;
                cartContent.innerHTML = `
                    <div class="empty-cart">
                        <div class="empty-cart-icon">🛒</div>
                        <h2>Your cart is empty</h2>
                        <p>You haven't added any products yet.</p>
                        <a href="${productsUrl}" class="continue-shopping">
                            Explore Products
                        </a>
                    </div>
                `;
            }
        } catch (error) {
            button.disabled = false;
            showMessage(error.message, false);
        }
    });
});
