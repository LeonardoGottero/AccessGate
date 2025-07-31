document.addEventListener('DOMContentLoaded', () => {
    const changeThemeBtn = document.getElementById('change-theme-btn');
    const pageStyleLink = document.getElementById('page-theme-style');
    const formStyleLink = document.getElementById('form-theme-style');
    const basePath = 'CSS/';
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
        if (themes[themeName]) {
            pageStyleLink.setAttribute('href', themes[themeName].page);
            formStyleLink.setAttribute('href', themes[themeName].form);
            localStorage.setItem('theme_preference', themeName);
        }
    };
    const savedTheme = localStorage.getItem('theme_preference');
    if (savedTheme) {
        setTheme(savedTheme);
    } else {
        setTheme('blue');
    }
    changeThemeBtn.addEventListener('click', () => {
        const currentTheme = localStorage.getItem('theme_preference') || 'blue';
        const newTheme = currentTheme === 'blue' ? 'black' : 'blue';
        setTheme(newTheme);
    });
});