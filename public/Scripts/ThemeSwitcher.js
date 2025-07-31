document.addEventListener('DOMContentLoaded', () => {
    const changeThemeBtn = document.getElementById('change-theme-btn');
    const pageStyleLink = document.getElementById('page-theme-style');
    const formStyleLink = document.getElementById('form-theme-style');
    let basePath = '';
    const linkElement = pageStyleLink || formStyleLink;
    if (linkElement) {
        const initialHref = linkElement.getAttribute('href');
        basePath = initialHref.substring(0, initialHref.lastIndexOf('/') + 1);
    }
    const themes = {
        blue: {
            page: basePath + 'BluePage.css',
            form: basePath + 'BlueForm.css'
        },
        black: {
            page: basePath + 'Page.css',
            form: basePath + 'Form.css'
        }
    };
    const setTheme = (themeName) => {
        if (!themes[themeName] || !basePath) return;

        if (pageStyleLink) {
            pageStyleLink.setAttribute('href', themes[themeName].page);
        }
        if (formStyleLink) {
            formStyleLink.setAttribute('href', themes[themeName].form);
        }
        localStorage.setItem('theme_preference', themeName);
    };
    const savedTheme = localStorage.getItem('theme_preference') || 'black';
    setTheme(savedTheme);
    if (changeThemeBtn) {
        changeThemeBtn.addEventListener('click', () => {
            const currentTheme = localStorage.getItem('theme_preference') || 'black';
            const newTheme = currentTheme === 'black' ? 'blue' : 'black';
            setTheme(newTheme);
        });
    }
});