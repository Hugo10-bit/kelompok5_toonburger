const ADMIN_CONFIG = document.body.dataset;

function toggleAdminSidebar() {
    const sidebar = document.getElementById('admin-sidebar');
    const backdrop = document.getElementById('admin-sidebar-backdrop');
    const bottomNav = document.getElementById('admin-bottom-nav');
    if (!sidebar || !backdrop) return;

    const isClosed = sidebar.classList.contains('-translate-x-full');
    if (isClosed) {
        sidebar.classList.remove('-translate-x-full');
        backdrop.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        if (bottomNav) bottomNav.classList.add('translate-y-full');
    } else {
        sidebar.classList.add('-translate-x-full');
        backdrop.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        if (bottomNav) bottomNav.classList.remove('translate-y-full');
    }
}

function confirmLogout(event) {
    if (event) {
        event.preventDefault();
        event.stopPropagation();
    }
    closeAllHeaderDropdowns();
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

    const form = document.getElementById('global-logout-form');
    const logoutUrl = ADMIN_CONFIG.logoutUrl || '/logout';
    const isEn = (window._tbLang === 'US' || window._tbLang === 'EN' || localStorage.getItem('tb_admin_lang') === 'US');

    if (typeof Swal !== 'undefined') {
        let timerInterval;
        Swal.fire({
            title: isEn ? 'Logout Successful' : 'Logout Berhasil',
            html: isEn
                ? 'Closing admin session in <b></b> seconds... See you soon!'
                : 'Sedang keluar dari akun dalam <b></b> detik... Sampai jumpa kembali!',
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

function handleGlobalDeleteSubmit(e, form) {
    if (e) e.preventDefault();
    closeDeleteModal();
    const isEn = (window._tbLang === 'US' || window._tbLang === 'EN' || localStorage.getItem('tb_admin_lang') === 'US');

    if (typeof Swal !== 'undefined') {
        let timerInterval;
        Swal.fire({
            title: isEn ? 'Deleting Data...' : 'Menghapus Data...',
            html: isEn
                ? 'Deleting selected data in <b></b> seconds...'
                : 'Sedang memproses penghapusan data dalam <b></b> detik...',
            timer: 1500,
            timerProgressBar: true,
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
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
            form.submit();
        });
    } else {
        form.submit();
    }
    return false;
}

// Global Delete Modal Handler
function openDeleteModal(actionUrl, itemName = 'data ini') {
    const modal = document.getElementById('delete-confirm-modal');
    const form = document.getElementById('global-delete-form');
    const message = document.getElementById('delete-modal-message');
    if (modal && form) {
        form.action = actionUrl;
        if (message) {
            const lang = window._tbLang || 'ID';
            if (lang === 'ID') {
                message.textContent = `Apakah Anda yakin ingin menghapus ${itemName}? Tindakan ini tidak dapat dibatalkan.`;
            } else {
                message.textContent = `Are you sure you want to delete ${itemName}? This action cannot be undone.`;
            }
        }
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
}

function closeDeleteModal() {
    const modal = document.getElementById('delete-confirm-modal');
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }
}

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeLogoutModal();
        closeDeleteModal();
        closeAllHeaderDropdowns();
    }
});

// Header dropdowns and live search handler

function closeAllHeaderDropdowns() {
    const langDropdown = document.getElementById('header-lang-dropdown');
    const langChevron = document.getElementById('header-lang-chevron');
    if (langDropdown) langDropdown.classList.add('hidden');
    if (langChevron) langChevron.style.transform = 'rotate(0deg)';

    const profileDropdown = document.getElementById('header-profile-dropdown');
    const profileChevron = document.getElementById('header-profile-chevron');
    if (profileDropdown) profileDropdown.classList.add('hidden');
    if (profileChevron) profileChevron.style.transform = 'rotate(0deg)';

    const searchResults = document.getElementById('header-search-results');
    if (searchResults) searchResults.classList.add('hidden');
}

function toggleLanguageDropdown(e) {
    if (e) e.stopPropagation();
    const dropdown = document.getElementById('header-lang-dropdown');
    const chevron = document.getElementById('header-lang-chevron');
    const profileDropdown = document.getElementById('header-profile-dropdown');
    const profileChevron = document.getElementById('header-profile-chevron');
    const searchResults = document.getElementById('header-search-results');

    if (profileDropdown) profileDropdown.classList.add('hidden');
    if (profileChevron) profileChevron.style.transform = 'rotate(0deg)';
    if (searchResults) searchResults.classList.add('hidden');

    if (dropdown) {
        const isHidden = dropdown.classList.toggle('hidden');
        if (chevron) {
            chevron.style.transform = isHidden ? 'rotate(0deg)' : 'rotate(180deg)';
        }
    }
}

const _tbTranslations = {
    ID: {
        // Layout: Nav
        nav_dashboard: 'Dashboard',
        nav_profile: 'Profil Admin',
        nav_orders: 'Proses Pesanan',
        nav_orders_short: 'Pesanan',
        nav_products: 'Data Produk',
        nav_products_short: 'Produk',
        nav_categories: 'Data Kategori',
        nav_categories_short: 'Kategori',
        nav_messages: 'Pesan Terbaru',
        nav_homepage: 'Halaman Utama',
        nav_logout: 'Keluar',
        nav_logout_short: 'Keluar',
        // Layout: Modals
        logout_title: 'Konfirmasi Logout',
        logout_desc: 'Apakah Anda yakin ingin keluar dari akun? Anda perlu login kembali untuk mengakses halaman admin.',
        logout_confirm_btn: 'Ya, Logout',
        delete_title: 'Konfirmasi Hapus',
        delete_desc: 'Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.',
        delete_confirm_btn: 'Ya, Hapus',
        cancel: 'Batalkan',
        // Header
        search_placeholder: 'Cari Sesuatu...',
        searching: 'Mencari data...',
        role_admin: 'Administrator',
        // Dashboard
        dash_greeting: 'Halo, Admin Toon Burger',
        dash_subtitle: 'Pantau performa penjualan, dan pesanan aktif Toon Burger hari ini.',
        dash_metric_profit: 'Pendapatan Hari Ini',
        dash_sub_profit: 'Lorem ipsum dolor',
        dash_metric_orders: 'Pesanan Hari Ini',
        dash_sub_orders: 'Lorem ipsum dolor',
        dash_metric_progress: 'Pesanan Dalam Proses',
        dash_sub_progress: 'Lorem ipsum dolor',
        dash_metric_products: 'Total Produk',
        dash_sub_products: 'Lorem ipsum dolor',
        dash_up5: 'Naik 5% dari kemarin',
        dash_up2: 'Naik 2% dari kemarin',
        dash_needs_processing: 'Perlu segera diproses',
        dash_active: 'Aktif',
        dash_out_of_stock: 'Habis',
        dash_view_detail: 'Lihat Detail',
        dash_rev_12m: 'Pendapatan 12 Bulan Terakhir',
        dash_period_h1: 'Jan - Jun',
        dash_period_h2: 'Jul - Des',
        dash_latest_order: 'Pesanan Terbaru',
        dash_see_all: 'Lihat semua',
        dash_col_order_num: 'No. Pesanan',
        dash_col_customer: 'Nama Pelanggan',
        dash_col_total: 'Total',
        dash_col_status: 'Status',
        dash_col_action: 'Aksi',
        dash_detail: 'Detail',
        dash_best_selling: 'Produk Terlaris',
        dash_products_sold: 'Produk Terjual',
        dash_see_all_products: 'Lihat Semua Produk',
        currency_dot: 'Rp.',
        // Messages
        messages_title: 'Pesan Terbaru',
        messages_subtitle: 'Ulasan dan catatan masukan pelanggan dari pesanan yang telah selesai.',
        messages_filter_all: 'Semua Rating',
        messages_reset_filter: 'Reset Filter',
        messages_empty_filtered_title: 'Tidak ada pesan yang sesuai dengan filter',
        messages_empty_filtered_desc: 'Ubah pilihan rating atau hapus kata kunci pencarian untuk melihat seluruh pesan pelanggan.',
        messages_show_all: 'Tampilkan Semua Pesan',
        messages_empty_title: 'Belum ada pesan pelanggan yang masuk',
        messages_empty_desc: 'Pesan dan ulasan akan otomatis muncul di halaman ini setelah pelanggan menyelesaikan pesanan dan mengirim ulasan.',
        messages_go_orders: 'Periksa Proses Pesanan',
        // Orders
        orders_title: 'Proses Pesanan',
        orders_subtitle: 'Kelola alur dan status pesanan pelanggan secara realtime.',
        order_detail_title: 'Detail Pesanan',
        order_detail_subtitle: 'Konfirmasi dan kelola status pesanan ini.',
        orders_refresh: 'Segarkan',
        orders_tab_all: 'Semua',
        orders_tab_pending: 'Menunggu',
        orders_tab_processing: 'Diproses',
        orders_tab_ready: 'Siap Diambil',
        orders_tab_completed: 'Selesai',
        orders_tab_cancelled: 'Dibatalkan',
        orders_empty_title: 'Tidak ada pesanan dalam status ini',
        orders_empty_desc: 'Saat ada pesanan baru masuk, pesanan akan segera tampil di sini.',
        orders_status_completed: 'Selesai',
        orders_status_ready: 'Siap Diambil',
        orders_status_processing: 'Diproses',
        orders_status_cancelled: 'Dibatalkan',
        orders_status_pending: 'Menunggu',
        orders_total: 'Total',
        orders_accept: 'Terima Pesanan',
        orders_mark_ready: 'Pesanan Siap',
        orders_complete: 'Selesaikan Pesanan',
        orders_done_badge: 'Pesanan Selesai',
        orders_cancelled_badge: 'Pesanan Dibatalkan',
        orders_view_detail: 'Lihat Detail',
        orders_reject: 'Tolak Pesanan',
        // Order Detail
        order_detail_back: 'Kembali ke Proses Pesanan',
        order_detail_kitchen_status: 'Status Dapur',
        order_status_kitchen_pending: '• Menunggu Konfirmasi',
        order_status_kitchen_confirmed: '• Pesanan Dikonfirmasi',
        order_status_kitchen_preparing: '• Pesanan Sedang Dimasak',
        order_status_kitchen_ready: '• Pesanan Siap Saji',
        order_status_kitchen_completed: '• Pesanan Selesai',
        order_status_kitchen_cancelled: '• Pesanan Dibatalkan',
        order_detail_payment_status: 'Status Pembayaran',
        order_detail_paid: 'Lunas',
        order_detail_unpaid: 'Belum Lunas',
        order_detail_refunded: 'Refund',
        stepper_pending: 'Menunggu',
        stepper_cooking: 'Dimasak',
        stepper_ready: 'Siap Saji',
        stepper_completed: 'Selesai',
        order_detail_order_type: 'Tipe Pesanan',
        order_detail_table: 'Meja',
        order_detail_customer_name: 'Nama Pemesan',
        order_detail_customer_phone: 'No. Telepon',
        order_detail_payment_method: 'Metode Pembayaran',
        order_detail_notes: 'Catatan Pesanan',
        order_detail_no_notes: 'Tanpa catatan',
        order_detail_items_title: 'Rincian Pesanan',
        order_detail_item_note: 'Catatan:',
        order_detail_subtotal: 'Subtotal',
        order_detail_discount: 'Diskon',
        order_detail_tax: 'Pajak',
        order_detail_total: 'Total',
        order_detail_print_receipt: 'Cetak Struk',
        order_detail_accept_cook: 'Terima & Masak Pesanan',
        order_detail_mark_ready: 'Tandai Siap Saji',
        order_detail_complete: 'Selesaikan Pesanan',
        order_detail_cancel: 'Batalkan Pesanan',
        // Products
        products_title: 'Kelola Data Produk',
        products_subtitle: 'Kelola daftar menu dan produk Toon Burger',
        products_search: 'Cari nama menu...',
        products_add_btn: 'Tambah Produk',
        products_col_no: 'No',
        products_col_menu: 'Menu / Produk',
        products_col_category: 'Kategori',
        products_col_price: 'Harga',
        products_col_stock: 'Stok',
        products_col_status: 'Status',
        products_col_action: 'Aksi',
        products_available: 'Tersedia',
        products_out: 'Habis',
        products_empty_title: 'Belum Ada Menu',
        products_empty_desc: 'Klik tombol + Tambah Produk untuk memasukkan menu baru.',
        // Add Product Modal
        products_add_modal_title: 'Tambah Produk Baru',
        products_add_modal_desc: 'Lengkapi informasi menu Toon Burger yang akan ditambahkan.',
        products_label_name: 'Nama Produk',
        products_label_category: 'Kategori',
        products_label_price: 'Harga (Rp)',
        products_label_stock: 'Stok (Porsi)',
        products_label_photo: 'Upload Foto',
        products_label_desc: 'Deskripsi',
        products_add_submit: 'Tambah Produk',
        // Edit Product Modal
        products_edit_modal_title: 'Edit Menu',
        products_edit_modal_desc: 'Perbarui rincian, harga, atau foto menu Toon Burger.',
        products_edit_photo: 'Ganti Foto Menu',
        products_save_changes: 'Simpan Perubahan',
        products_all_categories: 'Semua Kategori',
        products_unit_portion: 'Porsi',
        products_placeholder_name: 'Nama Produk Baru',
        products_placeholder_desc: 'Deskripsi menu Toon Burger...',
        products_toggle_status_title: 'Klik untuk ubah ketersediaan',
        products_edit_btn_title: 'Edit Produk',
        products_delete_btn_title: 'Hapus Produk',
        // Categories
        categories_title: 'Kelola Kategori Produk',
        categories_subtitle: 'Kelola kategori untuk pengelompokan menu Toon Burger',
        categories_search: 'Cari kategori...',
        categories_add_btn: 'Tambah Kategori',
        categories_col_no: 'No',
        categories_col_name: 'Nama Kategori',
        categories_col_action: 'Aksi',
        categories_empty_title: 'Belum Ada Kategori',
        categories_empty_desc: 'Klik tombol + Tambah Kategori untuk membuat kategori menu baru.',
        categories_add_modal_title: 'Tambah Kategori',
        categories_label_name: 'Nama Kategori',
        categories_save: 'Simpan',
        categories_edit_modal_title: 'Edit Kategori',
        categories_save_changes: 'Simpan Perubahan',
        tables_tab: 'Meja Restoran',
        pos_tab: 'Buka Kasir / POS',
        // Tables
        tables_title: 'Manajemen Meja Restoran',
        tables_subtitle: 'Pantau ketersediaan meja, status terisi, dan tautan QR pemesanan pelanggan Toon Burger.',
        tables_open_menu: 'Buka Menu Meja Ini',
        tables_change: 'Ubah',
        // General
        btn_cancel: 'Batal',
        transaction: 'Transaksi',
        queue: 'Antrean',
        currency: 'Rp',
        // Header Dropdown (Top Right)
        dropdown_profile: 'Profile',
        dropdown_theme: 'Mode Gelap',
        dropdown_home: 'Beranda',
        dropdown_logout: 'Logout',
        // Subview keys (Profile, Orders, Products, Categories)
        prof_title: 'Profil Admin',
        prof_sub: 'Kelola informasi akun dan profil admin',
        prof_username: 'Username',
        prof_email: 'Email',
        prof_phone: 'Nomor telfon',
        prof_address: 'Alamat',
        prof_save: 'Simpan',
        prof_new_pass: 'Password baru',
        prof_conf_pass: 'Konfirmasi Password',
        prof_new_pass_ph: 'Masukkan Password',
        prof_conf_pass_ph: 'Konfirmasi Password',
        ord_title: 'Proses pesanan',
        ord_sub: 'Kelola dan konfirmasi pesanan yang masuk hari ini.',
        tab_all: 'Semua',
        tab_pending: 'Menunggu',
        tab_cooking: 'Dimasak',
        tab_ready: 'Siap Saji',
        tab_completed: 'Selesai',
        st_pending: 'Menunggu',
        st_cooking: 'Dimasak',
        st_ready: 'Siap Saji',
        st_completed: 'Selesai',
        st_cancelled: 'Batal',
        ord_col_prod: 'Produk',
        ord_col_qty: 'total',
        ord_col_price: 'Harga',
        ord_total_label: 'Total',
        btn_confirm_order: 'konfirmasi pesanan',
        ord_done_badge: 'Pesanan Selesai',
        ord_cancel_badge: 'Pesanan Dibatalkan',
        btn_detail: 'Lihat Detail Pesanan',
        ord_empty: 'Belum ada pesanan pada kategori status ini.',
        prod_title: 'Halaman Data Produk',
        prod_sub: 'Tambah menu baru, edit rincian/harga, dan pantau ketersediaan stok',
        btn_filter: 'Filter',
        filter_all_cat: 'Semua Kategori',
        btn_sort: 'Sortir',
        btn_add_prod: 'Tambahkan',
        col_prod_name: 'Menu',
        col_category: 'Kategori',
        col_price: 'Harga',
        col_status: 'Status',
        col_action: 'Aksi',
        st_avail: 'Tersedia',
        st_empty: 'Habis',
        prod_empty: 'Belum ada produk.',
        mod_prod_add: 'Tambah Produk Baru',
        lbl_prod_name: 'Nama Produk',
        lbl_prod_price: 'Harga (Rp)',
        lbl_prod_img: 'Gambar Produk',
        lbl_prod_desc: 'Deskripsi',
        lbl_prod_avail: 'Tersedia (Stok Ada)',
        lbl_prod_pop: 'Menu Terpopuler',
        btn_save_prod: 'Simpan Produk',
        cat_title: 'Halaman Kategori Produk',
        cat_sub: 'Tambah menu baru, edit rincian/harga, dan pantau ketersediaan stok',
        btn_add_cat: 'Tambahkan',
        col_no: 'No.',
        cat_empty: 'Belum ada kategori.',
        mod_cat_add: 'Tambah Kategori',
        lbl_cat_name: 'Nama Kategori',
        btn_save: 'Simpan',
    },
    EN: {
        // Layout: Nav
        nav_dashboard: 'Dashboard',
        nav_profile: 'Admin Profile',
        nav_orders: 'Order Processing',
        nav_orders_short: 'Orders',
        nav_products: 'Product Data',
        nav_products_short: 'Products',
        nav_categories: 'Product Categories',
        nav_categories_short: 'Categories',
        nav_messages: 'Latest Messages',
        nav_homepage: 'Home page',
        nav_logout: 'Logout',
        nav_logout_short: 'Logout',
        // Layout: Modals
        logout_title: 'Confirm Logout',
        logout_desc: 'Are you sure you want to log out? You will need to log in again to access the admin panel.',
        logout_confirm_btn: 'Yes, Logout',
        delete_title: 'Confirm Delete',
        delete_desc: 'Are you sure you want to delete this item? This action cannot be undone.',
        delete_confirm_btn: 'Yes, Delete',
        cancel: 'Cancel',
        // Header
        search_placeholder: 'Search for something...',
        searching: 'Searching...',
        role_admin: 'Administrator',
        // Dashboard
        dash_greeting: 'Hello, Toon Burger Admin',
        dash_subtitle: "Monitor Toon Burger's sales performance and active orders for today.",
        dash_metric_profit: "Today's Revenue",
        dash_sub_profit: 'Lorem ipsum dolor',
        dash_metric_orders: "Today's Orders",
        dash_sub_orders: 'Lorem ipsum dolor',
        dash_metric_progress: 'Orders in Progress',
        dash_sub_progress: 'Lorem ipsum dolor',
        dash_metric_products: 'Total Products',
        dash_sub_products: 'Lorem ipsum dolor',
        dash_up5: 'Up 5% from yesterday.',
        dash_up2: 'Up 2% from yesterday.',
        dash_needs_processing: 'Process immediately',
        dash_active: 'Active',
        dash_out_of_stock: 'Out',
        dash_view_detail: 'View Detail',
        dash_rev_12m: 'Last 12 Months Revenue',
        dash_period_h1: 'Jan - Jun',
        dash_period_h2: 'Jul - Dec',
        dash_latest_order: 'Latest Order',
        dash_see_all: 'See all',
        dash_col_order_num: 'Order Number',
        dash_col_customer: 'Customer Name',
        dash_col_total: 'Total',
        dash_col_status: 'Status',
        dash_col_action: 'Action',
        dash_detail: 'Detail',
        dash_best_selling: 'Best Selling Products',
        dash_products_sold: 'Products Sold',
        dash_see_all_products: 'See All Products',
        currency_dot: 'IDR',
        // Messages
        messages_title: 'Latest Messages',
        messages_subtitle: 'Customer reviews and feedback notes from completed orders.',
        messages_filter_all: 'All Ratings',
        messages_reset_filter: 'Reset Filter',
        messages_empty_filtered_title: 'No messages match the selected filter',
        messages_empty_filtered_desc: 'Change the rating filter or clear the search query to view all customer messages.',
        messages_show_all: 'Show All Messages',
        messages_empty_title: 'No customer messages yet',
        messages_empty_desc: 'Messages and reviews appear here automatically once customers complete orders and leave feedback.',
        messages_go_orders: 'Check Order Processing',
        // Orders
        orders_title: 'Order Processing',
        orders_subtitle: 'Manage order flow and customer order status in real time.',
        order_detail_title: 'Order Details',
        order_detail_subtitle: 'Confirm and manage the status of this order.',
        orders_refresh: 'Refresh',
        orders_tab_all: 'All',
        orders_tab_pending: 'Pending',
        orders_tab_processing: 'Processing',
        orders_tab_ready: 'Ready to Serve',
        orders_tab_completed: 'Completed',
        orders_tab_cancelled: 'Cancelled',
        orders_empty_title: 'No orders with this status',
        orders_empty_desc: 'New orders will appear here when they come in.',
        orders_status_completed: 'Completed',
        orders_status_ready: 'Ready to Serve',
        orders_status_processing: 'Processing',
        orders_status_cancelled: 'Cancelled',
        orders_status_pending: 'Pending',
        orders_total: 'Total',
        orders_accept: 'Accept Order',
        orders_mark_ready: 'Order Ready',
        orders_complete: 'Complete Order',
        orders_done_badge: 'Order Completed',
        orders_cancelled_badge: 'Order Cancelled',
        orders_view_detail: 'View Detail',
        orders_reject: 'Reject Order',
        // Order Detail
        order_detail_back: 'Back to Order Processing',
        order_detail_kitchen_status: 'Kitchen Status',
        order_status_kitchen_pending: '• Awaiting Confirmation',
        order_status_kitchen_confirmed: '• Order Confirmed',
        order_status_kitchen_preparing: '• Order Cooking',
        order_status_kitchen_ready: '• Order Ready to Serve',
        order_status_kitchen_completed: '• Order Completed',
        order_status_kitchen_cancelled: '• Order Cancelled',
        order_detail_payment_status: 'Payment Status',
        order_detail_paid: 'Paid',
        order_detail_unpaid: 'Unpaid',
        order_detail_refunded: 'Refunded',
        stepper_pending: 'Pending',
        stepper_cooking: 'Cooking',
        stepper_ready: 'Ready to Serve',
        stepper_completed: 'Completed',
        order_detail_order_type: 'Order Type',
        order_detail_table: 'Table',
        order_detail_customer_name: 'Customer Name',
        order_detail_customer_phone: 'Phone Number',
        order_detail_payment_method: 'Payment Method',
        order_detail_notes: 'Order Notes',
        order_detail_no_notes: 'No notes',
        order_detail_items_title: 'Order Items',
        order_detail_item_note: 'Note:',
        order_detail_subtotal: 'Subtotal',
        order_detail_discount: 'Discount',
        order_detail_tax: 'Tax',
        order_detail_total: 'Total',
        order_detail_print_receipt: 'Print Receipt',
        order_detail_accept_cook: 'Accept & Cook Order',
        order_detail_mark_ready: 'Mark Ready to Serve',
        order_detail_complete: 'Complete Order',
        order_detail_cancel: 'Cancel Order',
        // Products
        products_title: 'Manage Product Data',
        products_subtitle: 'Manage the menu and product list of Toon Burger',
        products_search: 'Search menu name...',
        products_add_btn: 'Add Product',
        products_col_no: 'No',
        products_col_menu: 'Menu / Product',
        products_col_category: 'Category',
        products_col_price: 'Price',
        products_col_stock: 'Stock',
        products_col_status: 'Status',
        products_col_action: 'Action',
        products_available: 'Available',
        products_out: 'Out of Stock',
        products_empty_title: 'No menu items yet',
        products_empty_desc: 'Click + Add Product to add a new menu item.',
        // Add Product Modal
        products_add_modal_title: 'Add New Product',
        products_add_modal_desc: 'Fill in the details for the new Toon Burger menu item.',
        products_label_name: 'Product Name',
        products_label_category: 'Category',
        products_label_price: 'Price (IDR)',
        products_label_stock: 'Stock (Portions)',
        products_label_photo: 'Upload Photo',
        products_label_desc: 'Description',
        products_add_submit: 'Add Product',
        // Edit Product Modal
        products_edit_modal_title: 'Edit Menu',
        products_edit_modal_desc: 'Update the details, price, or photo of this menu item.',
        products_edit_photo: 'Replace Menu Photo',
        products_save_changes: 'Save Changes',
        products_all_categories: 'All Categories',
        products_unit_portion: 'Portions',
        products_placeholder_name: 'New Product Name',
        products_placeholder_desc: 'Toon Burger menu description...',
        products_toggle_status_title: 'Click to change availability',
        products_edit_btn_title: 'Edit Product',
        products_delete_btn_title: 'Delete Product',
        // Categories
        categories_title: 'Manage Product Categories',
        categories_subtitle: 'Manage categories for Toon Burger menu grouping',
        categories_search: 'Search category...',
        categories_add_btn: 'Add Category',
        categories_col_no: 'No',
        categories_col_name: 'Category Name',
        categories_col_action: 'Action',
        categories_empty_title: 'No Categories Yet',
        categories_empty_desc: 'Click + Add Category to create a new menu category.',
        categories_add_modal_title: 'Add Category',
        categories_label_name: 'Category Name',
        categories_save: 'Save',
        categories_edit_modal_title: 'Edit Category',
        categories_save_changes: 'Save Changes',
        tables_tab: 'Restaurant Tables',
        pos_tab: 'Open Cashier / POS',
        // Tables
        tables_title: 'Restaurant Table Management',
        tables_subtitle: 'Monitor table availability, occupied status, and QR order links for Toon Burger customers.',
        tables_open_menu: 'Open Table Menu',
        tables_change: 'Update',
        // General
        btn_cancel: 'Cancel',
        transaction: 'Transaction',
        queue: 'Queue',
        currency: 'IDR',
        // Header Dropdown (Top Right)
        dropdown_profile: 'Profile',
        dropdown_theme: 'Dark Mode',
        dropdown_home: 'Home',
        dropdown_logout: 'Logout',
        // Subview keys (Profile, Orders, Products, Categories)
        prof_title: 'Admin Profile',
        prof_sub: 'Manage account information and admin profile',
        prof_username: 'Username',
        prof_email: 'Email',
        prof_phone: 'Phone number',
        prof_address: 'Address',
        prof_save: 'Save',
        prof_new_pass: 'New password',
        prof_conf_pass: 'Confirm password',
        prof_new_pass_ph: 'Enter password',
        prof_conf_pass_ph: 'Confirm password',
        ord_title: 'Order Processing',
        ord_sub: 'Manage and confirm incoming orders today.',
        tab_all: 'All',
        tab_pending: 'Pending',
        tab_cooking: 'Cooking',
        tab_ready: 'Ready to Serve',
        tab_completed: 'Completed',
        st_pending: 'Pending',
        st_cooking: 'Cooking',
        st_ready: 'Ready to Serve',
        st_completed: 'Completed',
        st_cancelled: 'Cancelled',
        ord_col_prod: 'Product',
        ord_col_qty: 'Qty',
        ord_col_price: 'Price',
        ord_total_label: 'Total',
        btn_confirm_order: 'Confirm Order',
        ord_done_badge: 'Order Completed',
        ord_cancel_badge: 'Order Cancelled',
        btn_detail: 'View Order Details',
        ord_empty: 'No orders in this status category yet.',
        prod_title: 'Product Data Page',
        prod_sub: 'Add new menu items, edit details/prices, and monitor stock availability',
        btn_filter: 'Filter',
        filter_all_cat: 'All Categories',
        btn_sort: 'Sort',
        btn_add_prod: 'Add New',
        col_prod_name: 'Menu',
        col_category: 'Category',
        col_price: 'Price',
        col_status: 'Status',
        col_action: 'Action',
        st_avail: 'Available',
        st_empty: 'Out of Stock',
        prod_empty: 'No products yet.',
        mod_prod_add: 'Add New Product',
        lbl_prod_name: 'Product Name',
        lbl_prod_price: 'Price (IDR)',
        lbl_prod_img: 'Product Image',
        lbl_prod_desc: 'Description',
        lbl_prod_avail: 'Available (In Stock)',
        lbl_prod_pop: 'Popular Menu',
        btn_save_prod: 'Save Product',
        cat_title: 'Product Categories Page',
        cat_sub: 'Add new categories and organize Toon Burger menu items',
        btn_add_cat: 'Add New',
        col_no: 'No.',
        cat_empty: 'No categories yet.',
        mod_cat_add: 'Add Category',
        lbl_cat_name: 'Category Name',
        btn_save: 'Save',
    }
};

let _cachedI18nNodes = null;
let _cachedCurrencyNodes = null;
let _cachedAttrNodes = null;

function applyTranslations(lang) {
    const isEn = (lang === 'EN' || lang === 'US');
    const dict = _tbTranslations[isEn ? 'EN' : 'ID'] || _tbTranslations['ID'];
    const currencyStr = isEn ? 'IDR' : 'Rp';

    if (!_cachedI18nNodes) {
        _cachedI18nNodes = Array.from(document.querySelectorAll('[data-i18n]'));
        _cachedCurrencyNodes = Array.from(document.querySelectorAll('[data-i18n="currency"], [data-currency], .currency-prefix'));
        _cachedAttrNodes = Array.from(document.querySelectorAll('[data-i18n-attr]'));
    }

    _cachedI18nNodes.forEach(el => {
        const key = el.getAttribute('data-i18n');
        const val = dict[key];
        if (val !== undefined && el.textContent !== val) {
            el.textContent = val;
        }
    });

    _cachedCurrencyNodes.forEach(el => {
        if (el.textContent !== currencyStr) {
            el.textContent = currencyStr;
        }
    });

    _cachedAttrNodes.forEach(el => {
        el.getAttribute('data-i18n-attr').split(';').forEach(pair => {
            const [attr, key] = pair.split(':');
            const attrName = attr.trim();
            const val = dict[key];
            if (val !== undefined && el.getAttribute(attrName) !== val) {
                el.setAttribute(attrName, val);
            }
        });
    });

    const optAllCat = document.getElementById('opt-all-categories');
    if (optAllCat && dict['products_all_categories']) {
        const count = optAllCat.getAttribute('data-count');
        const nextCat = `${dict['products_all_categories']}${count ? ' (' + count + ')' : ''}`;
        if (optAllCat.textContent !== nextCat) optAllCat.textContent = nextCat;
    }

    const optAllRatings = document.getElementById('opt-all-ratings');
    if (optAllRatings && dict['messages_filter_all']) {
        const count = optAllRatings.getAttribute('data-count');
        const nextRatings = `${dict['messages_filter_all']}${count !== null ? ' (' + count + ')' : ''}`;
        if (optAllRatings.textContent !== nextRatings) optAllRatings.textContent = nextRatings;
    }
}

function selectLanguage(lang, code) {
    window._tbLang = code;
    const label = document.getElementById('header-lang-label');
    if (label) label.textContent = lang;

    const checkEn = document.getElementById('lang-check-en');
    const checkId = document.getElementById('lang-check-id');
    if (checkEn && checkId) {
        if (code === 'US') {
            checkEn.classList.remove('hidden');
            checkId.classList.add('hidden');
        } else {
            checkEn.classList.add('hidden');
            checkId.classList.remove('hidden');
        }
    }

    const flagContainer = document.getElementById('header-lang-flag');
    if (flagContainer) {
        if (code === 'US') {
            flagContainer.innerHTML = `
                <svg class="w-full h-full" viewBox="0 0 64 64">
                    <clipPath id="circle-flag-header"><circle cx="32" cy="32" r="32"/></clipPath>
                    <g clip-path="url(#circle-flag-header)">
                        <path fill="#B22234" d="M0 0h64v64H0z"/>
                        <path stroke="#FFF" stroke-width="5" d="M0 7.5h64M0 17.5h64M0 27.5h64M0 37.5h64M0 47.5h64M0 57.5h64"/>
                        <path fill="#3C3B6E" d="M0 0h32v35H0z"/>
                        <circle cx="8" cy="8" r="1.5" fill="#FFF"/>
                        <circle cx="16" cy="8" r="1.5" fill="#FFF"/>
                        <circle cx="24" cy="8" r="1.5" fill="#FFF"/>
                        <circle cx="12" cy="14" r="1.5" fill="#FFF"/>
                        <circle cx="20" cy="14" r="1.5" fill="#FFF"/>
                        <circle cx="8" cy="20" r="1.5" fill="#FFF"/>
                        <circle cx="16" cy="20" r="1.5" fill="#FFF"/>
                        <circle cx="24" cy="20" r="1.5" fill="#FFF"/>
                        <circle cx="12" cy="26" r="1.5" fill="#FFF"/>
                        <circle cx="20" cy="26" r="1.5" fill="#FFF"/>
                    </g>
                </svg>`;
        } else {
            flagContainer.innerHTML = `
                <svg class="w-full h-full" viewBox="0 0 64 64">
                    <clipPath id="circle-flag-id"><circle cx="32" cy="32" r="32"/></clipPath>
                    <g clip-path="url(#circle-flag-id)">
                        <path fill="#E11B22" d="M0 0h64v32H0z"/>
                        <path fill="#FFFFFF" d="M0 32h64v32H0z"/>
                    </g>
                </svg>`;
        }
    }

    applyTranslations(code === 'US' ? 'EN' : 'ID');
    updateAdminThemeUI(getAdminTheme());

    // Sync Profile Dropdown Language Toggle
    const isEnglish = (code === 'US' || code === 'EN');
    const profileLangLabel = document.getElementById('header-profile-lang-label');
    const profileLangFlag = document.getElementById('header-profile-lang-flag');
    const profileLangCode = document.getElementById('header-profile-lang-code');
    if (profileLangLabel) {
        profileLangLabel.textContent = isEnglish ? 'Language: English' : 'Bahasa: Indonesia';
    }
    if (profileLangFlag) {
        profileLangFlag.textContent = isEnglish ? '🇺🇸' : '🇮🇩';
    }
    if (profileLangCode) {
        profileLangCode.textContent = isEnglish ? 'EN' : 'ID';
    }

    window.dispatchEvent(new CustomEvent('tb:langchange', { detail: { lang: code === 'US' ? 'EN' : 'ID' } }));

    try {
        localStorage.setItem('tb_admin_lang', code);
        localStorage.setItem('tb_lang', isEnglish ? 'EN' : 'ID');
    } catch (err) {}

    const dropdown = document.getElementById('header-lang-dropdown');
    const chevron = document.getElementById('header-lang-chevron');
    if (dropdown) dropdown.classList.add('hidden');
    if (chevron) chevron.style.transform = 'rotate(0deg)';
}

function toggleAdminLanguage() {
    const isEnglish = (window._tbLang === 'US' || window._tbLang === 'EN');
    if (isEnglish) {
        selectLanguage('Indonesia', 'ID');
    } else {
        selectLanguage('English', 'US');
    }
}

function toggleProfileDropdown(e) {
    if (e) e.stopPropagation();
    const dropdown = document.getElementById('header-profile-dropdown');
    const chevron = document.getElementById('header-profile-chevron');
    const langDropdown = document.getElementById('header-lang-dropdown');
    const langChevron = document.getElementById('header-lang-chevron');
    const searchResults = document.getElementById('header-search-results');

    if (langDropdown) langDropdown.classList.add('hidden');
    if (langChevron) langChevron.style.transform = 'rotate(0deg)';
    if (searchResults) searchResults.classList.add('hidden');

    if (dropdown) {
        const isHidden = dropdown.classList.toggle('hidden');
        if (chevron) {
            chevron.style.transform = isHidden ? 'rotate(0deg)' : 'rotate(180deg)';
        }
    }
}

// ==========================================
// Theme Management (Light / Dark Mode)
// ==========================================
function getAdminTheme() {
    return document.documentElement.classList.contains('dark') ? 'dark' : 'light';
}

function updateAdminThemeUI(theme) {
    const isDark = (theme === 'dark');
    const moonIcon = document.getElementById('header-theme-moon-icon');
    const sunIcon = document.getElementById('header-theme-sun-icon');
    const themeLabel = document.getElementById('header-theme-label');
    const isEn = (window._tbLang === 'US' || window._tbLang === 'EN');

    if (moonIcon && sunIcon) {
        if (isDark) {
            moonIcon.classList.add('hidden');
            sunIcon.classList.remove('hidden');
        } else {
            moonIcon.classList.remove('hidden');
            sunIcon.classList.add('hidden');
        }
    }

    if (themeLabel) {
        if (isDark) {
            themeLabel.textContent = isEn ? 'Light Mode' : 'Mode Terang';
        } else {
            themeLabel.textContent = isEn ? 'Dark Mode' : 'Mode Gelap';
        }
    }
}

function setAdminTheme(theme) {
    try {
        localStorage.setItem('toon_theme', theme);
    } catch (err) {}

    if (theme === 'dark') {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }

    updateAdminThemeUI(theme);
}

function toggleAdminTheme() {
    const current = getAdminTheme();
    const next = (current === 'dark') ? 'light' : 'dark';
    setAdminTheme(next);
}

let searchDebounceTimer = null;
let searchAbortController = null;
const searchResultCache = new Map();
const searchInput = document.getElementById('global-header-search');
const searchClearBtn = document.getElementById('header-search-clear');
const searchResults = document.getElementById('header-search-results');
const searchLoading = document.getElementById('header-search-loading');
const searchContent = document.getElementById('header-search-content');

function clearHeaderSearch() {
    clearTimeout(searchDebounceTimer);
    if (searchAbortController) {
        searchAbortController.abort();
        searchAbortController = null;
    }
    if (searchInput) {
        searchInput.value = '';
        searchInput.focus();
    }
    if (searchClearBtn) searchClearBtn.classList.add('hidden');
    if (searchResults) searchResults.classList.add('hidden');
    if (searchContent) searchContent.innerHTML = '';
}

if (searchInput) {
    searchInput.addEventListener('input', function () {
        const query = this.value.trim();
        clearTimeout(searchDebounceTimer);
        if (searchAbortController) {
            searchAbortController.abort();
            searchAbortController = null;
        }

        if (query.length > 0) {
            if (searchClearBtn) searchClearBtn.classList.remove('hidden');
        } else {
            if (searchClearBtn) searchClearBtn.classList.add('hidden');
        }

        if (query.length < 1) {
            if (searchResults) searchResults.classList.add('hidden');
            if (searchContent) searchContent.innerHTML = '';
            return;
        }

        if (searchResults) searchResults.classList.remove('hidden');

        if (searchResultCache.has(query)) {
            if (searchLoading) searchLoading.classList.add('hidden');
            renderHeaderSearchResults(searchResultCache.get(query), query);
            return;
        }

        if (searchLoading) searchLoading.classList.remove('hidden');
        if (searchContent) searchContent.innerHTML = '';

        const adminSearchUrl = ADMIN_CONFIG.adminSearchUrl || '/admin/search/live';
        searchDebounceTimer = setTimeout(() => {
            searchAbortController = new AbortController();
            fetch(`${adminSearchUrl}?q=${encodeURIComponent(query)}`, {
                signal: searchAbortController.signal,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => {
                if (!res.ok) throw new Error('Network error');
                return res.json();
            })
            .then(data => {
                searchResultCache.set(query, data);
                if (searchLoading) searchLoading.classList.add('hidden');
                renderHeaderSearchResults(data, query);
            })
            .catch(err => {
                if (err && err.name === 'AbortError') return;
                if (searchLoading) searchLoading.classList.add('hidden');
                if (searchContent) {
                    searchContent.innerHTML = `<div class="text-xs text-gray-500 py-3 text-center">Gagal memuat hasil pencarian.</div>`;
                }
            });
        }, 180);
    });

    searchInput.addEventListener('focus', function () {
        if (this.value.trim().length > 0 && searchResults) {
            searchResults.classList.remove('hidden');
        }
    });
}

function escapeHeaderHtml(str) {
    if (!str) return '';
    return String(str).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
}

function renderHeaderSearchResults(data, query) {
    if (!searchContent) return;

    const isEn = (window._tbLang === 'US');
    const hasProducts = data.products && data.products.length > 0;
    const hasOrders = data.orders && data.orders.length > 0;
    const hasCategories = data.categories && data.categories.length > 0;
    const adminProductsUrl = ADMIN_CONFIG.adminProductsUrl || '/admin/products';
    const adminOrdersUrl = ADMIN_CONFIG.adminOrdersUrl || '/admin/orders';

    if (!hasProducts && !hasOrders && !hasCategories) {
        searchContent.innerHTML = `
            <div class="text-center py-6 text-gray-400">
                <svg class="w-7 h-7 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <p class="text-xs font-medium text-gray-500">${isEn ? 'No results for' : 'Tidak ada hasil untuk'} "<span class="font-bold text-gray-800">${escapeHeaderHtml(query)}</span>"</p>
                <p class="text-[11px] text-gray-400 mt-1">${isEn ? 'Try another keyword or check spelling.' : 'Coba kata kunci lain atau periksa ejaan.'}</p>
            </div>
        `;
        return;
    }

    let html = '<div class="space-y-3.5">';

    if (hasProducts) {
        html += `
            <div>
                <div class="flex items-center justify-between text-[11px] font-bold text-gray-400 uppercase tracking-wider px-2 py-1 border-b border-gray-100">
                    <span>${isEn ? 'Products' : 'Produk'} (${data.products.length})</span>
                    <a href="${adminProductsUrl}?search=${encodeURIComponent(query)}" class="text-[#415C58] hover:underline normal-case font-semibold">${isEn ? 'All Products' : 'Semua Produk'} &rarr;</a>
                </div>
                <div class="space-y-1 mt-1.5">
        `;
        data.products.forEach(p => {
            html += `
                <a href="${p.url}" class="flex items-center justify-between p-2 rounded-xl hover:bg-gray-50 transition group">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-8 h-8 rounded-lg bg-orange-50 border border-orange-100 flex items-center justify-center text-xs shrink-0 font-bold text-[#FFA000]">
                            🍔
                        </div>
                        <div class="min-w-0">
                            <div class="text-xs font-bold text-gray-800 group-hover:text-[#415C58] transition truncate">${escapeHeaderHtml(p.name)}</div>
                            <div class="text-[11px] text-gray-500 font-medium">${isEn && p.price_formatted ? p.price_formatted.replace(/^Rp\s*/i, 'IDR ') : p.price_formatted}</div>
                        </div>
                    </div>
                    <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full ${p.is_available ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700'}">
                        ${p.is_available ? (isEn ? 'Available' : 'Tersedia') : (isEn ? 'Out of Stock' : 'Habis')}
                    </span>
                </a>
            `;
        });
        html += `</div></div>`;
    }

    if (hasOrders) {
        html += `
            <div>
                <div class="flex items-center justify-between text-[11px] font-bold text-gray-400 uppercase tracking-wider px-2 py-1 border-b border-gray-100">
                    <span>${isEn ? 'Orders' : 'Pesanan'} (${data.orders.length})</span>
                    <a href="${adminOrdersUrl}?search=${encodeURIComponent(query)}" class="text-[#415C58] hover:underline normal-case font-semibold">${isEn ? 'All Orders' : 'Semua Pesanan'} &rarr;</a>
                </div>
                <div class="space-y-1 mt-1.5">
        `;
        data.orders.forEach(o => {
            html += `
                <a href="${o.url}" class="flex items-center justify-between p-2 rounded-xl hover:bg-gray-50 transition group">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 border border-blue-100 flex items-center justify-center text-xs shrink-0 font-bold text-blue-600">
                            🧾
                        </div>
                        <div class="min-w-0">
                            <div class="text-xs font-bold text-gray-800 group-hover:text-[#415C58] transition truncate">${escapeHeaderHtml(o.order_number)} <span class="text-gray-400 font-normal">(${escapeHeaderHtml(o.customer_name)})</span></div>
                            <div class="text-[11px] text-gray-500 font-medium">${isEn && o.total_formatted ? o.total_formatted.replace(/^Rp\s*/i, 'IDR ') : o.total_formatted}</div>
                        </div>
                    </div>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-gray-100 text-gray-700 capitalize">
                        ${escapeHeaderHtml(o.status)}
                    </span>
                </a>
            `;
        });
        html += `</div></div>`;
    }

    if (hasCategories) {
        html += `
            <div>
                <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider px-2 py-1 border-b border-gray-100">${isEn ? 'Categories' : 'Kategori'}</div>
                <div class="flex flex-wrap gap-1.5 mt-2 px-2">
        `;
        data.categories.forEach(c => {
            html += `
                <a href="${c.url}" class="inline-flex items-center gap-1.5 px-3 py-1 bg-gray-100 hover:bg-[#415C58] hover:text-white text-gray-700 rounded-lg text-xs font-medium transition">
                    <span>🏷️</span>
                    <span>${escapeHeaderHtml(c.name)}</span>
                </a>
            `;
        });
        html += `</div></div>`;
    }

    html += '</div>';
    searchContent.innerHTML = html;
}

// Global Outside Click
document.addEventListener('click', function (e) {
    const langDropdown = document.getElementById('header-lang-dropdown');
    const langBtn = document.getElementById('header-lang-btn');
    const langChevron = document.getElementById('header-lang-chevron');
    if (langDropdown && !langDropdown.contains(e.target) && (!langBtn || !langBtn.contains(e.target))) {
        langDropdown.classList.add('hidden');
        if (langChevron) langChevron.style.transform = 'rotate(0deg)';
    }

    const profileDropdown = document.getElementById('header-profile-dropdown');
    const profileBtn = document.getElementById('header-profile-btn');
    const profileChevron = document.getElementById('header-profile-chevron');
    if (profileDropdown && !profileDropdown.contains(e.target) && (!profileBtn || !profileBtn.contains(e.target))) {
        profileDropdown.classList.add('hidden');
        if (profileChevron) profileChevron.style.transform = 'rotate(0deg)';
    }

    const searchInput = document.getElementById('global-header-search');
    const searchResults = document.getElementById('header-search-results');
    if (searchResults && searchInput && !searchResults.contains(e.target) && !searchInput.contains(e.target)) {
        searchResults.classList.add('hidden');
    }
});

// Restore theme and language preferences with zero redundant DOM mutations on default state
try {
    const savedLang = localStorage.getItem('tb_admin_lang') || localStorage.getItem('tb_lang') || 'ID';
    window._tbLang = (savedLang === 'US' || savedLang === 'EN') ? 'US' : 'ID';
    if (window._tbLang === 'US') {
        selectLanguage('English', 'US');
    } else {
        selectLanguage('Indonesia', 'ID');
        const savedTheme = getAdminTheme();
        if (savedTheme === 'dark') {
            updateAdminThemeUI('dark');
        }
    }
} catch (err) {}

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
});

