function formularioGPU(str1, str2 = 'Desktop') {
    let linha = document.getElementById("formulario-pv-1");
    let conteudo = '';
        if (str1 === 'off') {
            if (str2 === 'Desktop') {
            conteudo = `
                <div id="b-line-pv-2" class="b-line"><label class="label" for="gpu-pv">Chipset:</label>
                    <input id="gpu-pv" class="input box" type="text" name="gpu-pv" class="input" placeholder="Escolha o chipset" required style="width:245px;" onkeyup="disableCampo2Pv()">
                    <div id="suggestions-gpu-pv" class="suggestions-box gpu-pv"></div>
                </div>
                <div id="h-spacer"></div>
                <div id="b-line-pv-3" class="b-line"><label class="label" for="marca-pv">Fabricante:</label>
                    <input id="marca-pv" class="input openBox" type="text" name="marca-pv" class="input" placeholder="Escolha o chipset" required disabled style="width:245px;" onkeyup="disableCampo3Pv()">
                    <div id="suggestions-marca-pv" class="suggestions-box marca-pv"></div>
                </div>
                <div id="h-spacer" style="flex-basis: 100%;"></div>
                <div id="b-line-pv-4" class="b-line"><label class="label" for="modelo-pv">Modelo:</label>
                    <input id="modelo-pv" class="input openBox" type="text" name="modelo-pv" class="input" placeholder="Escolha o chipset" required disabled style="width:245px;" onkeyup="disableCampo4Pv()">
                    <div id="suggestions-modelo-pv" class="suggestions-box modelo-pv"></div>
                </div>
                <div id="h-spacer"></div>
                <div id="b-line-pv-5" class="b-line"><label class="label" for="mem-pv">Memória:</label>
                    <input id="mem-pv" class="input openBox" type="text" name="mem-pv" class="input" placeholder="Escolha o chipset" required disabled style="width:145px;">
                    <div id="suggestions-mem-pv" class="suggestions-box mem-pv"></div>
                </div>
                <input id="hidden-mem-pv" name="hidden-mem-pv" type="hidden" value="">
                <input id="hidden-id-assoc-pv" name="hidden-id-assoc-pv" type="hidden" value="">
                `;
            } else if (str2 === 'Notebook') {
                conteudo = `
                <div id="b-line-pv-2" class="b-line"><label class="label" for="gpu-pv-nb">Chipset:</label>
                    <input id="gpu-pv-nb" class="input box" type="text" name="gpu-pv-nb" class="input" placeholder="Escolha o chipset" required style="width:245px;" onkeyup="disableCampo2PvNb()">
                    <div id="suggestions-gpu-pv-nb" class="suggestions-box gpu-pv-nb"></div>
                </div>
                <div id="h-spacer"></div>
                <div id="b-line-pv-5" class="b-line"><label class="label" for="mem-pv-nb">Memória:</label>
                    <input id="mem-pv-nb" class="input openBox" type="text" name="mem-pv-nb" class="input" placeholder="Escolha o chipset" required disabled style="width:145px;">
                    <div id="suggestions-mem-pv-nb" class="suggestions-box mem-pv-nb"></div>
                </div>
                <input id="hidden-mem-pv-nb" name="hidden-mem-pv-nb" type="hidden" value="">
                <input id="hidden-id-assoc-pv" name="hidden-id-assoc-pv" type="hidden" value="">
                `;
            }
    } else if (str1 === 'on') {
        conteudo = ``;
    }
    linha.innerHTML = conteudo;
}

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

function liberarCampo2PvNb() {
    let campo = document.getElementById('mem-pv-nb');
    campo.setAttribute('placeholder', 'Escolha');
    campo.disabled = false;
    campo.value = '';
    campo.addEventListener('click', handleEvent);
    campo.addEventListener('keyup', handleEvent);
}

function disableCampo2PvNb() {
    let campo4 = document.getElementById('mem-pv-nb');
    campo4.setAttribute('placeholder', 'Escolha o modelo');
    campo4.disabled = true;
    campo4.value = '';
    let campo5 = document.getElementById('hidden-mem-pv');
    campo5.value = '';
}