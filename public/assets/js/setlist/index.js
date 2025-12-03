$(document).ready(function () {
    const urlParams = new URLSearchParams(window.location.search);
    const activeTab = urlParams.get('tab');

    if (activeTab === 'request') {
        const requestTab = new bootstrap.Tab($('#request-tab')[0]);
        requestTab.show();

        // Optional: clean up the URL after switching tabs
        if (window.history.replaceState) {
            const cleanUrl = window.location.origin + window.location.pathname;
            window.history.replaceState({}, document.title, cleanUrl);
        }
    }
});
