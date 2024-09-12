function liberarCampo2Pv() {
    let campo = document.getElementById('marca-pv');
    let campo2 = document.getElementById('modelo-pv');
    let campo3 = document.getElementById('mem-pv');
    campo.setAttribute('placeholder', 'Escolha o fabricante');
    campo2.setAttribute('placeholder', 'Escolha o fabricante');
    campo3.setAttribute('placeholder', 'Escolha o fabricante');
    campo.disabled = false;
    campo.value = '';
    campo.addEventListener('click', handleEvent);
    campo.addEventListener('keyup', handleEvent);
}

function disableCampo2Pv() {
    let campo2 = document.getElementById('marca-pv');
    campo2.setAttribute('placeholder', 'Escolha o chipset');
    campo2.disabled = true;
    campo2.value = '';
    let campo3 = document.getElementById('modelo-pv');
    campo3.setAttribute('placeholder', 'Escolha o chipset');
    campo3.disabled = true;
    campo3.value = '';
    let campo4 = document.getElementById('mem-pv');
    campo4.setAttribute('placeholder', 'Escolha o chipset');
    campo4.disabled = true;
    campo4.value = '';
}

function liberarCampo3Pv() {
    let campo = document.getElementById('modelo-pv');
    let campo2 = document.getElementById('mem-pv');
    campo.setAttribute('placeholder', 'Escolha o modelo');
    campo2.setAttribute('placeholder', 'Escolha o modelo');
    campo.disabled = false;
    campo.value = '';
    campo.addEventListener('click', handleEvent);
    campo.addEventListener('keyup', handleEvent);
}

function disableCampo3Pv() {
    let campo3 = document.getElementById('modelo-pv');
    campo3.setAttribute('placeholder', 'Escolha o fabricante');
    campo3.disabled = true;
    campo3.value = '';
    let campo4 = document.getElementById('mem-pv');
    campo4.setAttribute('placeholder', 'Escolha o fabricante');
    campo4.disabled = true;
    campo4.value = '';
}

function liberarCampo4Pv() {
    let campo = document.getElementById('mem-pv');
    campo.setAttribute('placeholder', 'Escolha');
    campo.disabled = false;
    campo.value = '';
    campo.addEventListener('click', handleEvent);
    campo.addEventListener('keyup', handleEvent);
}

function disableCampo4Pv() {
    let campo4 = document.getElementById('mem-pv');
    campo4.setAttribute('placeholder', 'Escolha o modelo');
    campo4.disabled = true;
    campo4.value = '';
    let campo5 = document.getElementById('hidden-mem-pv');
    campo5.value = '';
}