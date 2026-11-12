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

handleOrderTypeChange('takeaway');
