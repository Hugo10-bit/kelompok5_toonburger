let activeMessageId = null;
let activeStatusUrl = '';
let activeDeleteUrl = '';
let activeSenderName = '';
let activeIsRead = false;
let lastOpenedMessageEl = null;

const isEn = () => (window._tbLang === 'US' || window._tbLang === 'EN' || localStorage.getItem('tb_admin_lang') === 'US');

function getStatusText(isRead) {
    if (isEn()) {
        return isRead ? 'Read' : 'Unread';
    }
    return isRead ? 'Dibaca' : 'Belum Dibaca';
}

function updateMessageUiState(id, isRead, counts) {
    const statusBtns = document.querySelectorAll(`[data-msg-status-btn="${id}"]`);
    statusBtns.forEach((btn) => {
        btn.dataset.isRead = isRead ? '1' : '0';
        const dot = btn.querySelector('[data-msg-dot]');
        const label = btn.querySelector('[data-msg-label]');
        if (dot) {
            dot.classList.remove('bg-[#4ADE80]', 'bg-[#EF4444]');
            dot.classList.add(isRead ? 'bg-[#4ADE80]' : 'bg-[#EF4444]');
        }
        if (label) {
            label.setAttribute('data-i18n', isRead ? 'msg_status_read' : 'msg_status_unread');
            label.textContent = getStatusText(isRead);
        }
    });

    // Keep row dataset in sync
    const triggers = document.querySelectorAll(`[data-msg-id="${id}"]`);
    triggers.forEach((el) => {
        try {
            const payload = JSON.parse(el.dataset.message || '{}');
            payload.is_read = isRead;
            el.dataset.message = JSON.stringify(payload);
        } catch (e) {}
    });

    if (counts) {
        const unreadEl = document.getElementById('msg-filter-unread-count');
        const readEl = document.getElementById('msg-filter-read-count');
        const totalEl = document.getElementById('msg-filter-total-count');
        if (unreadEl && counts.unread_count !== undefined) unreadEl.textContent = `(${counts.unread_count})`;
        if (readEl && counts.read_count !== undefined) readEl.textContent = `(${counts.read_count})`;
        if (totalEl && counts.total_count !== undefined) totalEl.textContent = `(${counts.total_count})`;
    }

    if (String(activeMessageId) === String(id)) {
        activeIsRead = isRead;
        renderModalStatus(isRead);
    }
}

function renderModalStatus(isRead) {
    const modalDot = document.getElementById('msg-modal-status-dot');
    const modalLabel = document.getElementById('msg-modal-status-label');
    const toggleBtn = document.getElementById('msg-modal-toggle-btn');

    if (modalDot) {
        modalDot.classList.remove('bg-[#4ADE80]', 'bg-[#EF4444]');
        modalDot.classList.add(isRead ? 'bg-[#4ADE80]' : 'bg-[#EF4444]');
    }
    if (modalLabel) {
        modalLabel.setAttribute('data-i18n', isRead ? 'msg_status_read' : 'msg_status_unread');
        modalLabel.textContent = getStatusText(isRead);
    }
    if (toggleBtn) {
        toggleBtn.textContent = isRead
            ? (isEn() ? 'Mark as Unread' : 'Tandai Belum Dibaca')
            : (isEn() ? 'Mark as Read' : 'Tandai Dibaca');
    }
}

async function patchMessageStatus(id, url, nextIsRead) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    try {
        const res = await fetch(url, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({ is_read: nextIsRead }),
        });
        if (!res.ok) return null;
        const data = await res.json();
        if (data && data.success) {
            updateMessageUiState(id, Boolean(data.is_read), data);
        }
        return data;
    } catch (err) {
        console.error('Failed to update message status:', err);
        return null;
    }
}

window.toggleMsgFilterMenu = function toggleMsgFilterMenu(event) {
    if (event) event.stopPropagation();
    const filterMenu = document.getElementById('msg-filter-menu');
    const sortMenu = document.getElementById('msg-sort-menu');
    if (sortMenu) sortMenu.classList.add('hidden');
    if (filterMenu) filterMenu.classList.toggle('hidden');
};

window.toggleMsgSortMenu = function toggleMsgSortMenu(event) {
    if (event) event.stopPropagation();
    const filterMenu = document.getElementById('msg-filter-menu');
    const sortMenu = document.getElementById('msg-sort-menu');
    if (filterMenu) filterMenu.classList.add('hidden');
    if (sortMenu) sortMenu.classList.toggle('hidden');
};

