const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const APP_CONFIG = document.body.dataset;
const IS_AUTHENTICATED = APP_CONFIG.authenticated === 'true';
const LOGIN_URL = APP_CONFIG.loginUrl || '/login';

function promptRequireLogin(message = 'Wajib login terlebih dahulu untuk memasukkan menu ke keranjang.') {
    if (typeof closeProductModal === 'function') {
        closeProductModal();
    }
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: 'warning',
            title: 'Wajib Login Terlebih Dahulu',
            text: message,
            showCancelButton: true,
            confirmButtonText: 'Login Sekarang',
            cancelButtonText: 'Nanti Saja',
            confirmButtonColor: '#27443E',
            cancelButtonColor: '#8F9693',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-2xl',
                confirmButton: 'font-bold px-6 py-2.5 rounded-xl cursor-pointer',
                cancelButton: 'font-semibold px-5 py-2.5 rounded-xl cursor-pointer'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = LOGIN_URL;
            }
        });
    } else {
        alert(message);
        window.location.href = LOGIN_URL;
    }
}

let currentModalProduct = null;

function formatRupiah(num) {
    const isEn = (window._tbAppLang === 'EN' || window._tbAppLang === 'US');
    return (isEn ? 'IDR ' : 'Rp ') + Number(num).toLocaleString(isEn ? 'en-US' : 'id-ID');
}

function openCartDrawer() {
    const drawer = document.getElementById('cart-drawer');
    const backdrop = document.getElementById('cart-backdrop');
    if (!drawer) return;
    drawer.classList.remove('invisible', 'pointer-events-none', 'opacity-0');
    drawer.classList.add('opacity-100');
    drawer.style.transform = 'scale(1) translateY(0)';
    if (backdrop) backdrop.classList.remove('hidden');
}

function closeCartDrawer() {
    const drawer = document.getElementById('cart-drawer');
    const backdrop = document.getElementById('cart-backdrop');
    if (!drawer) return;
    drawer.style.transform = 'scale(0.95) translateY(-8px)';
    drawer.classList.add('pointer-events-none', 'opacity-0');
    drawer.classList.remove('opacity-100');
    if (backdrop) backdrop.classList.add('hidden');
    setTimeout(() => {
        if (drawer.classList.contains('opacity-0')) {
            drawer.classList.add('invisible');
        }
    }, 250);
}

function toggleCartDrawer() {
    const drawer = document.getElementById('cart-drawer');
    const isClosed = !drawer || drawer.classList.contains('invisible') || drawer.classList.contains('opacity-0');

    if (isClosed) {
        // Scroll to top first, then open cart
        window.scrollTo({ top: 0, behavior: 'smooth' });
        const alreadyAtTop = window.scrollY < 5;
        const delay = alreadyAtTop ? 0 : 400;
        setTimeout(() => {
            openCartDrawer();
            refreshCart();
        }, delay);
    } else {
        closeCartDrawer();
    }
}

async function refreshCart() {
    try {
        const res = await fetch(APP_CONFIG.cartIndexUrl || '/cart');
        const data = await res.json();
        renderCart(data);
    } catch (e) {
        console.error(e);
    }
}

function startOrderFromCart() {
    closeCartDrawer();
    const menuUrl = APP_CONFIG.menuUrl || '/menu';
    if (window.location.pathname === '/menu') {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    } else if (typeof window.tbAppNavigate === 'function') {
        window.tbAppNavigate(menuUrl, true);
    } else {
        window.location.href = menuUrl;
    }
}

function renderCart(cart) {
    const container = document.getElementById('cart-items-container');
    const badge = document.getElementById('cart-badge');
    const mobileDockBadge = document.getElementById('mobile-dock-cart-badge');
    const countText = document.getElementById('cart-items-count-text');
    const checkoutTotal = document.getElementById('checkout-btn-total');
    const fixedFooter = document.getElementById('cart-fixed-footer');
    const summarySection = document.getElementById('cart-summary-section');
    const actionSection = document.getElementById('cart-action-section');
    const discountRow = document.getElementById('cart-discount-row');

    if (badge) badge.innerText = cart.item_count || 0;
    if (mobileDockBadge) mobileDockBadge.innerText = cart.item_count || 0;
    const isEn = (window._tbAppLang === 'EN' || window._tbAppLang === 'US');
    const suffix = isEn ? 'Items Selected' : 'Menu Dipilih';
    countText.innerText = `${cart.item_count || 0} ${suffix}`;

    document.getElementById('cart-subtotal').innerText = formatRupiah(cart.subtotal);
    document.getElementById('cart-discount').innerText = '- ' + formatRupiah(cart.discount);
    document.getElementById('cart-tax').innerText = formatRupiah(cart.tax);
    document.getElementById('cart-total').innerText = formatRupiah(cart.total);
    if (checkoutTotal) {
        checkoutTotal.innerText = formatRupiah(cart.total);
    }

    if (discountRow) {
        if (cart.discount && Number(cart.discount) > 0) {
            discountRow.classList.remove('hidden');
            discountRow.classList.add('flex');
        } else {
            discountRow.classList.add('hidden');
            discountRow.classList.remove('flex');
        }
    }

    if (!cart.items || cart.items.length === 0) {
        container.classList.remove('max-h-[348px]');
        const emptyTitle = isEn ? 'Your cart is still empty' : 'Keranjangmu masih kosong nih';
        const emptySub1 = isEn ? 'Go ahead, pick your favorite burger and satisfy' : 'Yuk, pilih burger favoritmu dan mulai ngisi';
        const emptySub2 = isEn ? 'your cravings today' : 'perut kosongmu hari ini';
        const emptyBtn = isEn ? 'Start Ordering Now' : 'Mulai Pesan Sekarang';
        const emptyCartImg = APP_CONFIG.emptyCartImg || '/images/empty-cart.png';

        container.innerHTML = `
            <div class="py-7 px-4 flex flex-col items-center text-center">
                <img src="${emptyCartImg}"
                     alt="${emptyTitle}"
                     class="w-[175px] h-auto object-contain mx-auto mb-6 select-none pointer-events-none">
                <h4 class="font-semibold text-[#52565E] text-[18px] leading-snug tracking-tight">
                    ${emptyTitle}
                </h4>
                <p class="text-[13px] text-[#737373] leading-[1.5] mt-1.5 mx-auto font-normal">
                    <span class="block sm:whitespace-nowrap">${emptySub1}</span>
                    <span class="block">${emptySub2}</span>
                </p>
                <button type="button"
                        onclick="startOrderFromCart()"
                        class="mt-6 bg-[#3E5B56] hover:bg-[#324B47] active:scale-95 text-white font-semibold text-[13.5px] px-8 py-3 rounded-[10px] transition cursor-pointer inline-flex items-center justify-center min-h-[44px] shadow-2xs">
                    ${emptyBtn}
                </button>
            </div>`;
        if (fixedFooter) fixedFooter.classList.add('hidden');
        if (summarySection) summarySection.classList.add('hidden');
        if (actionSection) actionSection.classList.add('hidden');
        return;
    }

    container.classList.add('max-h-[348px]');
    if (fixedFooter) fixedFooter.classList.remove('hidden');
    if (summarySection) summarySection.classList.remove('hidden');
    if (actionSection) actionSection.classList.remove('hidden');

    container.innerHTML = cart.items.map(item => `
        <div class="bg-[#F4F5F7] rounded-[14px] p-3.5 flex gap-3.5 items-center">
            <img src="${item.image ? '/' + item.image : '/images/burger-bg.jpg'}"
                 alt="${item.name}"
                 class="w-[74px] h-[74px] object-cover rounded-[10px] flex-shrink-0">
            <div class="flex-1 min-w-0">
                <h4 class="font-semibold text-[14.5px] text-[#33373D] truncate leading-snug">${item.name}</h4>
                <div class="text-[13.5px] text-[#6A6F77] font-normal mt-0.5">${formatRupiah(item.unit_price)}</div>

                <div class="flex items-center justify-between mt-2.5 pt-2.5 border-t border-[#E5E7EB]">
                    <div class="inline-flex items-center bg-white border border-[#E5E7EB] rounded-[6px] px-1 py-0.5 shadow-2xs">
                        <button type="button"
                                onclick="updateCartQty('${item.cart_key}', ${item.quantity - 1})"
                                class="w-5 h-5 flex items-center justify-center text-[#6A6F77] hover:text-[#2E3137] text-xs font-medium cursor-pointer transition"
                                aria-label="Kurangi jumlah">-</button>
                        <span class="px-2 text-[11.5px] font-medium text-[#2E3137] select-none">${item.quantity}</span>
                        <button type="button"
                                onclick="updateCartQty('${item.cart_key}', ${item.quantity + 1})"
                                class="w-5 h-5 flex items-center justify-center text-[#6A6F77] hover:text-[#2E3137] text-xs font-medium cursor-pointer transition"
                                aria-label="Tambah jumlah">+</button>
                    </div>
                    <span class="font-semibold text-[14.5px] text-[#2E3137]">${formatRupiah(item.total_price)}</span>
                </div>
            </div>
        </div>
    `).join('');
}

async function updateCartQty(cartKey, qty) {
    const res = await fetch(APP_CONFIG.cartUpdateUrl || '/cart/update', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
        body: JSON.stringify({ cart_key: cartKey, quantity: qty })
    });
    const data = await res.json();
    if (data.cart) renderCart(data.cart);
}

async function removeCartItem(cartKey) {
    const res = await fetch(APP_CONFIG.cartRemoveUrl || '/cart/remove', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
        body: JSON.stringify({ cart_key: cartKey })
    });
    const data = await res.json();
    if (data.cart) renderCart(data.cart);
}

