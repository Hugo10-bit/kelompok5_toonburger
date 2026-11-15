(function () {
    if (localStorage.getItem('tb_logged_out') === '1') {
        var loginMeta = document.querySelector('meta[name="login-url"]');
        var loginUrl = loginMeta ? loginMeta.getAttribute('content') : '/login';
        document.documentElement.style.display = 'none';
        window.location.replace(loginUrl);
    }

    // Prevent theme flash (FOUC)
    if (localStorage.getItem('toon_theme') === 'dark') {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
})();
