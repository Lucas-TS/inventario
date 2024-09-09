function liberarCampo2Pv() {
    let campo = document.getElementById('marca-pv');
    campo.setAttribute('placeholder', 'Escolha o fabricante');
    campo.disabled = false;
    campo.value = '';
    campo.addEventListener('click', handleEvent);
    campo.addEventListener('keyup', handleEvent);
}

function liberarCampo3Pv() {
    let campo = document.getElementById('modelo-pv');
    campo.setAttribute('placeholder', 'Escolha o modelo');
    campo.disabled = false;
    campo.value = '';
    campo.addEventListener('click', handleEvent);
    campo.addEventListener('keyup', handleEvent);
}

function liberarCampo4Pv() {
    let campo = document.getElementById('mem-pv');
    campo.setAttribute('placeholder', 'Escolha');
    campo.disabled = false;
    campo.value = '';
    campo.addEventListener('click', handleEvent);
    campo.addEventListener('keyup', handleEvent);
}