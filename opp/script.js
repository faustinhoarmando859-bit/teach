const styleLinks = Array.from(document.querySelectorAll('[data-style]'));

function setStylesheet(fileName) {
    const active = document.getElementById('active-stylesheet');

    if (active) {
        active.remove();
    }

    if (!fileName) {
        // Keep the page in the browser's default HTML/CSS styling.
        return;
    }

    const link = document.createElement('link');
    link.rel = 'stylesheet';
    link.href = fileName;
    link.id = 'active-stylesheet';
    document.head.appendChild(link);
}

styleLinks.forEach((element) => {
    element.addEventListener('click', (event) => {
        event.preventDefault();
        const selectedStyle = event.currentTarget.dataset.style;
        setStylesheet(selectedStyle);
    });
});