async function openProductModal(productId) {
    try {
        const res = await fetch(`/product/${productId}`);
        const data = await res.json();
        if (!data.success) return;

        currentModalProduct = data.product;
        document.getElementById('modal-product-id').value = currentModalProduct.id;
        document.getElementById('modal-product-name').innerText = (currentModalProduct.name || '').toUpperCase();
        document.getElementById('modal-product-badge').innerText = (currentModalProduct.badge || 'BURGER').toUpperCase();
        let modalDesc = currentModalProduct.description || 'Pilihan terbaik dari Toon Burger.';
        if ((window._tbAppLang === 'EN' || window._tbAppLang === 'US') && typeof _tbPhraseMap !== 'undefined' && _tbPhraseMap[modalDesc]) {
            modalDesc = _tbPhraseMap[modalDesc];
        }
        document.getElementById('modal-product-desc').innerText = modalDesc;
        document.getElementById('modal-product-price').innerText = (currentModalProduct.formatted_price || formatRupiah(currentModalProduct.price)).toUpperCase();
        document.getElementById('modal-product-image').src = currentModalProduct.image ? '/' + currentModalProduct.image : '/images/burger-bg.jpg';

        const cardBg = document.getElementById('modal-product-card-bg');
        if (cardBg) {
            cardBg.style.backgroundColor = currentModalProduct.bg || '#FFC83B';
        }

        const qtyEl = document.getElementById('modal-quantity');
        if (qtyEl) {
            if ('value' in qtyEl) qtyEl.value = '1';
            else qtyEl.innerText = '1';
        }

        const notesEl = document.getElementById('modal-notes');
        if (notesEl) notesEl.value = '';

        const optContainer = document.getElementById('modal-options-container');
        if (optContainer) {
            if (currentModalProduct.options && currentModalProduct.options.length > 0) {
                optContainer.classList.remove('hidden');
                optContainer.innerHTML = currentModalProduct.options.map(opt => `
                    <div class="bg-gray-50 p-2.5 rounded-xl border border-gray-200/70">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-[11px] font-bold text-gray-800">${opt.name}</span>
                            ${opt.is_required ? `<span class="text-[9px] bg-red-100 text-red-700 font-bold px-1.5 py-0.5 rounded">Wajib</span>` : `<span class="text-[9px] text-gray-400">Opsional</span>`}
                        </div>
                        <div class="space-y-1">
                            ${opt.values.map(val => `
                                <label class="flex items-center justify-between p-1.5 rounded-lg bg-white border border-gray-200 cursor-pointer hover:border-[#385850] transition text-xs">
                                    <div class="flex items-center gap-1.5">
                                        <input type="${opt.type === 'single' ? 'radio' : 'checkbox'}"
                                               name="option_${opt.id}${opt.type === 'single' ? '' : '[]'}"
                                               value="${val.id}"
                                               data-price="${val.additional_price}"
                                               ${val.is_default ? 'checked' : ''}
                                               onchange="recalculateModalPrice()"
                                               class="text-[#385850] focus:ring-[#385850]">
                                        <span class="text-[11px] font-medium text-gray-700">${val.name}</span>
                                    </div>
                                    <span class="font-bold text-gray-500 text-[10px]">
                                        ${Number(val.additional_price) > 0 ? '+ ' + formatRupiah(val.additional_price) : 'Gratis'}
                                    </span>
                                </label>
                            `).join('')}
                        </div>
                    </div>
                `).join('');
            } else {
                optContainer.classList.add('hidden');
                optContainer.innerHTML = '';
            }
        }

        recalculateModalPrice();
        if (typeof window.applyAppTranslations === 'function' && (window._tbAppLang === 'EN' || window._tbAppLang === 'US')) {
            window.applyAppTranslations('EN');
        }
        document.getElementById('product-modal').classList.remove('hidden');
        document.getElementById('product-modal-backdrop').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    } catch (e) {
        console.error(e);
    }
}

function closeProductModal() {
    const modal = document.getElementById('product-modal');
    const backdrop = document.getElementById('product-modal-backdrop');
    if (modal) modal.classList.add('hidden');
    if (backdrop) backdrop.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

function adjustModalQty(delta) {
    const qtyEl = document.getElementById('modal-quantity');
    if (!qtyEl) return;
    let val = parseInt(qtyEl.innerText || '1') + delta;
    if (val < 1) val = 1;
    qtyEl.innerText = val;
    recalculateModalPrice();
}

function recalculateModalPrice() {
    if (!currentModalProduct) return;
    let unit = Number(currentModalProduct.price);

    const checkedInputs = document.querySelectorAll('#modal-options-container input:checked');
    checkedInputs.forEach(inp => {
        unit += Number(inp.getAttribute('data-price') || 0);
    });

    const qtyEl = document.getElementById('modal-quantity');
    const qty = parseInt(qtyEl ? (qtyEl.innerText || qtyEl.value || '1') : '1') || 1;
    const total = unit * qty;

    const priceEl = document.getElementById('modal-product-price');
    if (priceEl) {
        priceEl.innerText = formatRupiah(total).toUpperCase();
    }
}

async function submitAddToCart() {
    if (!currentModalProduct) return;

    if (!IS_AUTHENTICATED) {
        promptRequireLogin('Silakan login ke akun Anda terlebih dahulu untuk menambahkan menu ke keranjang belanja.');
        return;
    }

    const selectedOptions = [];
    document.querySelectorAll('#modal-options-container input:checked').forEach(inp => {
        selectedOptions.push(inp.value);
    });

    const qtyEl = document.getElementById('modal-quantity');
    const qty = parseInt(qtyEl ? (qtyEl.value || qtyEl.innerText || '1') : '1') || 1;
    const notesEl = document.getElementById('modal-notes');
    const notes = notesEl ? notesEl.value : '';
    const submitBtn = document.getElementById('modal-submit-btn');

    try {
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-75');
        }

        const res = await fetch(APP_CONFIG.cartAddUrl || '/cart/add', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
            body: JSON.stringify({
                product_id: currentModalProduct.id,
                quantity: qty,
                options: selectedOptions,
                notes: notes
            })
        });

        const data = await res.json();

        if (res.status === 401 || data.require_login) {
            closeProductModal();
            promptRequireLogin(data.message || 'Wajib login terlebih dahulu untuk menambahkan menu ke keranjang.');
            return;
        }

        if (data.success) {
            closeProductModal();
            renderCart(data.cart);
            animateCartBadge();
            window.scrollTo({ top: 0, behavior: 'smooth' });
            const delay = window.scrollY < 5 ? 0 : 300;
            setTimeout(() => openCartDrawer(), delay);
            showCartToast(data.message || 'Menu berhasil ditambahkan ke keranjang!');
        } else {
            closeProductModal();
            if (data.cart) renderCart(data.cart);
            openCartDrawer();
            showCartToast(data.message || 'Gagal menambahkan ke keranjang.');
        }
    } catch (e) {
        console.error(e);
    } finally {
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-75');
        }
    }
}

// Close product modal with Escape key
window.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        closeProductModal();
    }
});

// Fly to Cart Animation
function flyToCart(originElement) {
    if (!originElement) return;
    const cartBtn = document.getElementById('cart-btn');
    if (!cartBtn) return;

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        animateCartBadge();
        return;
    }

    const startRect = originElement.getBoundingClientRect();
    const endRect = cartBtn.getBoundingClientRect();

    const flyer = document.createElement('img');
    flyer.src = APP_CONFIG.toonHeadImg || '/images/toon-head.png';
    flyer.alt = 'Toon Mascot';
    flyer.className = 'flying-cart-particle';

    const startX = startRect.left + (startRect.width / 2) - 20;
    const startY = startRect.top + (startRect.height / 2) - 20;
    const targetX = endRect.left + (endRect.width / 2) - 20;
    const targetY = endRect.top + (endRect.height / 2) - 20;

    flyer.style.left = `${startX}px`;
    flyer.style.top = `${startY}px`;
    flyer.style.transform = 'scale(0.8) rotate(0deg)';
    flyer.style.opacity = '1';

    document.body.appendChild(flyer);

    // Force reflow
    void flyer.offsetWidth;

    const deltaX = targetX - startX;
    const deltaY = targetY - startY;

    flyer.style.transform = `translate(${deltaX}px, ${deltaY}px) scale(0.35) rotate(360deg)`;
    flyer.style.opacity = '0.6';

    setTimeout(() => {
        flyer.remove();
        animateCartBadge();
    }, 620);
}

async function quickAddToCart(productId) {
    if (!IS_AUTHENTICATED) {
        promptRequireLogin('Silakan login ke akun Anda terlebih dahulu untuk menambahkan menu ke keranjang belanja.');
        return;
    }

    try {
        const clickedEl = (window.event && window.event.target) ? window.event.target.closest('button, .group, div') : null;
        if (clickedEl) {
            flyToCart(clickedEl);
        }

        const res = await fetch(APP_CONFIG.cartAddUrl || '/cart/add', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
            body: JSON.stringify({ product_id: productId, quantity: 1 })
        });
        const data = await res.json();

        if (res.status === 401 || data.require_login) {
            promptRequireLogin(data.message || 'Wajib login terlebih dahulu untuk menambahkan menu ke keranjang.');
            return;
        }

        if (data.success) {
            renderCart(data.cart);
            window.scrollTo({ top: 0, behavior: 'smooth' });
            const delay = window.scrollY < 5 ? 0 : 400;
            setTimeout(() => openCartDrawer(), delay);
            showCartToast(data.message || 'Menu berhasil ditambahkan ke keranjang!');
        } else {
            if (data.cart) renderCart(data.cart);
            window.scrollTo({ top: 0, behavior: 'smooth' });
            const delay = window.scrollY < 5 ? 0 : 400;
            setTimeout(() => openCartDrawer(), delay);
            showCartToast(data.message || 'Gagal menambahkan ke keranjang.');
        }
    } catch (e) {
        console.error(e);
    }
}

function animateCartBadge() {
    const badge = document.getElementById('cart-badge');
    const cartBtn = document.getElementById('cart-btn');
    const mobileDockBtn = document.getElementById('mobile-dock-cart-btn');
    const mobileDockBadge = document.getElementById('mobile-dock-cart-badge');

    if (cartBtn) {
        cartBtn.classList.remove('animate-cart-punch');
        void cartBtn.offsetWidth;
        cartBtn.classList.add('animate-cart-punch');
        setTimeout(() => {
            cartBtn.classList.remove('animate-cart-punch');
        }, 500);
    }
    if (mobileDockBtn) {
        mobileDockBtn.classList.remove('animate-cart-punch');
        void mobileDockBtn.offsetWidth;
        mobileDockBtn.classList.add('animate-cart-punch');
        setTimeout(() => {
            mobileDockBtn.classList.remove('animate-cart-punch');
        }, 500);
    }
    if (badge) {
        badge.classList.remove('scale-125');
        void badge.offsetWidth;
        badge.classList.add('scale-125');
        setTimeout(() => {
            badge.classList.remove('scale-125');
        }, 350);
    }
    if (mobileDockBadge) {
        mobileDockBadge.classList.remove('scale-125');
        void mobileDockBadge.offsetWidth;
        mobileDockBadge.classList.add('scale-125');
        setTimeout(() => {
            mobileDockBadge.classList.remove('scale-125');
        }, 350);
    }
}

function showCartToast(message) {
    const isEn = (window._tbAppLang === 'EN' || window._tbAppLang === 'US');
    let displayMessage = message;
    if (isEn && typeof message === 'string') {
        if (message.includes('berhasil ditambahkan ke keranjang!')) {
            displayMessage = message.replace('berhasil ditambahkan ke keranjang!', 'successfully added to cart!');
        } else if (message.includes('Gagal menambahkan ke keranjang.')) {
            displayMessage = 'Failed to add item to cart.';
        }
    }

    let toast = document.getElementById('cart-toast-notification');
    if (!toast) {
        toast = document.createElement('div');
        toast.id = 'cart-toast-notification';
        toast.className = 'fixed bottom-6 right-6 z-50 bg-white text-gray-900 px-4 py-3 rounded-2xl shadow-[0_12px_32px_rgba(0,0,0,0.12)] border border-gray-200/90 flex items-center gap-3 transition-all duration-300 transform translate-y-20 opacity-0 pointer-events-auto';
        toast.innerHTML = `
            <div class="w-6 h-6 rounded-full bg-[#10B981] text-white flex items-center justify-center flex-shrink-0 shadow-xs">
                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 6 9 17l-5-5"/>
                </svg>
            </div>
            <div class="text-xs font-semibold text-gray-800" id="cart-toast-text"></div>
            <button type="button" id="cart-toast-btn" onclick="toggleCartDrawer()" class="ml-2 bg-bites-yellow hover:bg-bites-yellow-dark text-gray-900 text-[11px] font-black px-2.5 py-1 rounded-xl transition cursor-pointer">
                ${isEn ? 'View' : 'Buka'}
            </button>
        `;
        document.body.appendChild(toast);
    } else {
        const toastBtn = document.getElementById('cart-toast-btn');
        if (toastBtn) toastBtn.textContent = isEn ? 'View' : 'Buka';
    }

    const textElem = document.getElementById('cart-toast-text');
    if (textElem) textElem.innerText = displayMessage;
    toast.classList.remove('translate-y-20', 'opacity-0');
    toast.classList.add('translate-y-0', 'opacity-100');

    if (window._cartToastTimeout) clearTimeout(window._cartToastTimeout);
    window._cartToastTimeout = setTimeout(() => {
        toast.classList.remove('translate-y-0', 'opacity-100');
        toast.classList.add('translate-y-20', 'opacity-0');
    }, 3000);
}

