document.addEventListener('DOMContentLoaded', () => {
    const changeThemeBtn = document.getElementById('change-theme-btn');
    const themeStyleLink = document.getElementById('theme-style');
    if (!changeThemeBtn || !themeStyleLink) {
        console.error("No se encontraron los elementos para cambiar el tema.");
        return;
    }
    const applyTheme = (themeName) => {
        const currentHref = themeStyleLink.getAttribute('href');
        let newHref;

        if (currentHref.includes('BluePage.css')) {
            newHref = currentHref.replace('BluePage.css', themeName);
        } else {
            newHref = currentHref.replace('Page.css', themeName);
        }
        themeStyleLink.setAttribute('href', newHref);
        localStorage.setItem('selected_theme', themeName);
    };
    const savedTheme = localStorage.getItem('selected_theme');
    if (savedTheme) {
        applyTheme(savedTheme);
    }
    changeThemeBtn.addEventListener('click', () => {
        const currentTheme = themeStyleLink.getAttribute('href');
        if (currentTheme.includes('BluePage.css')) {
            applyTheme('Page.css');
        } else {
            applyTheme('BluePage.css');
        }
    });
});