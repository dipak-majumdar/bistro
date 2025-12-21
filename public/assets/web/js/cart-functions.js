let headers = {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
};

const isLoggedIn = async () => {
    try {
        const response = await fetch('/is-logged-in', {
            headers: headers,
        });
        const data = await response.json();
        return data.is_logged_in;
    } catch (error) {
        console.error('Failed to fetch is logged in:', error);
        return false;
    }
}

const getUserId = async () => {
    try {
        const response = await fetch('/user-id', {
            headers: headers,
        });
        const data = await response.json();
        return data.user_id;
    } catch (error) {
        console.error('Failed to fetch user ID:', error);
        return null;
    }
}


const getCSRFToken = () => {
    const tokenElement = document.querySelector('meta[name="csrf-token"]');
    if (tokenElement) {
        return tokenElement.getAttribute('content');
    }

    // Fallback: try to get from form
    const formToken = document.querySelector('input[name="_token"]');
    if (formToken) {
        return formToken.value;
    }

    // Last fallback: return empty string
    console.warn('CSRF token not found');
    return '';
}

// set user-id in header
const setUserHeaders = async () => {
    const loggedIn = await isLoggedIn();
    const userId = await getUserId();

    headers['X-CSRF-TOKEN'] = getCSRFToken();

    if (loggedIn) {
        headers['X-User-Id'] = userId;
    } else {
        headers['X-Guest-Id'] = userId;
    }
};


async function fetchCartAndRender() {
    try {
        const res = await fetch('/api/cart/items', {
            headers: headers,
        });

        const data = await res.json();
        if (!res.ok) throw new Error(data.message || 'Failed to fetch cart');

        // render cart
        document.querySelector('.cart_bt strong').textContent = data.count;
        const listEl = document.querySelector('.dropdown-menu ul');
        if (listEl) listEl.innerHTML = '';
        let cartTotal = 0;
        const currency = data.currency;
        data.items.forEach(item => {
            const firstImage = (item.menu_item?.image_path) || 'storage/placeholder/placeholder.jpg';
            const productImage = window.location.origin + '/' + firstImage;
            const name = item.menu_item?.name;
            const quantity = item.quantity;
            const price = (item.variations?. [0]?.price);
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


document.addEventListener('click', async (e) => {
    const a = e.target.closest('a.action[data-cart-id]');
    if (!a) return;
    e.preventDefault();
    try {
        const id = a.getAttribute('data-cart-id');
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

// Initialize headers and then fetch cart
const initializeAndFetchCart = async () => {
    await setUserHeaders();
    fetchCartAndRender();
};

// Initialize and fetch cart immediately
initializeAndFetchCart();