function toggleMobileNav() {
    const menu = document.getElementById('mobile-nav-menu');
    if (menu) {
        menu.classList.toggle('hidden');
    }
}

document.addEventListener('click', (event) => {
    const menu = document.getElementById('mobile-nav-menu');
    const toggle = document.getElementById('mobile-nav-toggle');
    if (!menu || !toggle || menu.classList.contains('hidden')) return;

    if (!menu.contains(event.target) && !toggle.contains(event.target)) {
        menu.classList.add('hidden');
    }
});

function toggleUserDropdown(event) {
    if (event) event.stopPropagation();
    const menu = document.getElementById('user-dropdown-menu');
    const arrow = document.getElementById('user-menu-arrow');
    if (!menu) return;

    const isHidden = menu.classList.contains('hidden');
    if (isHidden) {
        menu.classList.remove('hidden');
        if (arrow) arrow.classList.add('rotate-180');
    } else {
        menu.classList.add('hidden');
        if (arrow) arrow.classList.remove('rotate-180');
    }
}

// Close user dropdown when clicking outside
document.addEventListener('click', (event) => {
    const container = document.getElementById('user-dropdown-container');
    const menu = document.getElementById('user-dropdown-menu');
    const arrow = document.getElementById('user-menu-arrow');
    if (container && menu && !container.contains(event.target)) {
        menu.classList.add('hidden');
        if (arrow) arrow.classList.remove('rotate-180');
    }
});

function confirmLogout(event) {
    if (event) {
        event.preventDefault();
        event.stopPropagation();
    }
    const userMenu = document.getElementById('user-dropdown-menu');
    const userArrow = document.getElementById('user-menu-arrow');
    if (userMenu) userMenu.classList.add('hidden');
    if (userArrow) userArrow.classList.remove('rotate-180');
    const mobileMenu = document.getElementById('mobile-nav-menu');
    if (mobileMenu) mobileMenu.classList.add('hidden');

    const modal = document.getElementById('logout-confirm-modal');
    if (modal) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
    return false;
}

function closeLogoutModal() {
    const modal = document.getElementById('logout-confirm-modal');
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }
}

function submitLogoutForm() {
    try {
        localStorage.setItem('tb_logged_out', '1');
    } catch (e) {}
    closeLogoutModal();

    const isEn = (window._tbAppLang === 'EN' || window._tbAppLang === 'US');
    const form = document.getElementById('global-logout-form');
    const logoutUrl = APP_CONFIG.logoutUrl || '/logout';
    if (typeof Swal !== 'undefined') {
        let timerInterval;
        Swal.fire({
            title: isEn ? 'Logout Successful' : 'Logout Berhasil',
            html: isEn ? 'Logging out in <b></b> seconds... See you soon!' : 'Sedang keluar dari akun dalam <b></b> detik... Sampai jumpa!',
            icon: 'success',
            timer: 1500,
            timerProgressBar: true,
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
                const b = Swal.getPopup().querySelector('b');
                timerInterval = setInterval(() => {
                    if (b) {
                        const left = Math.ceil(Swal.getTimerLeft() / 1000);
                        b.textContent = left > 0 ? left : 1;
                    }
                }, 100);
            },
            willClose: () => {
                clearInterval(timerInterval);
            }
        }).then(() => {
            if (form) form.submit();
            else window.location.href = logoutUrl;
        });
    } else {
        if (form) form.submit();
        else window.location.href = logoutUrl;
    }
}

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeLogoutModal();
        closeCartDrawer();
        closeProductModal();
        const userMenu = document.getElementById('user-dropdown-menu');
        const userArrow = document.getElementById('user-menu-arrow');
        if (userMenu) userMenu.classList.add('hidden');
        if (userArrow) userArrow.classList.remove('rotate-180');
        const homeSearchDropdown = document.getElementById('home-search-dropdown');
        if (homeSearchDropdown) homeSearchDropdown.classList.add('hidden');
    }
});

// Live search handler
let homeSearchDebounce = null;
const homeSearchInput = document.getElementById('home-navbar-search');
const homeSearchClear = document.getElementById('home-search-clear');
const homeSearchDropdown = document.getElementById('home-search-dropdown');
const homeSearchLoading = document.getElementById('home-search-loading');
const homeSearchContent = document.getElementById('home-search-content');

function clearHomeNavbarSearch() {
    if (homeSearchInput) {
        homeSearchInput.value = '';
        homeSearchInput.focus();
    }
    if (homeSearchClear) homeSearchClear.classList.add('hidden');
    if (homeSearchDropdown) homeSearchDropdown.classList.add('hidden');
    if (homeSearchContent) homeSearchContent.innerHTML = '';
}

