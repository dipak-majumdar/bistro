// Helper: read cookie by name
function getCookie(name) {
    const match = document.cookie.split('; ').find(row => row.startsWith(name + '='));
    return match ? decodeURIComponent(match.split('=')[1]) : null;
}

let headers = {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
};

if (isLoggedIn) {
    headers['X-User-Id'] = userId;
} else {
    headers['X-Guest-Id'] = getCookie('guest_identifier');
}

async function fetchCartAndRender() {
    try {
        const res = await fetch('/api/cart/items', {
            headers: headers,
        });

        const data = await res.json();
        if (!res.ok) throw new Error(data.message || 'Failed to fetch cart');

        console.log(data);
        // render cart
        document.querySelector('.cart_bt strong').textContent = data.count;
        const listEl = document.querySelector('.dropdown-menu ul');
        if (listEl) listEl.innerHTML = '';
        let cartTotal = 0;
        const currency = data.currency;
        data.items.forEach(item => {
            const firstImage = (item.menu_item?.image_path) || 'storage/placeholder/placeholder.jpg';
            const productImage = window.location.origin+'/'+firstImage;
            const name = item.menu_item?.name || 'Item';
            const quantity = item.quantity || 1;
            const price = (item.variations?. [0]?.price) ?? 0;
            cartTotal += price * quantity;

            if (listEl) listEl.innerHTML += `
              <li>
                <figure><img src="${productImage}" data-src="${productImage}" alt="" width="50" height="50" class="lazy"></figure>
                    <strong><span>${quantity}x ${name}</span>${currency}${price}</strong>
                        <a href="#0" class="action" data-cart-id="${item.id}"><i class="icon_trash_alt"></i></a>
              </li>`;
        })
        document.getElementById('cart_total').textContent = `${currency}${cartTotal}`;
    } catch (err) {
        console.error(err);
    }
}

fetchCartAndRender();

document.addEventListener('click', async (e) => {
    const a = e.target.closest('a.action[data-cart-id]');
    if (!a) return;
    e.preventDefault();
    try {
        const id = a.getAttribute('data-cart-id');
        const guestId = getCookie('guest_identifier');
        const res = await fetch(`/api/cart/items/${id}`, {
            method: 'DELETE',
            headers: headers,
        });
        const data = await res.json();
        if (!res.ok) throw new Error(data.message || 'Failed to remove');
        window.showToast('Item removed from cart', {
            variant: 'warning',
            delay: 1500
        });
        fetchCartAndRender();
    } catch (err) {
        console.error(err);
        window.showToast('Could not remove item', {
            variant: 'danger'
        });
    }
});