window.toggleMessageStatus = async function toggleMessageStatus(id, btn) {
    if (!btn) return;
    const url = btn.dataset.statusUrl;
    const currentlyRead = btn.dataset.isRead === '1';
    btn.disabled = true;
    await patchMessageStatus(id, url, !currentlyRead);
    btn.disabled = false;
};

function ensureMessageModalInBody() {
    const modals = document.querySelectorAll('#messageDetailModal');
    if (modals.length > 1) {
        // Remove stale portaled copies before moving the fresh one to body
        modals.forEach((m) => {
            if (m.parentElement === document.body) {
                m.remove();
            }
        });
    }
    const modal = document.getElementById('messageDetailModal');
    if (modal && modal.parentElement !== document.body) {
        document.body.appendChild(modal);
    }
    return modal;
}

function bindMessageModalSwipe() {
    const card = document.getElementById('messageDetailModalCard');
    if (!card || card.dataset.swipeBound) return;
    card.dataset.swipeBound = '1';

    let startX = 0;
    let startY = 0;
    let lastDy = 0;
    let tracking = false;

    card.addEventListener('touchstart', (e) => {
        if (window.innerWidth >= 1024 || e.touches.length !== 1) return;
        if (card.scrollTop > 4) return;
        startX = e.touches[0].clientX;
        startY = e.touches[0].clientY;
        lastDy = 0;
        tracking = true;
    }, { passive: true });

    card.addEventListener('touchmove', (e) => {
        if (!tracking || e.touches.length !== 1) return;
        const dx = e.touches[0].clientX - startX;
        const dy = e.touches[0].clientY - startY;
        if (Math.abs(dx) > Math.abs(dy) && Math.abs(dx) > 12) {
            tracking = false;
            card.style.transform = '';
            return;
        }
        if (dy > 0) {
            lastDy = dy;
            card.style.transition = 'none';
            card.style.transform = `translateY(${Math.min(140, dy * 0.65)}px)`;
        }
    }, { passive: true });

    const finish = () => {
        if (!tracking) return;
        tracking = false;
        card.style.transition = '';
        card.style.transform = '';
        if (lastDy >= 65) {
            window.closeMessageDetailModal(false);
        }
        lastDy = 0;
    };

    card.addEventListener('touchend', finish, { passive: true });
    card.addEventListener('touchcancel', finish, { passive: true });
}

window.openMessageDetailModal = async function openMessageDetailModal(el) {
    const modal = ensureMessageModalInBody();
    if (!modal) return;
    bindMessageModalSwipe();
    const target = el ? (el.dataset?.message ? el : el.closest('[data-message]')) : null;
    if (!target || !target.dataset.message) return;
    let data;
    try {
        data = JSON.parse(target.dataset.message);
    } catch (e) {
        return;
    }

    activeMessageId = data.id;
    activeStatusUrl = data.status_url || '';
    activeDeleteUrl = data.delete_url || '';
    activeSenderName = data.name || '';
    activeIsRead = Boolean(data.is_read);
    lastOpenedMessageEl = target;

    const avatarWrap = document.getElementById('msg-modal-avatar');
    const nameEl = document.getElementById('msg-modal-name');
    const timeEl = document.getElementById('msg-modal-time');
    const phoneEl = document.getElementById('msg-modal-phone');
    const emailEl = document.getElementById('msg-modal-email');
    const bodyEl = document.getElementById('msg-modal-body');

    if (avatarWrap) {
        if (data.avatar_url) {
            avatarWrap.innerHTML = `<img src="${data.avatar_url}" alt="" class="w-full h-full object-cover">`;
            avatarWrap.className = 'w-11 h-11 rounded-full overflow-hidden shrink-0 border border-gray-200 dark:border-[#555555]';
        } else {
            avatarWrap.textContent = data.initials || 'TB';
            avatarWrap.className = `w-11 h-11 rounded-full ${data.avatar_bg || 'bg-[#40605D]'} text-white font-bold text-sm flex items-center justify-center shrink-0`;
        }
    }
    if (nameEl) nameEl.textContent = data.name || '-';
    if (timeEl) timeEl.textContent = data.created_at || '-';
    if (phoneEl) phoneEl.textContent = data.phone || '-';
    if (emailEl) emailEl.textContent = data.email || '-';
    if (bodyEl) bodyEl.textContent = data.message || '-';

    renderModalStatus(activeIsRead);
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
    if (typeof window.pushAdminOverlayHistory === 'function') {
        window.pushAdminOverlayHistory('msg-detail-modal', window.closeMessageDetailModal);
    }

    // Auto-mark as read when opened if currently unread
    if (!activeIsRead && activeStatusUrl) {
        await patchMessageStatus(activeMessageId, activeStatusUrl, true);
    }
};