if (homeSearchInput) {
    homeSearchInput.addEventListener('input', function () {
        const q = this.value.trim();
        clearTimeout(homeSearchDebounce);

        if (q.length > 0) {
            if (homeSearchClear) homeSearchClear.classList.remove('hidden');
        } else {
            if (homeSearchClear) homeSearchClear.classList.add('hidden');
        }

        if (q.length < 1) {
            if (homeSearchDropdown) homeSearchDropdown.classList.add('hidden');
            if (homeSearchContent) homeSearchContent.innerHTML = '';
            return;
        }

        if (homeSearchDropdown) homeSearchDropdown.classList.remove('hidden');
        if (homeSearchLoading) homeSearchLoading.classList.remove('hidden');
        if (homeSearchContent) homeSearchContent.innerHTML = '';

        const searchUrl = APP_CONFIG.menuSearchUrl || '/menu/search/live';
        homeSearchDebounce = setTimeout(() => {
            fetch(`${searchUrl}?q=${encodeURIComponent(q)}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (homeSearchLoading) homeSearchLoading.classList.add('hidden');
                renderHomeSearchResults(data, q);
            })
            .catch(() => {
                if (homeSearchLoading) homeSearchLoading.classList.add('hidden');
                if (homeSearchContent) {
                    homeSearchContent.innerHTML = `<div class="text-xs text-gray-500 py-3 text-center">Gagal memuat hasil menu.</div>`;
                }
            });
        }, 200);
    });

    homeSearchInput.addEventListener('focus', function () {
        if (this.value.trim().length > 0 && homeSearchDropdown) {
            homeSearchDropdown.classList.remove('hidden');
        }
    });
}

function escapeHomeHtml(str) {
    if (!str) return '';
    return String(str).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
}

function renderHomeSearchResults(data, query) {
    if (!homeSearchContent) return;

    if (!data.products || data.products.length === 0) {
        homeSearchContent.innerHTML = `
            <div class="text-center py-5 text-gray-400">
                <svg class="w-6 h-6 mx-auto text-gray-300 mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <p class="text-xs font-semibold text-gray-600">Tidak ada menu untuk "<span class="text-gray-900">${escapeHomeHtml(query)}</span>"</p>
                <p class="text-[11px] text-gray-400 mt-0.5">Coba cari Cheese Burger, Beef, atau Chicken.</p>
            </div>
        `;
        return;
    }

    const menuUrl = APP_CONFIG.menuUrl || '/menu';
    const logoImg = APP_CONFIG.logoImg || '/images/logo.png';

    let html = `
        <div class="space-y-1">
            <div class="flex items-center justify-between text-[11px] font-bold text-gray-400 uppercase tracking-wider px-2 py-1 border-b border-gray-100">
                <span>Menu Terkait (${data.products.length})</span>
                <a href="${menuUrl}?q=${encodeURIComponent(query)}" class="text-[#3b6e64] hover:underline normal-case font-bold">Lihat Semua Menu &rarr;</a>
            </div>
    `;

    data.products.forEach(p => {
        html += `
            <a href="${p.url}" class="flex items-center justify-between p-2 rounded-xl hover:bg-gray-50 transition group">
                <div class="flex items-center gap-2.5 min-w-0">
                    <img src="${p.image}" alt="${escapeHomeHtml(p.name)}" class="w-9 h-9 rounded-lg object-cover shrink-0 bg-gray-100 border border-gray-100" onerror="this.onerror=null; this.src='${logoImg}';">
                    <div class="min-w-0">
                        <div class="text-xs font-bold text-gray-800 group-hover:text-[#3b6e64] transition truncate">${escapeHomeHtml(p.name)}</div>
                        <div class="text-[11px] font-extrabold text-[#FFA000]">${p.price_formatted}</div>
                    </div>
                </div>
                <span class="text-[10px] font-bold text-white bg-[#3b6e64] hover:bg-[#2d554d] px-2.5 py-1 rounded-lg transition shrink-0">
                    Pesan
                </span>
            </a>
        `;
    });

    html += `</div>`;
    homeSearchContent.innerHTML = html;
}

// Close search dropdown on click outside
document.addEventListener('click', (event) => {
    const searchContainer = document.getElementById('home-navbar-search')?.closest('.relative');
    const searchDropdown = document.getElementById('home-search-dropdown');
    if (searchContainer && searchDropdown && !searchContainer.contains(event.target)) {
        searchDropdown.classList.add('hidden');
    }
});

// ═══════════════════════════════════════════════
// INTERACTIVE MICRO-ANIMATION INITIALIZERS
// ═══════════════════════════════════════════════
// 1. 3D Tilt Card Interaction
function initTiltCards() {
    if (!window.matchMedia('(hover: hover)').matches || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
    document.querySelectorAll('.toon-tilt-card').forEach(card => {
        if (card.dataset.tiltInit) return;
        card.dataset.tiltInit = 'true';

        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            const rotateX = ((y - centerY) / centerY) * -6.5;
            const rotateY = ((x - centerX) / centerX) * 6.5;
            card.style.transform = `perspective(800px) rotateX(${rotateX.toFixed(2)}deg) rotateY(${rotateY.toFixed(2)}deg) translateY(-4px) scale3d(1.02, 1.02, 1.02)`;
        });

        card.addEventListener('mouseleave', () => {
            card.style.transform = 'perspective(800px) rotateX(0deg) rotateY(0deg) translateY(0px) scale3d(1, 1, 1)';
        });
    });
}

// 2. Hero Mouse Parallax Interaction (Optimized with RAF & lazy cached rect, zero scroll listeners)
function initHeroParallax() {
    const hero = document.getElementById('hero-section');
    const burger = document.getElementById('hero-burger-img');
    const badge = document.getElementById('hero-badge-img');
    if (!hero || !burger || hero.dataset.parallaxInit || !window.matchMedia('(hover: hover)').matches || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
    hero.dataset.parallaxInit = 'true';

    let ticking = false;
    let rect = null;
    let rectTs = 0;

    hero.addEventListener('mousemove', (e) => {
        const now = performance.now();
        if (!rect || (now - rectTs > 250)) {
            rect = hero.getBoundingClientRect();
            rectTs = now;
        }
        if (!ticking) {
            window.requestAnimationFrame(() => {
                const normX = (e.clientX - rect.left - (rect.width / 2)) / (rect.width / 2);
                const normY = (e.clientY - rect.top - (rect.height / 2)) / (rect.height / 2);

                burger.style.transform = `translate3d(${(normX * 10).toFixed(1)}px, ${(normY * 8).toFixed(1)}px, 0)`;
                if (badge) {
                    badge.style.transform = `translate3d(${(-normX * 8).toFixed(1)}px, ${(-normY * 6).toFixed(1)}px, 0)`;
                }
                ticking = false;
            });
            ticking = true;
        }
    }, { passive: true });

    hero.addEventListener('mouseleave', () => {
        rect = null;
        burger.style.transform = 'translate3d(0, 0, 0)';
        if (badge) badge.style.transform = 'translate3d(0, 0, 0)';
    }, { passive: true });
}

// 3. Scroll Reveal Interaction & Effects
function markRevealComplete(el) {
    if (!el || el.classList.contains('reveal-complete')) return;
    let done = false;
    const finish = () => {
        if (done) return;
        done = true;
        el.classList.add('reveal-complete');
    };
    el.addEventListener('transitionend', (e) => {
        if (e.target === el && (e.propertyName === 'opacity' || e.propertyName === 'transform')) {
            finish();
        }
    }, { once: true });
    setTimeout(finish, 1150);
}

function revealElement(el) {
    if (!el || el.classList.contains('revealed')) return;
    el.classList.add('revealed');
    markRevealComplete(el);
}

function initScrollReveal() {
    if (window._tbScrollRevealObserver) {
        window._tbScrollRevealObserver.disconnect();
        window._tbScrollRevealObserver = null;
    }

    const targets = Array.from(document.querySelectorAll('.toon-reveal, .toon-reveal-up, .toon-reveal-pop, .toon-reveal-left, .toon-reveal-right'))
        .filter(el => !el.classList.contains('revealed'));
    if (!targets.length) return;

    if (!('IntersectionObserver' in window)) {
        targets.forEach(el => {
            el.classList.add('revealed', 'reveal-complete');
        });
        return;
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                revealElement(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.01, rootMargin: '0px 0px -15px 0px' });

    window._tbScrollRevealObserver = observer;

    const vh = window.innerHeight || document.documentElement.clientHeight;
    const immediateTargets = [];

    targets.forEach(el => {
        const rect = el.getBoundingClientRect();
        if (rect.top < vh - 15 && rect.bottom > 0) {
            immediateTargets.push(el);
        } else if (rect.bottom <= 0) {
            // Already scrolled past above viewport
            el.classList.add('revealed', 'reveal-complete');
        } else {
            observer.observe(el);
        }
    });

    if (immediateTargets.length > 0) {
        window.requestAnimationFrame(() => {
            window.requestAnimationFrame(() => {
                immediateTargets.forEach(el => revealElement(el));
            });
        });
    }
}

// 4. Back to Top Button
function initScrollEffects() {
    const toTopBtn = document.getElementById('scroll-to-top-btn');
    if (!toTopBtn) return;

    if (!window._tbScrollEffectsHandler) {
        let ticking = false;
        window._tbScrollEffectsHandler = () => {
            if (!ticking) {
                window.requestAnimationFrame(() => {
                    const btn = document.getElementById('scroll-to-top-btn');
                    const winScroll = document.documentElement.scrollTop || document.body.scrollTop;

                    if (btn) {
                        if (winScroll > 320) {
                            btn.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-3');
                            btn.classList.add('opacity-100', 'translate-y-0');
                        } else {
                            btn.classList.add('opacity-0', 'pointer-events-none', 'translate-y-3');
                            btn.classList.remove('opacity-100', 'translate-y-0');
                        }
                    }
                    ticking = false;
                });
                ticking = true;
            }
        };

        window.addEventListener('scroll', window._tbScrollEffectsHandler, { passive: true });
    }

    window._tbScrollEffectsHandler();
}

// 5. Smooth Inertial Wheel Scroll Rendering (Zero-Layout-Thrash)
function initSmoothWheelScroll() {
    if (window._tbSmoothWheelInit) return;
    window._tbSmoothWheelInit = true;

    let currentY = window.scrollY || window.pageYOffset || 0;
    let targetY = currentY;
    let cachedMaxScroll = Math.max(0, document.documentElement.scrollHeight - window.innerHeight);
    let rafId = null;
    let lastTime = 0;
    let lerpFactor = 0.115;

    function refreshMaxScroll() {
        cachedMaxScroll = Math.max(0, document.documentElement.scrollHeight - window.innerHeight);
        return cachedMaxScroll;
    }

    function canScrollableAncestorConsume(el, deltaY) {
        let node = el;
        while (node && node !== document.body && node !== document.documentElement) {
            if (node.nodeType === 1) {
                const tag = node.tagName;
                if (tag === 'TEXTAREA' || tag === 'SELECT') return true;
                if (node.clientHeight > 0 && node.scrollHeight > node.clientHeight + 1) {
                    const overflowY = window.getComputedStyle(node).overflowY;
                    if (overflowY === 'auto' || overflowY === 'scroll') {
                        if (deltaY < 0 && node.scrollTop > 0) return true;
                        if (deltaY > 0 && node.scrollTop + node.clientHeight < node.scrollHeight - 1) return true;
                    }
                }
            }
            node = node.parentElement;
        }
        return false;
    }

    function tick(now) {
        if (!lastTime) lastTime = now;
        const dt = Math.min(34, Math.max(4, now - lastTime));
        lastTime = now;

        targetY = Math.max(0, Math.min(cachedMaxScroll, targetY));

        const diff = targetY - currentY;
        if (Math.abs(diff) < 0.6) {
            currentY = targetY;
            window.scrollTo(0, Math.round(currentY));
            rafId = null;
            lastTime = 0;
            return;
        }

        // Frame-rate independent exponential smoothing
        const alpha = 1 - Math.pow(1 - lerpFactor, dt / 16.667);
        currentY += diff * alpha;
        window.scrollTo(0, Math.round(currentY));
        rafId = window.requestAnimationFrame(tick);
    }

    window.tbScrollTo = function (y) {
        refreshMaxScroll();
        if (rafId === null) {
            currentY = window.scrollY || window.pageYOffset || 0;
        }
        lerpFactor = 0.115;
        targetY = Math.max(0, Math.min(cachedMaxScroll, y));
        if (rafId === null) {
            lastTime = 0;
            rafId = window.requestAnimationFrame(tick);
        }
    };

    window.tbSmoothScrollReset = function (y) {
        if (rafId !== null) {
            window.cancelAnimationFrame(rafId);
            rafId = null;
        }
        lastTime = 0;
        refreshMaxScroll();
        const nextY = typeof y === 'number' ? y : (window.scrollY || window.pageYOffset || 0);
        currentY = nextY;
        targetY = nextY;
    };

    window.addEventListener('resize', refreshMaxScroll, { passive: true });

    document.addEventListener('wheel', function (e) {
        if (e.defaultPrevented || e.ctrlKey || e.metaKey || e.altKey) return;
        if (document.body.classList.contains('overflow-hidden') || document.body.style.overflow === 'hidden') return;
        if (Math.abs(e.deltaY) < Math.abs(e.deltaX)) return;
        if (canScrollableAncestorConsume(e.target, e.deltaY)) return;

        let delta = e.deltaY;
        if (e.deltaMode === 1) delta *= 32;
        else if (e.deltaMode === 2) delta *= window.innerHeight;

        const isTrackpad = e.deltaMode === 0 && Math.abs(delta) < 40;
        lerpFactor = isTrackpad ? 0.28 : 0.115;
        if (!isTrackpad) delta *= 1.1;

        e.preventDefault();

        if (rafId === null) {
            refreshMaxScroll();
            currentY = window.scrollY || window.pageYOffset || 0;
            targetY = currentY;
        }

        targetY = Math.max(0, Math.min(cachedMaxScroll, targetY + delta));

        if (rafId === null) {
            lastTime = 0;
            rafId = window.requestAnimationFrame(tick);
        }
    }, { passive: false });

    // Keep synced when user scrolls via scrollbar, keyboard, or native scrollTo
    window.addEventListener('scroll', function () {
        if (rafId === null) {
            currentY = window.scrollY || window.pageYOffset || 0;
            targetY = currentY;
        }
    }, { passive: true });
}

function initAllAppEffects() {
    initTiltCards();
    initHeroParallax();
    initScrollReveal();
    initScrollEffects();
    initSmoothWheelScroll();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAllAppEffects);
} else {
    initAllAppEffects();
}

// Instant Single-Click Public Navigation Engine (PJAX + Hover/Background Prefetch)
(function () {
    const _tbAppPageCache = new Map();
    const _tbAppInFlight = new Map();
    const _tbLoadedScriptSrcs = new Set();
    const CACHE_TTL_MS = 90000;
    let _activeNavController = null;
    let _bgPrefetchController = null;

    function normalizeAppUrl(url) {
        try {
            const u = new URL(url, window.location.origin);
            u.hash = '';
            if (u.pathname === '/') {
                u.pathname = '/home';
            }
            return u.href;
        } catch (e) {
            return url;
        }
    }

    function isPjaxEligibleAppUrl(rawHref) {
        if (!rawHref || rawHref.startsWith('#') || rawHref.startsWith('javascript:') || rawHref.startsWith('mailto:') || rawHref.startsWith('tel:')) {
            return false;
        }
        try {
            const u = new URL(rawHref, window.location.origin);
            if (u.origin !== window.location.origin) return false;
            const p = u.pathname;
            if (
                p.startsWith('/admin') ||
                p.startsWith('/login') ||
                p.startsWith('/register') ||
                p.startsWith('/logout') ||
                p.startsWith('/gofood') ||
                p.startsWith('/checkout') ||
                p.startsWith('/payment')
            ) {
                return false;
            }
            return true;
        } catch (e) {
            return false;
        }
    }

    function isNavPathActive(linkPathname, targetPathname) {
        const lp = linkPathname === '/' ? '/home' : linkPathname;
        const tp = targetPathname === '/' ? '/home' : targetPathname;
        if (lp === '/home') return tp === '/home';
        if (lp === '/menu') return tp === '/menu' || tp.startsWith('/menu/');
        return tp === lp || tp.startsWith(lp + '/');
    }

    function updateAppNavHighlight(targetUrl) {
        let targetPath = '/home';
        try {
            const p = new URL(targetUrl, window.location.origin).pathname;
            targetPath = p === '/' ? '/home' : p;
        } catch (e) {}

        // Desktop Navbar Links
        document.querySelectorAll('header nav a[href]').forEach(a => {
            try {
                const aPath = new URL(a.href, window.location.origin).pathname;
                const active = isNavPathActive(aPath, targetPath);
                if (active) {
                    a.className = 'px-4 py-1.5 rounded-full transition text-sm font-bold bg-white/20 text-white shadow-xs';
                } else {
                    a.className = 'px-4 py-1.5 rounded-full transition text-sm font-bold text-white/80 hover:text-white hover:bg-white/10';
                }
            } catch (e) {}
        });

        // Mobile Dropdown Menu Links
        document.querySelectorAll('#mobile-nav-menu a[data-page-transition]').forEach(a => {
            try {
                const aPath = new URL(a.href, window.location.origin).pathname;
                const active = isNavPathActive(aPath, targetPath);
                if (active) {
                    a.className = 'block px-4 py-2 rounded-xl transition bg-[#3b6e64]/10 text-[#3b6e64]';
                } else {
                    a.className = 'block px-4 py-2 rounded-xl transition text-gray-700 hover:text-gray-900 hover:bg-gray-100';
                }
            } catch (e) {}
        });

        // Mobile Bottom Dock Links
        document.querySelectorAll('nav[aria-label="Mobile Navigation"] a[href]').forEach(a => {
            try {
                const aPath = new URL(a.href, window.location.origin).pathname;
                const active = isNavPathActive(aPath, targetPath);
                if (active) {
                    a.classList.remove('text-gray-500', 'font-medium');
                    a.classList.add('text-[#27443E]', 'font-black');
                } else {
                    a.classList.remove('text-[#27443E]', 'font-black');
                    a.classList.add('text-gray-500', 'font-medium');
                }
            } catch (e) {}
        });
    }

    function extractAppPagePayload(htmlText) {
        const parser = new DOMParser();
        const doc = parser.parseFromString(htmlText, 'text/html');
        const mainEl = doc.querySelector('main');
        if (!mainEl) return null;
        return {
            title: doc.title || document.title,
            mainHtml: mainEl.innerHTML,
            ts: Date.now()
        };
    }

    function prefetchAppUrl(url, isPriority) {
        const key = normalizeAppUrl(url);
        const cached = _tbAppPageCache.get(key);
        if (cached && (Date.now() - cached.ts < CACHE_TTL_MS)) {
            return Promise.resolve(cached);
        }
        if (_tbAppInFlight.has(key)) {
            return _tbAppInFlight.get(key);
        }

        if (isPriority && _bgPrefetchController) {
            try { _bgPrefetchController.abort(); } catch (e) {}
            _bgPrefetchController = null;
        }

        const controller = new AbortController();
        if (!isPriority) {
            _bgPrefetchController = controller;
        }

        const promise = fetch(key, {
            method: 'GET',
            credentials: 'same-origin',
            signal: controller.signal,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-TB-PJAX': '1',
                'Accept': 'text/html,application/xhtml+xml'
            }
        })
        .then(res => {
            if (!res.ok || res.redirected && res.url.includes('/login')) return null;
            return res.text();
        })
        .then(html => {
            _tbAppInFlight.delete(key);
            if (!html) return null;
            const payload = extractAppPagePayload(html);
            if (payload) {
                _tbAppPageCache.set(key, payload);
            }
            return payload;
        })
        .catch(() => {
            _tbAppInFlight.delete(key);
            return null;
        });

        _tbAppInFlight.set(key, promise);
        return promise;
    }

    function executeAppMainScripts(mainEl) {
        const scripts = Array.from(mainEl.querySelectorAll('script'));
        const externalPromises = [];

        scripts.forEach(oldScript => {
            if (oldScript.src) {
                const src = oldScript.src;
                oldScript.remove();
                if (_tbLoadedScriptSrcs.has(src) || (src.includes('leaflet') && typeof window.L !== 'undefined')) {
                    _tbLoadedScriptSrcs.add(src);
                    return;
                }
                const p = new Promise(resolve => {
                    const s = document.createElement('script');
                    s.src = src;
                    s.onload = () => { _tbLoadedScriptSrcs.add(src); resolve(); };
                    s.onerror = () => resolve();
                    document.head.appendChild(s);
                });
                externalPromises.push(p);
            }
        });

        const runInline = () => {
            scripts.forEach(oldScript => {
                if (!oldScript.src) {
                    const newScript = document.createElement('script');
                    Array.from(oldScript.attributes).forEach(attr => {
                        newScript.setAttribute(attr.name, attr.value);
                    });
                    newScript.textContent = oldScript.textContent;
                    oldScript.parentNode.replaceChild(newScript, oldScript);
                }
            });
            window.dispatchEvent(new CustomEvent('tb:pjax:loaded'));
        };

        if (externalPromises.length > 0) {
            Promise.all(externalPromises).then(runInline);
        } else {
            runInline();
        }
    }

    function applyAppPayload(url, payload, pushHistory, preserveScroll = false) {
        const mainEl = document.querySelector('main');
        if (!mainEl || !payload) return false;

        const currentScrollY = preserveScroll ? window.scrollY : 0;
        const currentScrollX = preserveScroll ? window.scrollX : 0;

        document.title = payload.title;
        mainEl.innerHTML = payload.mainHtml;

        const mobileMenu = document.getElementById('mobile-nav-menu');
        if (mobileMenu) mobileMenu.classList.add('hidden');
        const searchDropdown = document.getElementById('home-search-dropdown');
        if (searchDropdown) searchDropdown.classList.add('hidden');

        if (pushHistory && normalizeAppUrl(window.location.href) !== normalizeAppUrl(url)) {
            window.history.pushState({ tbAppPjax: true, url: url, scrollY: currentScrollY }, payload.title, url);
        }

        updateAppNavHighlight(url);
        if (preserveScroll) {
            window.scrollTo({ top: currentScrollY, left: currentScrollX, behavior: 'instant' });
            if (typeof window.tbSmoothScrollReset === 'function') window.tbSmoothScrollReset(currentScrollY);
        } else {
            window.scrollTo({ top: 0, left: 0, behavior: 'instant' });
            if (typeof window.tbSmoothScrollReset === 'function') window.tbSmoothScrollReset(0);
        }

        executeAppMainScripts(mainEl);
        initTiltCards();
        initHeroParallax();
        initScrollReveal();
        initScrollEffects();
        if (typeof window.initAutoDismissAlerts === 'function') {
            window.initAutoDismissAlerts();
        }
        if (typeof window.applyAppTranslations === 'function') {
            const activeLang = window._tbAppLang || localStorage.getItem('tb_lang') || 'ID';
            if (activeLang === 'EN' || activeLang === 'US') {
                window.applyAppTranslations('EN');
            }
        }
        return true;
    }

    window.tbAppNavigate = function (url, pushHistory = true, preserveScroll = false) {
        const key = normalizeAppUrl(url);
        updateAppNavHighlight(key);

        const cached = _tbAppPageCache.get(key);
        if (cached && (Date.now() - cached.ts < CACHE_TTL_MS)) {
            applyAppPayload(url, cached, pushHistory, preserveScroll);
            return;
        }

        if (_activeNavController) {
            try { _activeNavController.abort(); } catch (e) {}
        }
        _activeNavController = new AbortController();

        prefetchAppUrl(key, true).then(payload => {
            if (payload) {
                applyAppPayload(url, payload, pushHistory, preserveScroll);
            } else {
                window.location.href = url;
            }
        });
    };

    document.addEventListener('DOMContentLoaded', () => {
        try { updateAppNavHighlight(window.location.href); } catch (e) {}
        const mainEl = document.querySelector('main');
        if (mainEl) {
            _tbAppPageCache.set(normalizeAppUrl(window.location.href), {
                title: document.title,
                mainHtml: mainEl.innerHTML,
                ts: Date.now()
            });
        }

        // Warm up primary public navigation pages sequentially during browser idle time after initial load
        const warmUpPublicNav = () => {
            if (navigator.connection && (navigator.connection.saveData || /2g/.test(navigator.connection.effectiveType || ''))) {
                return;
            }
            const runWarmUp = async () => {
                const links = Array.from(document.querySelectorAll('header nav a[href]'))
                    .map(a => a.href)
                    .filter(href => isPjaxEligibleAppUrl(href));

                for (const href of links) {
                    const key = normalizeAppUrl(href);
                    if (!_tbAppPageCache.has(key)) {
                        await prefetchAppUrl(key, false);
                    }
                }
            };
            if ('requestIdleCallback' in window) {
                window.requestIdleCallback(() => { runWarmUp(); }, { timeout: 2000 });
            } else {
                setTimeout(runWarmUp, 600);
            }
        };

        if (document.readyState === 'complete') {
            warmUpPublicNav();
        } else {
            window.addEventListener('load', warmUpPublicNav, { once: true });
        }
    });

    // Prefetch on hover/mousedown/touchstart so clicking is instant
    const triggerAppPrefetch = (e) => {
        const link = e.target.closest('a[href]');
        if (!link) return;
        const rawHref = link.getAttribute('href');
        if (link.target === '_blank' || link.hasAttribute('download') || !isPjaxEligibleAppUrl(rawHref)) return;
        prefetchAppUrl(link.href, true);
    };
    document.addEventListener('pointerover', triggerAppPrefetch, { passive: true });
    document.addEventListener('mousedown', triggerAppPrefetch, { passive: true });
    document.addEventListener('touchstart', triggerAppPrefetch, { passive: true });

    // Intercept single clicks on internal public links
    document.addEventListener('click', (e) => {
        if (e.defaultPrevented || e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
        const link = e.target.closest('a[href]');
        if (!link) return;
        const rawHref = link.getAttribute('href');
        if (link.target === '_blank' || link.hasAttribute('download') || !isPjaxEligibleAppUrl(rawHref)) return;

        const preserveScroll = link.hasAttribute('data-preserve-scroll');

        e.preventDefault();
        window.tbAppNavigate(link.href, true, preserveScroll);
    });

    // Intercept GET search/filter forms pointing to internal public routes
    document.addEventListener('submit', (e) => {
        const form = e.target;
        if (!form || form.tagName !== 'FORM') return;
        const method = (form.getAttribute('method') || 'GET').toUpperCase();
        if (method === 'GET') {
            const action = form.getAttribute('action') || window.location.pathname;
            if (!isPjaxEligibleAppUrl(action)) return;
            e.preventDefault();
            const u = new URL(action, window.location.origin);
            const fd = new FormData(form);
            u.search = new URLSearchParams(fd).toString();
            const preserveScroll = form.hasAttribute('data-preserve-scroll');
            window.tbAppNavigate(u.href, true, preserveScroll);
        } else {
            _tbAppPageCache.clear();
        }
    });

    window.addEventListener('popstate', (e) => {
        if (isPjaxEligibleAppUrl(window.location.href)) {
            const state = e.state || {};
            const preserveScroll = typeof state.scrollY === 'number';
            window.tbAppNavigate(window.location.href, false, preserveScroll);
        }
    });
})();

// ==========================================
// App Master Translation (i18n) Engine
// ==========================================
const _tbPhraseMap = {
    // Brand & Hero
    'SETIAP GIGITAN PUNYA CERITA!': 'EVERY BITE HAS A STORY!',
    'SETIAP GIGITAN': 'EVERY BITE',
    'PUNYA CERITA!': 'HAS A STORY!',
    'MAU MAKAN APA HARI INI?': 'WHAT WOULD YOU LIKE TO EAT TODAY?',
    'MAU MAKAN': 'WHAT WOULD YOU LIKE',
    'APA HARI INI?': 'TO EAT TODAY?',
    'Nikmati perpaduan rasa, tekstur, dan bahan pilihan dalam setiap hidangan.': 'Enjoy the blend of flavors, textures, and premium ingredients in every dish.',
    'Pickup Order': 'Pickup Order',
    'Delivery Order': 'Delivery Order',
    'VERY CHEESE BURGER': 'VERY CHEESE BURGER',

    // Navigation
    'Beranda': 'Home',
    'Menu': 'Menu',
    'Tentang': 'About',
    'Kontak': 'Contact',
    'Pesanan Saya': 'My Orders',
    'Dashboard Admin': 'Admin Dashboard',
    'Logout': 'Logout',
    'Login': 'Login',
    'Sign In': 'Sign Up',
    'Cheese Burger...': 'Cheese Burger...',
    'Mencari menu...': 'Searching menu...',
    'Kembali ke atas': 'Back to top',

    // Why Us Section
    'Keunggulan Kami': 'Our Advantages',
    'KENAPA TOON BURGER?': 'WHY TOON BURGER?',
    'Nikmati sensasi kelezatan burger terbaik dengan daging pilihan dan bahan segar yang siap memuaskan rasa lapar Anda kapan saja.': 'Enjoy the finest burger sensation crafted with selected meats and fresh ingredients, ready to satisfy your hunger anytime.',
    'Terbuat dari 100% Daging': 'Made from 100% Meat',
    'Nikmati patty berkualitas yang dibuat dari 100% daging pilihan.': 'Enjoy quality patties made from 100% selected beef.',
    'Bahan Segar Setiap Hari': 'Fresh Ingredients Daily',
    'Selalu fresh setiap hari, karena rasa terbaik dimulai dari bahan berkualitas.': 'Always fresh every single day, because the best flavor begins with quality ingredients.',
    'Pesanan Cepat': 'Fast Service',
    'Disiapkan dengan cepat tanpa mengorbankan kualitas dan cita rasa.': 'Prepared quickly without ever compromising quality and flavor.',
    'Porsi Bikin Kenyang': 'Satisfying Portions',
    'Porsi pas dan mengenyangkan, cocok untuk menemani rasa lapar kapan saja.': 'Generous and filling portions, perfect for satisfying your hunger anytime.',

    // Best Seller Section & Home Page
    'BEST SELLER': 'BEST SELLERS',
    'SEMUA MENU': 'ALL MENUS',
    'Semua Menu': 'All Menus',
    'Sudah jadi favorit banyak pelanggan, sekarang saatnya kamu mencoba menu yang paling banyak dipesan.': 'A customer favorite, now it is time for you to try our most ordered burgers.',
    'Lihat Semua': 'View All',
    'Lihat Semua Menu': 'View All Menus',
    'Menu Tidak Ditemukan': 'Menu Not Found',
    'Menu yang Anda cari tidak tersedia. Silakan cek menu favorit lainnya.': 'The menu item you are looking for is not available. Please check our other favorites.',
    'Pesan': 'Order',
    'Semua': 'All',
    'Minuman': 'Drinks',
    'Pilihan terbaik dari Toon Burger.': 'The finest choice from Toon Burger.',
    'Deskripsi menu lezat dari Toon Burger.': 'Delicious menu description from Toon Burger.',
    'Dua lapis beef patty juicy, double keju cheddar leleh, caramelized onion, dan...': 'Two layers of juicy beef patties, double melted cheddar, caramelized onions, and...',
    'Dada ayam krispi juicy berpadu lelehan keju cheddar, selada segar, dan tomat...': 'Crispy juicy chicken breast paired with melted cheddar, fresh lettuce, and tomato...',
    'Beef patty daging sapi asli gurih berselimut saus smokey BBQ karamel...': 'Savory real beef patty coated in rich caramelized smokey BBQ sauce...',
    'Dua patty daging sapi panggang juicy dengan limpahan keju cheddar ganda...': 'Two juicy grilled beef patties with overflowing double cheddar cheese...',

    // Home Banners
    'NGGAK SEMPAT  KE TOKO? GOFOOD AJA!': 'NO TIME TO VISIT? ORDER ON GOFOOD!',
    'NGGAK SEMPAT KE TOKO? GOFOOD AJA!': 'NO TIME TO VISIT? ORDER ON GOFOOD!',
    'Burger favoritmu diantar langsung ke rumah, langsung dari aplikasi Gojek': 'Your favorite burger delivered straight to your home, directly from the Gojek app',
    'Buka Gojek': 'Open Gojek',
    'Buka GoFood': 'Open GoFood',
    'MENGENAL TOON BURGER': 'ABOUT TOON BURGER',
    'MENGENAL TOON': 'ABOUT TOON',
    'Berawal dari kecintaan kami terhadap burger bergaya klasik Amerika dengan daging beraroma asap yang gurih dan roti brioche harum mentega, Toon Burger hadir membawa nuansa karakter kartun retro yang': 'Born from our love for classic American-style burgers with savory smoky meats and buttery brioche buns, Toon Burger brings a vibrant retro cartoon spirit that is',
    'enerjik, ceria, dan bersahabat bagi siapa saja.': 'energetic, cheerful, and welcoming to everyone.',
    'Setiap patty daging sapi digiling dari potongan daging segar berkualitas pilihan, saus diracik segar setiap pagi di dapur restoran, dan kebersihan adalah standar utama kami.': 'Every beef patty is ground from select quality cuts, sauces are prepared fresh every morning in our kitchen, and cleanliness is our highest standard.',
    'Selengkapnya Tentang Kami': 'Learn More About Us',
    'ADA YANG MAU DITANYAIN?': 'HAVE ANY QUESTIONS?',
    'Ada pertanyaan soal menu, lokasi, atau jam buka? Kami siap membantu.': 'Have questions about our menu, location, or opening hours? We are ready to help.',
    'Kontak Kami': 'Contact Us',

    // About Page
    'TENTANG TOON BURGER': 'ABOUT TOON BURGER',
    'Toon Burger lahir dari mimpi sederhana: menciptakan burger yang tidak hanya mengenyangkan perut, tetapi juga menghadirkan kebahagiaan sejati seperti saat menonton kartun favorit di masa kecil.': 'Toon Burger was born from a simple dream: creating burgers that not only satisfy hunger, but also bring genuine joy just like watching your favorite childhood cartoons.',
    'Banyak burger modern kehilangan jati dirinya, seperti daging yang kering, roti yang terlalu manis, atau saus buatan pabrik yang serba instan. Di Toon Burger, kami memilih jalur yang berbeda: kami menggunakan': 'Many modern burgers have lost their soul, with dry patties, overly sweet buns, or mass-produced instant sauces. At Toon Burger, we take a different path: we use',
    '100% daging sapi lokal pilihan': '100% selected local beef',
    'tanpa campuran tepung, memanggang roti brioche mentega lembut setiap pagi, dan meracik saus khas dapur kami dari nol.': 'with zero flour fillers, bake soft buttery brioche buns fresh every morning, and craft our signature sauces from scratch.',
    'Burger Terjual & Ludes': 'Burgers Sold Out',
    'Terbuat dari daging asli': 'Made from 100% Real Meat',
    'Kepuasan Pelanggan': 'Customer Satisfaction',
    'Rating pelanggan di Gofood': 'Customer Rating on GoFood',
    'Visi dan Misi': 'Vision and Mission',
    'Visi Kami': 'Our Vision',
    'Misi Kami': 'Our Mission',
    'VISI KAMI': 'OUR VISION',
    'MISI KAMI': 'OUR MISSION',
    'FILOSOFI KAMI': 'OUR PHILOSOPHY',
    'Filosofi Kami': 'Our Philosophy',
    'KENAPA HARUS TOON BURGER?': 'WHY CHOOSE TOON BURGER?',
    'Komitmen Kualitas': 'Quality Commitment',
    'Karakter & Cita Rasa Otentik': 'Authentic Character & Flavor',
    'Pelayanan Penuh Senyuman': 'Service with a Smile',
    'KATA MEREKA YANG UDAH NYOBA!': 'WHAT OUR CUSTOMERS SAY!',
    'Karena rasa yang enak nggak bohong, intip apa kata mereka yang udah ngerasain kenyang puasnya burger racikan dapur kami.': 'Because great taste never lies, see what our satisfied customers have to say about our signature burgers.',
    'Menjadi destinasi burger lokal kebanggaan Banjarbaru yang menyajikan rasa daging sapi asli, roti brioche panggang segar, dan saus racikan dapur sendiri dalam setiap porsi yang jujur dan mengenyangkan.': "To become Banjarbaru's pride local burger destination, serving authentic beef flavors, freshly baked brioche buns, and house-made sauces in every honest, satisfying portion.",
    'Menggiling 100% daging sapi pilihan tanpa campuran tepung setiap hari, memanggang burger saat pesanan masuk agar tiba tetap hangat, serta menjaga standar dapur halal dan bersih untuk setiap pelanggan.': 'Grinding 100% select beef with zero flour fillers every single day, grilling burgers freshly upon order to serve hot, and upholding strict halal and clean kitchen standards for every customer.',

    // Contact Page
    'TEMUKAN LOKASI OUTLET KAMI!': 'FIND OUR OUTLET LOCATION!',
    'Kami hadir lebih dekat dengan Anda. Mampir dan nikmati pengalaman terbaik bersama kami!': 'We are closer to you. Drop by and enjoy the best dining experience with us!',
    'Kami hadir lebih dekat dengan Anda. Mampir dan nikmati pengalaman': 'We are closer to you. Drop by and enjoy the best experience',
    'terbaik bersama kami!': 'with us!',
    'Peta Jalan': 'Road Map',
    'Satelit Google': 'Google Satellite',
    'PERTANYAAN YANG SERING DITANYAKAN': 'FREQUENTLY ASKED QUESTIONS',
    'PERTANYAAN YANG': 'FREQUENTLY',
    'SERING DITANYAKAN': 'ASKED QUESTIONS',
    'Masih ragu dan punya pertanyaan sebelum memesan? Temukan semua jawabannya di sini.': 'Still have questions before ordering? Find all the answers right here.',
    'Bisakah saya mengubah atau membatalkan pesanan yang sudah dibayar?': 'Can I change or cancel an order that has already been paid?',
    'Karena tim dapur langsung memanggang burger begitu pesanan masuk, pembatalan tidak dapat dilakukan setelah pesanan masuk tahap Cooking. Untuk perubahan mendesak, segera hubungi admin via tombol WhatsApp di website.': 'Because our kitchen team starts grilling burgers immediately upon receiving an order, cancellations cannot be made once cooking starts. For urgent changes, please contact our admin immediately via WhatsApp.',
    'Bisakah saya custom pesanan, misal tanpa acar/bawang atau ekstra keju?': 'Can I customize my order, e.g. no pickles/onions or extra cheese?',
    'Tentu bisa! Saat memilih menu di halaman katalog, Anda dapat menyesuaikan tambahan topping seperti ekstra keju atau menuliskan catatan khusus untuk koki sebelum memasukkan menu ke keranjang.': 'Of course! When choosing a menu item in the catalog, you can customize extra toppings or write special notes for the chef before adding to your cart.',
    'Apakah Toon Burger melayani pesan antar langsung lewat website ini?': 'Does Toon Burger offer direct delivery orders through this website?',
    'Ya! Kami melayani pesan antar langsung melalui website ini untuk area Banjarbaru dan sekitarnya, maupun pemesanan untuk diambil sendiri di outlet (Takeaway).': 'Yes! We serve direct delivery through this website for Banjarbaru and surrounding areas, as well as takeaway pickup at our outlet.',
    'Bagaimana jika saya terlambat mengambil pesanan di outlet?': 'What if I am late picking up my order at the outlet?',
    'Pesanan Anda akan kami jaga tetap hangat menggunakan kemasan khusus. Apabila Anda mengalami kendala di perjalanan, silakan konfirmasi melalui WhatsApp agar tim outlet kami dapat membantu menyimpan pesanan Anda.': 'Your order will be kept warm in special insulated packaging. If you encounter travel delays, please notify us via WhatsApp so our team can hold your order safely.',
    'LET\'S GET IN TOUCH WITH US!': 'LET\'S GET IN TOUCH WITH US!',
    'LET\'S GET IN TOUCH': 'LET\'S GET IN TOUCH',
    'WITH US!': 'WITH US!',
    'Nama Lengkap': 'Full Name',
    'Nama Lengkap Anda': 'Your Full Name',
    'Nomor Telefon': 'Phone Number',
    'Pesan': 'Message',
    'Tulis Pesan Anda Disini....': 'Write your message here...',
    'Kirim Pesan': 'Send Message',
    'Pesan Terkirim!': 'Message Sent!',
    'Terima kasih! Pesan Anda telah kami terima dan akan segera direspons oleh tim Toon Burger.': 'Thank you! Your message has been received and will be responded to shortly by the Toon Burger team.',

    // Orders & Checkout
    'Kembali Ke Beranda': 'Back to Home',
    'KONFIRMASI PEMBAYARAN': 'PAYMENT CONFIRMATION',
    'Lengkapi detail pemesanan dan pilih metode pembayaran Anda': 'Complete your order details and choose your payment method',
    'Nomor Telfon': 'Phone Number',
    'Nomor Telfon Anda': 'Your Phone Number',
    'Catatan Pesanan': 'Order Notes',
    'Pilih Metode Pembayaran': 'Select Payment Method',
    'Tunai': 'Cash',
    'Bayar langsung dikasir': 'Pay directly at counter',
    'BCA/ Mandiri Virtual Account': 'BCA / Mandiri Virtual Account',
    'Keranjang kosong': 'Cart is empty',
    'Pajak PPN (11%)': 'VAT Tax (11%)',
    'Riwayat Pesanan': 'Order History',
    'Riwayat Pesanan Saya': 'My Order History',
    'Daftar semua transaksi dan pesanan yang pernah Anda buat di Toon Burger.': 'List of all transactions and orders you have made at Toon Burger.',
    '+ Pesan Baru': '+ New Order',
    '[Belum Ada Data]': '[No Data Yet]',
    'Belum ada riwayat pesanan': 'No order history yet',
    'Anda belum pernah melakukan pemesanan burger.': 'You have not placed any burger orders yet.',
    'Mulai Pesan Sekarang': 'Start Ordering Now',
    'Lihat Detail →': 'View Details →',
    'Lihat Detail': 'View Details',
    'Tipe:': 'Type:',
    'Pembayaran:': 'Payment:',
    'Menu:': 'Items:',
    'Item': 'Items',
    'Checkout Pesanan': 'Order Checkout',
    'Kembali ke Katalog Menu': 'Back to Menu Catalog',
    'Konfirmasi & Pembayaran': 'Confirmation & Payment',
    'Lengkapi detail pemesanan dan pilih metode pembayaran favorit Anda.': 'Complete your order details and choose your preferred payment method.',
    'Pilih Tipe Pesanan': 'Select Order Type',
    'Takeaway (Bawa Pulang)': 'Takeaway (Pickup)',
    'Ambil pesanan di outlet Banjarbaru': 'Pick up order at Banjarbaru outlet',
    'Online Delivery': 'Online Delivery',
    'Diantar kurir langsung ke alamat Anda': 'Delivered directly by courier to your address',
    'Alamat Lengkap Pengiriman:': 'Complete Delivery Address:',
    'Nama Jalan, No. Rumah, RT/RW, Patokan...': 'Street Name, House No., RT/RW, Landmarks...',
    'Mau promo ongkir hemat? Anda juga bisa pesan antar via GoFood Toon Burger (Super Partner).': 'Looking for delivery discounts? You can also order delivery via GoFood Toon Burger (Super Partner).',
    'Outlet Toon Burger berkonsep Cloud Kitchen & Takeaway Hub. Kami hanya melayani Takeaway dan Delivery (tidak tersedia makan di tempat).': 'Toon Burger operates on a Cloud Kitchen & Takeaway Hub concept. We only serve Takeaway and Delivery (dine-in not available).',
    'Informasi Pemesan': 'Customer Information',
    'Nama Pemesan:': 'Customer Name:',
    'Nama Pemesan': 'Customer Name',
    'No. WhatsApp / Telepon:': 'WhatsApp / Phone Number:',
    'No. Telepon': 'Phone Number',
    'Catatan Tambahan untuk Pesanan (Opsional):': 'Additional Order Notes (Optional):',
    'Contoh: Budi Santoso': 'e.g. John Doe',
    'Contoh: 0813-4595-6487': 'e.g. 0813-4595-6487',
    'Contoh: Tolong bungkus terpisah, extra saus sambal...': 'e.g. Please wrap separately, extra chili sauce...',
    'Metode Pembayaran': 'Payment Method',
    'QRIS Instant': 'Instant QRIS',
    'Otomatis': 'Automatic',
    'Tunai di Kasir': 'Cash at Counter',
    'Bayar langsung saat pesanan disiapkan': 'Pay in person while order is prepared',
    'Transfer Bank': 'Bank Transfer',
    'BCA / Mandiri Virtual Account': 'BCA / Mandiri Virtual Account',
    'E-Wallet': 'E-Wallet',
    'Direct wallet checkout': 'Direct wallet checkout',
    'Ringkasan Pesanan': 'Order Summary',
    'Subtotal Menu:': 'Menu Subtotal:',
    'Pajak Restoran PB1 (10%):': 'Restaurant Tax PB1 (10%):',
    'Total Tagihan:': 'Total Bill:',
    'Bayar Sekarang': 'Pay Now',
    'Buat Pesanan Sekarang': 'Place Order Now',
    'Pesanan Anda langsung diteruskan ke sistem dapur Toon Burger.': 'Your order is directly forwarded to the Toon Burger kitchen system.',
    'Status & Bukti Pesanan': 'Order Status & Receipt',
    'Cetak Struk': 'Print Receipt',
    '+ Pesan Lagi': '+ Order Again',
    'Status Dapur': 'Kitchen Status',
    'Menunggu Konfirmasi Dapur': 'Waiting for Kitchen Confirmation',
    'Pesanan Telah Dikonfirmasi': 'Order Confirmed',
    'Koki Sedang Memasak Pesanan Anda': 'Chef is Cooking Your Order',
    'Pesanan Siap Diambil / Diantar': 'Order Ready for Pickup / Delivery',
    'Pesanan Selesai': 'Order Completed',
    'Pesanan Dibatalkan': 'Order Cancelled',
    'Status Pembayaran': 'Payment Status',
    'LUNAS': 'PAID',
    'BELUM DIBAYAR': 'UNPAID',
    'Menunggu': 'Pending',
    'Dikonfirmasi': 'Confirmed',
    'Dimasak': 'Cooking',
    'Siap Saji': 'Ready',
    'Selesai': 'Completed',
    'Dibatalkan': 'Cancelled',
    'Pembayaran Diperlukan': 'Payment Required',
    'Tampilkan Kode QRIS': 'Show QRIS Code',
    'Bayar Sekarang (Simulasi Lunas)': 'Pay Now (Simulate Paid)',
    'Tipe Pesanan': 'Order Type',
    'Alamat Pengiriman:': 'Delivery Address:',
    'Rincian Menu yang Dipesan': 'Ordered Menu Details',
    'Beri Ulasan Menu Ini': 'Review This Item',
    'Beri Ulasan Menu': 'Review Menu Item',
    'Nama Menu': 'Menu Name',
    'Rating Penilaian (1 - 5):': 'Rating (1 - 5):',
    'Bintang 5 (Sangat Enak & Puas)': '5 Stars (Delicious & Very Satisfied)',
    'Bintang 4 (Enak & Sesuai)': '4 Stars (Tasty & Good)',
    'Bintang 3 (Cukup Baik)': '3 Stars (Fair & Acceptable)',
    'Bintang 2 (Kurang Sesuai)': '2 Stars (Needs Improvement)',
    'Bintang 1 (Mengecewakan)': '1 Star (Disappointing)',
    'Komentar & Saran:': 'Comments & Feedback:',
    'Ceritakan rasa burger atau kemasan Toon Burger...': 'Tell us about the burger taste or Toon Burger packaging...',
    'Kirim Ulasan': 'Submit Review',
    'Pembayaran QRIS': 'QRIS Payment',
    'Sisa Waktu Pembayaran:': 'Remaining Payment Time:',
    'Waktu Pembayaran Habis': 'Payment Time Expired',
    'Sesi pembayaran QRIS 5 menit telah berakhir.': 'The 5-minute QRIS payment session has expired.',
    'Muat Ulang Timer': 'Restart Timer',
    'Total yang harus dibayar:': 'Total amount to pay:',
    'Buka aplikasi m-Banking (BCA, Mandiri, BRI, BNI) atau E-Wallet (GoPay, OVO, Dana, ShopeePay), lalu scan barcode QRIS di atas.': 'Open your m-Banking app (BCA, Mandiri, BRI, BNI) or E-Wallet (GoPay, OVO, Dana, ShopeePay), then scan the QRIS barcode above.',
    'Saya Sudah Membayar': 'I Have Paid',
    'Diskon Promo / Kupon:': 'Promo Discount / Coupon:',
    'Total Pembayaran:': 'Total Payment:',

    // Cart Drawer & Modals
    'Keranjang Pesanan': 'Order Cart',
    'Menu Dipilih': 'Items Selected',
    'Keranjangmu masih kosong nih': 'Your cart is still empty',
    'Yuk, pilih burger favoritmu dan mulai ngisi': 'Go ahead, pick your favorite burger and satisfy',
    'perut kosongmu hari ini': 'your cravings today',
    'Diskon Promo:': 'Promo Discount:',
    'Pajak PPN (11%)': 'VAT Tax (11%)',
    'Lanjutkan Ke pembayaran': 'Proceed to Checkout',
    'Catatan Pesanan': 'Order Notes',
    'Contoh: saus dipisah, tanpa selada...': 'e.g., sauce on the side, no lettuce...',
    'Tambahkan ke keranjang': 'Add to cart',
    'berhasil ditambahkan ke keranjang!': 'successfully added to cart!',
    'Buka': 'View',
    'Konfirmasi Logout': 'Confirm Logout',
    'Apakah Anda yakin ingin keluar dari akun? Anda perlu login kembali untuk mengakses halaman admin.': 'Are you sure you want to log out of your account? You will need to log back in to access the system.',
    'Batalkan': 'Cancel',
    'Ya, Logout': 'Yes, Log Out',
    'Logout Berhasil': 'Logout Successful',
    'Wajib Login Terlebih Dahulu': 'Login Required',
    'Login Sekarang': 'Login Now',
    'Nanti Saja': 'Not Now',

    // Footer
    'NAVIGASI': 'NAVIGATION',
    'SOSIAL': 'SOCIAL',
    'JAM BUKA': 'OPENING HOURS',
    'Senin:': 'Monday:',
    '(Tutup)': '(Closed)',
    'Selasa-Jumat:': 'Tuesday-Friday:',
    'Sabtu-Minggu:': 'Saturday-Sunday:',
    'Semua Hak Cipta Dilindungi': 'All Rights Reserved',

    // Extras
    'Gratis': 'Free',
    'Wajib': 'Required',
    'Opsional': 'Optional',
    'Tutup': 'Close'
};

const _tbSortedPhrases = Object.keys(_tbPhraseMap).sort((a, b) => b.length - a.length);

const _tbReversePhraseMap = {};
for (const [idKey, enVal] of Object.entries(_tbPhraseMap)) {
    _tbReversePhraseMap[enVal] = idKey;
}
const _tbSortedReversePhrases = Object.keys(_tbReversePhraseMap).sort((a, b) => b.length - a.length);

const _tbAppTranslations = {
    ID: {
        nav_home: 'Beranda',
        nav_menu: 'Menu',
        nav_about: 'Tentang',
        nav_contact: 'Kontak',
        nav_orders: 'Pesanan Saya',
        nav_admin: 'Dashboard Admin',
        nav_logout: 'Logout',
        nav_search_placeholder: 'Cheese Burger...',
        nav_search_searching: 'Mencari menu...',
        nav_login: 'Login',
        nav_signin: 'Sign In',
        cart_title: 'Keranjang Pesanan',
        cart_empty_title: 'Keranjangmu masih kosong nih',
        cart_empty_sub1: 'Yuk, pilih burger favoritmu dan mulai ngisi',
        cart_empty_sub2: 'perut kosongmu hari ini',
        cart_empty_btn: 'Mulai Pesan Sekarang',
        cart_subtotal: 'Subtotal Menu:',
        cart_discount: 'Diskon Promo:',
        cart_tax: 'Pajak PPN (11%)',
        cart_total: 'Total Tagihan:',
        cart_checkout: 'Lanjutkan Ke pembayaran',
        cart_toast_open: 'Buka',
        modal_notes_label: 'Catatan Pesanan',
        modal_notes_placeholder: 'Contoh: saus dipisah, tanpa selada...',
        modal_add_btn: 'Tambahkan ke keranjang',
        logout_title: 'Konfirmasi Logout',
        logout_desc: 'Apakah Anda yakin ingin keluar dari akun? Anda perlu login kembali untuk mengakses halaman admin.',
        logout_cancel: 'Batalkan',
        logout_confirm: 'Ya, Logout',
        footer_nav: 'NAVIGASI',
        footer_hours: 'JAM BUKA'
    },
    EN: {
        nav_home: 'Home',
        nav_menu: 'Menu',
        nav_about: 'About',
        nav_contact: 'Contact',
        nav_orders: 'My Orders',
        nav_admin: 'Admin Dashboard',
        nav_logout: 'Logout',
        nav_search_placeholder: 'Cheese Burger...',
        nav_search_searching: 'Searching menu...',
        nav_login: 'Login',
        nav_signin: 'Sign Up',
        cart_title: 'Order Cart',
        cart_empty_title: 'Your cart is still empty',
        cart_empty_sub1: 'Go ahead, pick your favorite burger and satisfy',
        cart_empty_sub2: 'your cravings today',
        cart_empty_btn: 'Start Ordering Now',
        cart_subtotal: 'Menu Subtotal:',
        cart_discount: 'Promo Discount:',
        cart_tax: 'VAT Tax (11%)',
        cart_total: 'Total Bill:',
        cart_checkout: 'Proceed to Checkout',
        cart_toast_open: 'View',
        modal_notes_label: 'Order Notes',
        modal_notes_placeholder: 'e.g., sauce on the side, no lettuce...',
        modal_add_btn: 'Add to cart',
        logout_title: 'Confirm Logout',
        logout_desc: 'Are you sure you want to log out of your account? You will need to log back in to access the system.',
        logout_cancel: 'Cancel',
        logout_confirm: 'Yes, Log Out',
        footer_nav: 'NAVIGATION',
        footer_hours: 'OPENING HOURS'
    }
};

window._tbAppLang = 'ID';

function translateEntirePage(lang) {
    const isEn = (lang === 'EN' || lang === 'US');
    const code = isEn ? 'EN' : 'ID';
    window._tbAppLang = code;

    // 1. Process all text nodes across the entire page body
    try {
        const walker = document.createTreeWalker(
            document.body,
            NodeFilter.SHOW_TEXT,
            {
                acceptNode: function (node) {
                    const parent = node.parentElement;
                    if (!parent) return NodeFilter.FILTER_REJECT;
                    const tag = parent.tagName.toUpperCase();
                    if (tag === 'SCRIPT' || tag === 'STYLE' || tag === 'TEXTAREA' || tag === 'INPUT' || tag === 'CODE' || tag === 'PRE') {
                        return NodeFilter.FILTER_REJECT;
                    }
                    if (parent.closest('svg') || parent.classList.contains('fa') || parent.classList.contains('material-icons')) {
                        return NodeFilter.FILTER_REJECT;
                    }
                    const text = node.nodeValue.trim();
                    if (!text) return NodeFilter.FILTER_REJECT;
                    return NodeFilter.FILTER_ACCEPT;
                }
            }
        );

        const nodesToTranslate = [];
        while (walker.nextNode()) {
            nodesToTranslate.push(walker.currentNode);
        }

        nodesToTranslate.forEach(node => {
            if (typeof node._tbOriginalText === 'undefined') {
                node._tbOriginalText = node.nodeValue;
            }

            if (isEn) {
                let currentVal = node.nodeValue;
                const trimmed = currentVal.trim();
                if (_tbPhraseMap[trimmed]) {
                    const leadingSpace = currentVal.match(/^\s*/)[0];
                    const trailingSpace = currentVal.match(/\s*$/)[0];
                    node.nodeValue = leadingSpace + _tbPhraseMap[trimmed] + trailingSpace;
                } else {
                    for (let i = 0; i < _tbSortedPhrases.length; i++) {
                        const idPhrase = _tbSortedPhrases[i];
                        if (currentVal.includes(idPhrase)) {
                            currentVal = currentVal.split(idPhrase).join(_tbPhraseMap[idPhrase]);
                        }
                    }
                    node.nodeValue = currentVal;
                }
            } else {
                if (typeof node._tbOriginalText === 'string') {
                    node.nodeValue = node._tbOriginalText;
                } else {
                    let currentVal = node.nodeValue;
                    const trimmed = currentVal.trim();
                    if (_tbReversePhraseMap[trimmed]) {
                        const leadingSpace = currentVal.match(/^\s*/)[0];
                        const trailingSpace = currentVal.match(/\s*$/)[0];
                        node.nodeValue = leadingSpace + _tbReversePhraseMap[trimmed] + trailingSpace;
                    } else {
                        for (let i = 0; i < _tbSortedReversePhrases.length; i++) {
                            const enPhrase = _tbSortedReversePhrases[i];
                            if (currentVal.includes(enPhrase)) {
                                currentVal = currentVal.split(enPhrase).join(_tbReversePhraseMap[enPhrase]);
                            }
                        }
                        node.nodeValue = currentVal;
                    }
                }
            }
        });
    } catch (err) {
        console.error('Translation walker error:', err);
    }

    // 2. Process input & textarea placeholders
    try {
        const inputs = document.querySelectorAll('input[placeholder], textarea[placeholder]');
        inputs.forEach(el => {
            if (typeof el.dataset.tbOriginalPlaceholder === 'undefined') {
                el.dataset.tbOriginalPlaceholder = el.getAttribute('placeholder') || '';
            }
            if (isEn) {
                const orig = el.dataset.tbOriginalPlaceholder.trim();
                if (_tbPhraseMap[orig]) {
                    el.setAttribute('placeholder', _tbPhraseMap[orig]);
                }
            } else {
                el.setAttribute('placeholder', el.dataset.tbOriginalPlaceholder);
            }
        });
    } catch (err) {}

    // 3. Process [data-i18n-app] elements
    const dict = _tbAppTranslations[code] || _tbAppTranslations['ID'];
    document.querySelectorAll('[data-i18n-app]').forEach(el => {
        const key = el.getAttribute('data-i18n-app');
        if (dict[key] !== undefined && el.textContent !== dict[key]) {
            el.textContent = dict[key];
        }
    });

    document.querySelectorAll('[data-i18n-app-attr]').forEach(el => {
        el.getAttribute('data-i18n-app-attr').split(';').forEach(pair => {
            const [attr, key] = pair.split(':');
            if (attr && key && dict[key.trim()] !== undefined) {
                el.setAttribute(attr.trim(), dict[key.trim()]);
            }
        });
    });

    const toastBtn = document.getElementById('cart-toast-btn');
    if (toastBtn) {
        toastBtn.textContent = dict['cart_toast_open'];
    }

    updateAppLangUI(code);
}

function applyAppTranslations(lang) {
    translateEntirePage(lang);
}

function updateAppLangUI(code) {
    const isEn = (code === 'EN' || code === 'US');
    const labelText = isEn ? 'Language: English' : 'Bahasa: Indonesia';
    const flag = isEn ? '🇺🇸' : '🇮🇩';
    const badgeText = isEn ? 'EN' : 'ID';

    // Desktop dropdown
    const textEl = document.getElementById('app-user-lang-text');
    const flagEl = document.getElementById('app-user-lang-flag');
    const codeEl = document.getElementById('app-user-lang-code');
    if (textEl) textEl.textContent = labelText;
    if (flagEl) flagEl.textContent = flag;
    if (codeEl) codeEl.textContent = badgeText;

    // Mobile nav
    const mobileTextEl = document.getElementById('app-mobile-user-lang-text');
    const mobileFlagEl = document.getElementById('app-mobile-user-lang-flag');
    const mobileCodeEl = document.getElementById('app-mobile-user-lang-code');
    if (mobileTextEl) mobileTextEl.textContent = labelText;
    if (mobileFlagEl) mobileFlagEl.textContent = flag;
    if (mobileCodeEl) mobileCodeEl.textContent = badgeText;
}

function setAppLanguage(lang) {
    const isEn = (lang === 'EN' || lang === 'US');
    const code = isEn ? 'EN' : 'ID';
    window._tbAppLang = code;

    try {
        localStorage.setItem('tb_lang', code);
        localStorage.setItem('tb_admin_lang', isEn ? 'US' : 'ID');
        localStorage.setItem('toon_lang', isEn ? 'en' : 'id');
    } catch (e) {}

    translateEntirePage(code);
    window.dispatchEvent(new CustomEvent('tb:applangchange', { detail: { lang: code } }));
}

function toggleAppLanguage() {
    const isEn = (window._tbAppLang === 'EN' || window._tbAppLang === 'US');
    const nextLang = isEn ? 'ID' : 'EN';
    setAppLanguage(nextLang);
}
window.toggleAppLanguage = toggleAppLanguage;
window.setAppLanguage = setAppLanguage;
window.applyAppTranslations = applyAppTranslations;
window.translateEntirePage = translateEntirePage;

// Auto-dismiss notification alerts
window.dismissAlert = function (alertEl) {
    if (!alertEl || alertEl.dataset.dismissing === 'true') return;
    alertEl.dataset.dismissing = 'true';
    alertEl.classList.add('alert-dismissing');
    setTimeout(function () {
        if (alertEl && alertEl.parentElement) {
            alertEl.remove();
        }
    }, 450);
};

window.initAutoDismissAlerts = function (delay = 3500) {
    const alerts = document.querySelectorAll('.alert-auto-dismiss');
    alerts.forEach(function (alert) {
        if (alert.classList.contains('hidden')) return;
        if (alert.dataset.hasTimer === 'true') return;
        alert.dataset.hasTimer = 'true';
        setTimeout(function () {
            window.dismissAlert(alert);
        }, delay);
    });
};

document.addEventListener('DOMContentLoaded', function () {
    window.initAutoDismissAlerts();
    try {
        const savedLang = localStorage.getItem('tb_lang') || localStorage.getItem('tb_admin_lang') || 'ID';
        const initialLang = (savedLang === 'EN' || savedLang === 'US') ? 'EN' : 'ID';
        if (initialLang === 'EN') {
            applyAppTranslations('EN');
        } else {
            updateAppLangUI('ID');
        }
    } catch (e) {}
});

// Reload page on Back / Forward navigation only if user logged out
window.addEventListener('pageshow', function () {
    try {
        if (localStorage.getItem('tb_logged_out') === '1') {
            localStorage.removeItem('tb_logged_out');
            window.location.reload();
        }
    } catch (e) {}
});

// Register Service Worker for offline & Laragon down handling
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js').catch(() => {});
    });
}
