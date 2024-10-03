    const previousPage = document.referrer || sessionStorage.getItem('previousPage');
    if (previousPage) {
        sessionStorage.setItem('previousPage', previousPage);
    }