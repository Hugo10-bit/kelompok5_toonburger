(function () {
    // Prevent theme flash (FOUC)
    if (localStorage.getItem('toon_theme') === 'dark') {
        document.documentElement.classList.add('dark');
        document.documentElement.style.colorScheme = 'dark';
    } else {
        document.documentElement.classList.remove('dark');
        document.documentElement.style.colorScheme = 'light';
    }
})();