window.addEventListener('pageshow', function () {
    if (localStorage.getItem('tb_logged_out') === '1') {
        document.documentElement.style.display = 'none';
        window.location.replace(ADMIN_CONFIG.loginUrl || '/login');
    }
});

// Instant Single-Click Admin Navigation (PJAX + Sequential Prefetch Cache)
(function () {
    const _tbAdminPageCache = new Map();
    const _tbAdminInFlight = new Map();
    const ADMIN_CACHE_TTL_MS = 45000;
    let _tbBgPrefetchAbort = null;

    function normalizeAdminUrl(rawUrl) {
        try {
            const u = new URL(rawUrl, window.location.origin);
            u.hash = '';
            return u.href;
        } catch (e) {
            return null;
        }
    }

    function isAdminInternalUrl(rawUrl) {
        try {
            const u = new URL(rawUrl, window.location.origin);
            if (u.origin !== window.location.origin) return false;
            const p = u.pathname.replace(/\/+$/, '') || '/';
            return p === '/admin' || p.startsWith('/admin/');
        } catch (e) {
            return false;
        }
    }

    function updateAdminNavHighlight(targetUrl) {
        let p = '/admin';
        try {
            p = new URL(targetUrl, window.location.origin).pathname.replace(/\/+$/, '') || '/admin';
        } catch (e) {}

        function matchesNavPath(linkHref) {
            try {
                const lp = new URL(linkHref, window.location.origin).pathname.replace(/\/+$/, '') || '/admin';
                if (lp === '/admin') return p === '/admin';
                return p === lp || p.startsWith(lp + '/');
            } catch (e) {
                return false;
            }
        }

        const sidebarLinks = document.querySelectorAll('#admin-sidebar nav a[href]');
        sidebarLinks.forEach((a) => {
            const active = matchesNavPath(a.getAttribute('href'));
            a.className = 'flex items-center gap-4 px-5 py-3.5 transition rounded-full ' +
                (active
                    ? 'bg-[#40605D] text-white font-medium shadow-xs'
                    : 'text-[#374151] hover:bg-gray-100/80 hover:text-gray-900');
        });

        const bottomLinks = document.querySelectorAll('nav.md\\:hidden a[href]');
        bottomLinks.forEach((a) => {
            const active = matchesNavPath(a.getAttribute('href'));
            a.className = 'flex-1 flex flex-col items-center justify-center gap-1 py-2.5 min-h-[56px] transition tb-focus-ring ' +
                (active
                    ? 'text-[#385A56] dark:text-[#8CC0B9]'
                    : 'text-[#5F6672] dark:text-[#C4C9D0] active:text-[#385A56]');
        });
    }

    function closeMobileAdminSidebarIfOpen() {
        const sidebar = document.getElementById('admin-sidebar');
        const backdrop = document.getElementById('admin-sidebar-backdrop');
        const bottomNav = document.getElementById('admin-bottom-nav');
        if (sidebar && !sidebar.classList.contains('-translate-x-full')) {
            sidebar.classList.add('-translate-x-full');
            if (backdrop) backdrop.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
            if (bottomNav) bottomNav.classList.remove('translate-y-full');
        }
    }

    function runScriptsInContainer(container) {
        if (!container) return;
        container.querySelectorAll('script').forEach((oldScript) => {
            const newScript = document.createElement('script');
            Array.from(oldScript.attributes).forEach((attr) => {
                newScript.setAttribute(attr.name, attr.value);
            });
            newScript.textContent = oldScript.textContent;
            oldScript.parentNode.replaceChild(newScript, oldScript);
        });
    }

    function swapAdminMainFromHtml(html, targetUrl, pushHistory) {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const newMain = doc.querySelector('main');
        const curMain = document.querySelector('main');
        if (!newMain || !curMain) {
            window.location.href = targetUrl;
            return false;
        }

        if (doc.title) {
            document.title = doc.title;
        }

        curMain.innerHTML = newMain.innerHTML;
        updateAdminNavHighlight(targetUrl);
        closeAllHeaderDropdowns();
        closeMobileAdminSidebarIfOpen();
        document.body.style.overflow = '';

        if (pushHistory && normalizeAdminUrl(window.location.href) !== targetUrl) {
            history.pushState({ tbAdminUrl: targetUrl }, doc.title || document.title, targetUrl);
        }

        window.scrollTo({ top: 0, behavior: 'instant' });
        runScriptsInContainer(curMain);
        if (typeof window.initAutoDismissAlerts === 'function') {
            window.initAutoDismissAlerts();
        }

        _cachedI18nNodes = null;
        _cachedCurrencyNodes = null;
        _cachedAttrNodes = null;
        if (window._tbLang === 'US' || window._tbLang === 'EN') {
            applyTranslations('EN');
        }
        return true;
    }

    function prefetchAdminUrl(rawUrl, isPriority) {
        if (!isAdminInternalUrl(rawUrl)) return Promise.resolve(null);
        const key = normalizeAdminUrl(rawUrl);
        if (!key) return Promise.resolve(null);

        const cached = _tbAdminPageCache.get(key);
        if (cached && (Date.now() - cached.ts < ADMIN_CACHE_TTL_MS)) {
            return Promise.resolve(cached.html);
        }

        if (_tbAdminInFlight.has(key)) {
            return _tbAdminInFlight.get(key);
        }

        if (isPriority && _tbBgPrefetchAbort) {
            _tbBgPrefetchAbort.abort();
            _tbBgPrefetchAbort = null;
        }

        const controller = new AbortController();
        if (!isPriority) {
            _tbBgPrefetchAbort = controller;
        }

        const promise = fetch(key, {
            method: 'GET',
            credentials: 'same-origin',
            signal: controller.signal,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html,application/xhtml+xml'
            }
        })
        .then((res) => {
            if (!res.ok || res.redirected && !isAdminInternalUrl(res.url)) {
                throw new Error('Non-cacheable response');
            }
            return res.text();
        })
        .then((html) => {
            _tbAdminInFlight.delete(key);
            if (html && html.includes('<main')) {
                _tbAdminPageCache.set(key, { html, ts: Date.now() });
                return html;
            }
            return null;
        })
        .catch(() => {
            _tbAdminInFlight.delete(key);
            return null;
        });

        _tbAdminInFlight.set(key, promise);
        return promise;
    }

    function navigateAdminTo(rawUrl, pushHistory = true) {
        const targetUrl = normalizeAdminUrl(rawUrl);
        if (!targetUrl || !isAdminInternalUrl(targetUrl)) {
            window.location.href = rawUrl;
            return;
        }

        updateAdminNavHighlight(targetUrl);
        closeAllHeaderDropdowns();
        closeMobileAdminSidebarIfOpen();

        const cached = _tbAdminPageCache.get(targetUrl);
        if (cached) {
            swapAdminMainFromHtml(cached.html, targetUrl, pushHistory);
            if (Date.now() - cached.ts > 8000) {
                _tbAdminPageCache.delete(targetUrl);
                prefetchAdminUrl(targetUrl, false);
            }
            return;
        }

        prefetchAdminUrl(targetUrl, true).then((html) => {
            if (html) {
                swapAdminMainFromHtml(html, targetUrl, pushHistory);
            } else {
                window.location.href = targetUrl;
            }
        });
    }

    window.tbAdminNavigate = navigateAdminTo;

    // Seed current page into cache immediately
    const initialUrl = normalizeAdminUrl(window.location.href);
    if (initialUrl) {
        _tbAdminPageCache.set(initialUrl, {
            html: document.documentElement.outerHTML,
            ts: Date.now()
        });
        history.replaceState({ tbAdminUrl: initialUrl }, document.title, window.location.href);
    }

    // Prefetch on hover or press
    function handleLinkPrefetchHint(e) {
        const link = e.target.closest ? e.target.closest('a[href]') : null;
        if (!link) return;
        const href = link.getAttribute('href');
        if (!href || href.startsWith('#') || href.startsWith('javascript:')) return;
        if (isAdminInternalUrl(link.href)) {
            prefetchAdminUrl(link.href, true);
        }
    }

    document.addEventListener('pointerover', handleLinkPrefetchHint, { passive: true });
    document.addEventListener('mousedown', handleLinkPrefetchHint, { passive: true });
    document.addEventListener('touchstart', handleLinkPrefetchHint, { passive: true });

    // Instant single-click navigation handler
    document.addEventListener('click', function (e) {
        if (e.defaultPrevented || e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
        const link = e.target.closest ? e.target.closest('a[href]') : null;
        if (!link) return;
        const rawHref = link.getAttribute('href');
        if (!rawHref || rawHref.startsWith('#') || rawHref.startsWith('javascript:') || rawHref.startsWith('mailto:') || rawHref.startsWith('tel:')) return;
        if (link.getAttribute('target') === '_blank' || link.hasAttribute('download') || link.hasAttribute('data-no-pjax')) return;
        if (!isAdminInternalUrl(link.href)) return;

        e.preventDefault();
        navigateAdminTo(link.href, true);
    });

    // Intercept GET forms (search & filters) for instant navigation; clear cache on POST/PUT/PATCH/DELETE
    document.addEventListener('submit', function (e) {
        const form = e.target;
        if (!form || form.tagName !== 'FORM') return;
        const method = (form.getAttribute('method') || 'GET').toUpperCase();
        if (method === 'GET' && isAdminInternalUrl(form.action || window.location.href)) {
            e.preventDefault();
            const actionUrl = new URL(form.action || window.location.href, window.location.origin);
            const formData = new FormData(form);
            actionUrl.search = new URLSearchParams(formData).toString();
            navigateAdminTo(actionUrl.href, true);
        } else {
            _tbAdminPageCache.clear();
        }
    });

    // Instant Back/Forward button support
    window.addEventListener('popstate', function () {
        if (isAdminInternalUrl(window.location.href)) {
            navigateAdminTo(window.location.href, false);
        }
    });

    // Sequential background warm-up of primary sidebar links (friendly to single-threaded dev server)
    setTimeout(async function () {
        const primaryLinks = [
            ADMIN_CONFIG.adminDashboardUrl,
            ADMIN_CONFIG.adminProfileUrl,
            ADMIN_CONFIG.adminOrdersUrl,
            ADMIN_CONFIG.adminProductsUrl,
            ADMIN_CONFIG.adminCategoriesUrl,
            ADMIN_CONFIG.adminMessagesUrl
        ].filter(Boolean);
        for (const url of primaryLinks) {
            const norm = normalizeAdminUrl(url);
            if (norm && !_tbAdminPageCache.has(norm)) {
                await prefetchAdminUrl(norm, false);
            }
        }
    }, 120);
})();
