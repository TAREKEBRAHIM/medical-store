const cartCount = document.querySelector('.cart-count');
const cartButton = document.querySelector('.cart-button');
const toast = document.querySelector('.toast');
const searchPanel = document.querySelector('.search-panel');
const searchInput = document.querySelector('#site-search');
const productCards = [...document.querySelectorAll('.product-card')];
const noResults = document.querySelector('.no-results');
let cartItems = 0;
let toastTimer;

function showToast(message) {
    toast.textContent = message;
    toast.classList.add('visible');
    window.clearTimeout(toastTimer);
    toastTimer = window.setTimeout(() => toast.classList.remove('visible'), 2600);
}

function filterProducts(category = 'All', query = '') {
    const normalizedQuery = query.trim().toLowerCase();
    let visibleCount = 0;

    productCards.forEach((card) => {
        const categoryMatches = category === 'All' || card.dataset.category === category;
        const searchMatches = !normalizedQuery || card.dataset.name.includes(normalizedQuery);
        const isVisible = categoryMatches && searchMatches;
        card.hidden = !isVisible;
        if (isVisible) visibleCount += 1;
    });

    noResults.hidden = visibleCount > 0;
}

document.querySelectorAll('.add-button').forEach((button) => {
    button.addEventListener('click', () => {
        cartItems += 1;
        cartCount.textContent = String(cartItems);
        cartButton.setAttribute('aria-label', `Shopping cart, ${cartItems} items`);
        const productName = button.closest('.product-card').querySelector('h3').textContent;
        showToast(`${productName} added to your cart`);
    });
});

document.querySelectorAll('.favorite-button').forEach((button) => {
    button.addEventListener('click', () => {
        const isSaved = button.classList.toggle('saved');
        button.setAttribute('aria-pressed', String(isSaved));
        showToast(isSaved ? 'Saved to your favorites' : 'Removed from your favorites');
    });
});

document.querySelectorAll('.filter-chip').forEach((button) => {
    button.addEventListener('click', () => {
        document.querySelector('.filter-chip.selected')?.classList.remove('selected');
        button.classList.add('selected');
        filterProducts(button.dataset.filter, searchInput.value);
    });
});

document.querySelectorAll('[data-category-link]').forEach((link) => {
    link.addEventListener('click', () => {
        const category = link.dataset.categoryLink;
        document.querySelectorAll('.filter-chip').forEach((button) => {
            button.classList.toggle('selected', button.dataset.filter === category);
        });
        filterProducts(category, searchInput.value);
    });
});

document.querySelector('.search-toggle').addEventListener('click', () => {
    const isOpen = searchPanel.classList.toggle('open');
    if (isOpen) searchInput.focus();
});

searchPanel.addEventListener('submit', (event) => {
    event.preventDefault();
    filterProducts(document.querySelector('.filter-chip.selected')?.dataset.filter || 'All', searchInput.value);
    document.querySelector('#products').scrollIntoView({ behavior: 'smooth' });
});

searchInput.addEventListener('input', () => {
    filterProducts(document.querySelector('.filter-chip.selected')?.dataset.filter || 'All', searchInput.value);
});

document.querySelector('.menu-toggle').addEventListener('click', (event) => {
    const menu = document.querySelector('.main-nav');
    const isOpen = menu.classList.toggle('open');
    event.currentTarget.setAttribute('aria-expanded', String(isOpen));
    event.currentTarget.setAttribute('aria-label', isOpen ? 'Close navigation' : 'Open navigation');
});

document.querySelectorAll('.nav-link').forEach((link) => {
    link.addEventListener('click', () => {
        document.querySelector('.main-nav').classList.remove('open');
        document.querySelector('.menu-toggle').setAttribute('aria-expanded', 'false');
    });
});

document.querySelector('.newsletter-form').addEventListener('submit', (event) => {
    event.preventDefault();
    const email = document.querySelector('#email-address');
    if (email.reportValidity()) {
        showToast('You are on the list. Welcome to MediLife!');
        email.value = '';
    }
});