document.addEventListener('DOMContentLoaded', () => {

    // 1. Seleccionar los elementos. Si no existen, su valor será 'null'.
    const changeThemeBtn = document.getElementById('change-theme-btn');
    const pageStyleLink = document.getElementById('page-theme-style');
    const formStyleLink = document.getElementById('form-theme-style');

    const themes = {
        blue: {
            page: 'CSS/BluePage.css',
            form: 'CSS/BlueForm.css'
        },
        black: {
            page: 'CSS/Page.css',
            form: 'CSS/Form.css'
        }
    };

    // 2. Función para aplicar el tema
    const setTheme = (themeName) => {
        if (!themes[themeName]) return; // Salir si el tema no existe

        // **LA CLAVE ESTÁ AQUÍ**
        // Verificamos si la etiqueta para el estilo de página existe antes de cambiarla
        if (pageStyleLink) {
            pageStyleLink.setAttribute('href', themes[themeName].page);
        }

        // Hacemos lo mismo para el estilo del formulario
        if (formStyleLink) {
            formStyleLink.setAttribute('href', themes[themeName].form);
        }

        // Guardamos la preferencia general
        localStorage.setItem('theme_preference', themeName);
    };

    // 3. Al cargar la página, aplicar el tema guardado
    const savedTheme = localStorage.getItem('theme_preference') || 'blue'; // 'blue' por defecto
    setTheme(savedTheme);

    // 4. Evento del botón para alternar (solo si el botón existe)
    if (changeThemeBtn) {
        changeThemeBtn.addEventListener('click', () => {
            const currentTheme = localStorage.getItem('theme_preference') || 'blue';
            const newTheme = currentTheme === 'blue' ? 'black' : 'blue';
            setTheme(newTheme);
        });
    }
});