window.closeMessageDetailModal = function closeMessageDetailModal(fromPopstate = false) {
    const modal = document.getElementById('messageDetailModal');
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
    document.body.style.overflow = '';
    if (typeof window.releaseAdminOverlayHistory === 'function') {
        window.releaseAdminOverlayHistory('msg-detail-modal', fromPopstate);
    }
};

window.toggleActiveMessageStatus = async function toggleActiveMessageStatus() {
    if (!activeMessageId || !activeStatusUrl) return;
    const toggleBtn = document.getElementById('msg-modal-toggle-btn');
    if (toggleBtn) toggleBtn.disabled = true;
    await patchMessageStatus(activeMessageId, activeStatusUrl, !activeIsRead);
    if (toggleBtn) toggleBtn.disabled = false;
};

window.deleteActiveMessage = function deleteActiveMessage() {
    if (!activeDeleteUrl) return;

    const deleteUrl = activeDeleteUrl;
    const sender = activeSenderName
        ? (isEn() ? `message from ${activeSenderName}` : `pesan dari ${activeSenderName}`)
        : (isEn() ? 'this message' : 'pesan ini');

    // Close detail modal immediately so it does not overlap / ketimpa with confirmation modal
    window.closeMessageDetailModal(false);

    if (typeof window.openDeleteModal === 'function') {
        window._onDeleteModalCancelled = () => {
            if (lastOpenedMessageEl) {
                window.openMessageDetailModal(lastOpenedMessageEl);
            }
        };
        window.openDeleteModal(deleteUrl, sender);
        return;
    }

    const form = document.getElementById('msg-delete-form') || document.getElementById('global-delete-form');
    if (!form) return;

    const submitDelete = () => {
        form.setAttribute('action', deleteUrl);
        form.submit();
    };

    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: 'warning',
            title: isEn() ? 'Delete this message?' : 'Hapus pesan ini?',
            text: isEn() ? 'Deleted messages cannot be recovered.' : 'Pesan yang sudah dihapus tidak dapat dikembalikan.',
            showCancelButton: true,
            confirmButtonColor: '#B73535',
            cancelButtonColor: '#6B7280',
            confirmButtonText: isEn() ? 'Yes, Delete' : 'Ya, Hapus',
            cancelButtonText: isEn() ? 'Cancel' : 'Batal',
            customClass: { popup: 'rounded-3xl' },
        }).then((result) => {
            if (result.isConfirmed) {
                submitDelete();
            } else if (lastOpenedMessageEl) {
                window.openMessageDetailModal(lastOpenedMessageEl);
            }
        });
    } else if (confirm(isEn() ? `Delete ${sender}?` : `Hapus ${sender}?`)) {
        submitDelete();
    } else if (lastOpenedMessageEl) {
        window.openMessageDetailModal(lastOpenedMessageEl);
    }
};

export function initAdminMessages() {
    // Clean up any stale portaled modal if we navigated away from messages page
    if (!document.getElementById('msg-filter-wrap')) {
        const stale = document.querySelector('body > #messageDetailModal');
        if (stale) stale.remove();
    } else {
        ensureMessageModalInBody();
        bindMessageModalSwipe();
    }

    if (!window._tbAdminMessagesGlobalBound) {
        window._tbAdminMessagesGlobalBound = true;

        document.addEventListener('click', (e) => {
            const filterWrap = document.getElementById('msg-filter-wrap');
            const filterMenu = document.getElementById('msg-filter-menu');
            if (filterMenu && filterWrap && !filterWrap.contains(e.target)) {
                filterMenu.classList.add('hidden');
            }

            const sortWrap = document.getElementById('msg-sort-wrap');
            const sortMenu = document.getElementById('msg-sort-menu');
            if (sortMenu && sortWrap && !sortWrap.contains(e.target)) {
                sortMenu.classList.add('hidden');
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                const m = document.getElementById('messageDetailModal');
                if (m && !m.classList.contains('hidden')) {
                    window.closeMessageDetailModal(false);
                }
            }
        });
    }
}

// Auto-initialize immediately and on PJAX events
initAdminMessages();
document.addEventListener('DOMContentLoaded', initAdminMessages);
window.addEventListener('tb:admin:pjax:loaded', initAdminMessages);
window.addEventListener('tb:admin-pjax:loaded', initAdminMessages);
window.addEventListener('tb:admin-navigated', initAdminMessages);
