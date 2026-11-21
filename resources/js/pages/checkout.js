function handleOrderTypeChange(type) {
    document.querySelectorAll('[id^="type-card-"]').forEach(el => {
        el.classList.remove('border-bites-orange', 'bg-amber-50/40');
        el.classList.add('border-gray-200');
    });
    const activeCard = document.getElementById('type-card-' + type);
    if (activeCard) {
        activeCard.classList.add('border-bites-orange', 'bg-amber-50/40');
        activeCard.classList.remove('border-gray-200');
    }

    const deliverySec = document.getElementById('delivery-address-section');
    if (deliverySec) {
        if (type === 'delivery') {
            deliverySec.classList.remove('hidden');
        } else {
            deliverySec.classList.add('hidden');
        }
    }
}

function handlePaymentChange(method) {
    document.querySelectorAll('[id^="pay-card-"]').forEach(el => {
        el.classList.remove('border-bites-orange', 'bg-amber-50/40');
        el.classList.add('border-gray-200');
    });
    const activePay = document.getElementById('pay-card-' + method);
    if (activePay) {
        activePay.classList.add('border-bites-orange', 'bg-amber-50/40');
        activePay.classList.remove('border-gray-200');
    }
}

function initCheckoutPage() {
    if (document.getElementById('type-card-takeaway')) {
        handleOrderTypeChange('takeaway');
    }
}

const _checkoutQtyPending = new Set();

function formatCheckoutPrice(amount) {
    if (typeof window.formatRupiah === 'function') {
        return window.formatRupiah(amount);
    }
    return 'Rp ' + Math.round(Number(amount) || 0).toLocaleString('id-ID');
}

function renderCheckoutSummary(cart) {
    const listEl = document.getElementById('checkout-items-list');
    if (!listEl || !cart) return;

    const items = Array.isArray(cart.items) ? cart.items : [];
    if (items.length === 0) {
        const menuUrl = document.body?.dataset?.menuUrl || '/menu';
        window.location.href = menuUrl;
        return;
    }

    const itemMap = new Map(items.map(item => [String(item.cart_key), item]));

    listEl.querySelectorAll('[data-checkout-item]').forEach(rowEl => {
        const key = rowEl.dataset.checkoutItem;
        const item = itemMap.get(key);
        if (!item) {
            rowEl.remove();
            return;
        }

        const qty = Number(item.quantity) || 1;
        rowEl.dataset.qty = String(qty);

        const qtyEl = rowEl.querySelector('[data-checkout-qty]');
        if (qtyEl) qtyEl.textContent = String(qty);

        const unitQtyEl = rowEl.querySelector('[data-checkout-unit-qty]');
        if (unitQtyEl) {
            unitQtyEl.textContent = `${formatCheckoutPrice(item.unit_price)} (x${qty})`;
        }

        const totalEl = rowEl.querySelector('[data-checkout-item-total]');
        if (totalEl) {
            totalEl.textContent = formatCheckoutPrice(item.total_price);
        }
    });

    const subtotalEl = document.getElementById('checkout-subtotal');
    if (subtotalEl) subtotalEl.textContent = formatCheckoutPrice(cart.subtotal);

    const taxEl = document.getElementById('checkout-tax');
    if (taxEl) taxEl.textContent = formatCheckoutPrice(cart.tax);

    const totalEl = document.getElementById('checkout-total');
    if (totalEl) totalEl.textContent = formatCheckoutPrice(cart.total);
}

async function updateCheckoutQty(cartKey, qty) {
    const key = String(cartKey || '');
    if (!key || _checkoutQtyPending.has(key)) return;

    const clampedQty = Math.max(0, Math.min(100, parseInt(qty, 10) || 0));
    _checkoutQtyPending.add(key);

    try {
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const updateUrl = document.body?.dataset?.cartUpdateUrl || '/cart/update';
        const res = await fetch(updateUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': token || ''
            },
            body: JSON.stringify({ cart_key: key, quantity: clampedQty })
        });
        const data = await res.json();
        if (res.status === 423 && data?.store_closed && typeof window.promptStoreClosed === 'function') {
            window.promptStoreClosed(data.closed_reason);
            return;
        }
        if (data.success && data.cart) {
            renderCheckoutSummary(data.cart);
            if (typeof window.renderCart === 'function') {
                window.renderCart(data.cart);
            }
        }
    } catch (e) {
        console.error(e);
    } finally {
        _checkoutQtyPending.delete(key);
    }
}

function adjustCheckoutQty(cartKey, delta) {
    const key = String(cartKey || '');
    const rowEl = Array.from(document.querySelectorAll('#checkout-items-list [data-checkout-item]'))
        .find(el => el.dataset.checkoutItem === key);
    const currentQty = rowEl ? (parseInt(rowEl.dataset.qty, 10) || 1) : 1;
    updateCheckoutQty(key, currentQty + (parseInt(delta, 10) || 0));
}

window.handleOrderTypeChange = handleOrderTypeChange;
window.handlePaymentChange = handlePaymentChange;
window.renderCheckoutSummary = renderCheckoutSummary;
window.updateCheckoutQty = updateCheckoutQty;
window.adjustCheckoutQty = adjustCheckoutQty;

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initCheckoutPage);
} else {
    initCheckoutPage();
}
window.addEventListener('tb:pjax:loaded', initCheckoutPage);
