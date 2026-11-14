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

async function updateCheckoutQty(cartKey, qty) {
    try {
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const res = await fetch('/cart/update', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token || ''
            },
            body: JSON.stringify({ cart_key: cartKey, quantity: qty })
        });
        const data = await res.json();
        if (data.success) {
            if (typeof window.tbAppNavigate === 'function') {
                window.tbAppNavigate(window.location.href, false, true);
            } else {
                window.location.reload();
            }
        }
    } catch (e) {
        console.error(e);
    }
}

window.handleOrderTypeChange = handleOrderTypeChange;
window.handlePaymentChange = handlePaymentChange;
window.updateCheckoutQty = updateCheckoutQty;

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initCheckoutPage);
} else {
    initCheckoutPage();
}
window.addEventListener('tb:pjax:loaded', initCheckoutPage);
