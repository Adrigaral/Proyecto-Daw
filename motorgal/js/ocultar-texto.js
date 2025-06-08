setTimeout(() => {
    const errorAlert = document.getElementById('alert-error');
    const successAlert = document.getElementById('alert-success');
    
    if (errorAlert) errorAlert.remove();
    if (successAlert) successAlert.remove();
}, 7000);