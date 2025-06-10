setTimeout(() => {
    const errorAlert = document.getElementById('alert-error');
    const successAlert = document.getElementById('alert-success');

    [errorAlert, successAlert].forEach(alert => {
        if (alert) {
            alert.classList.add('fade-out');
            setTimeout(() => {
                alert.remove();
            }, 1000);
        }
    });
}, 7000);
