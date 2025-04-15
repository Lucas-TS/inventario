function liberarMacWifi() {
    let campo = document.getElementById('input-mac-wifi');
    campo.disabled = false;
    campo.value = '';
}

function bloquearMacWifi() {
    let campo = document.getElementById('input-mac-wifi');
    campo.disabled = true;
    campo.value = '';
}