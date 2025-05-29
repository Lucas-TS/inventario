function formularioOffice(str1) {
    let linha = document.getElementById("formulario-office-1");
    let conteudo = '';
    if (str1 === 'Office') {
        conteudo = `
            <div id="b-line-office-2" class="b-line"><label class="label" for="ver-ms">Versão:</label><input id="ver-ms" class="input openBox" type="text" name="ver-office" placeholder="Escolha a versão" required  style="width:190px"></div>
            <div id="suggestions-ver-ms" class="suggestions-box ver-office ms">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-office-3" class="b-line"><label class="label" for="ed-ms">Edição:</label><input id="ed-ms" class="input openBox" type="text" name="ed-office" placeholder="Escolha a versão" disabled style="width:190px"></div>
            <div id="suggestions-ed-ms" class="suggestions-box ed-office ms">
            </div>
            <input id="hidden-office" name="hidden-office" type="hidden" value="">
            <input id="hidden-id-assoc-office" name="hidden-id-assoc-office" type="hidden" value="">
            <div id="h-spacer" style="flex-basis: 100%;"></div>
            <div id="b-line-office-4" class="b-line">
                <input type="radio" id="pirata-rd-office" name="licenca-office" class="radio" value="0" onclick="desativaSerialOffice()">
                <label for="pirata-rd-office"><span></span>Sem licença</label>
                <input type="radio" id="digital-rd-office" name="licenca-office" class="radio" value="1" onclick="desativaSerialOffice()">
                <label for="digital-rd-office"><span></span>Licença digital</label>
                <input type="radio" id="serial-rd-office" name="licenca-office" class="radio" value="serial" onclick="liberaSerialOffice()">
                <label for="serial-rd-office"><span></span>Serial:
                <input id="serial-office" class="input trim" type="text" maxlength="29" name="serial-office" disabled placeholder="xxxxx-xxxxx-xxxxx-xxxxx-xxxxx" style="width:420px" onkeyup="applyMasks()"></label>
            </div>
        `;
    } else if (str1 === 'Free') {
        conteudo = `
            <div id="b-line-office-2" class="b-line"><label class="label" for="nome-free">Nome:</label><input id="nome-free" class="input openBox" type="text" name="nome-office" placeholder="Escolha o pacote" required  style="width:190px"></div>
            <div id="suggestions-nome-free" class="suggestions-box nome-office free">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-office-4" class="b-line"><label class="label" for="ver-free">Versão:</label><input id="ver-free" class="input openBox" type="text" name="ver-office" placeholder="Escolha o pacote" required disabled style="width:190px"></div>
            <div id="suggestions-ver-free" class="suggestions-box ver-office free">
            </div>
            <input id="hidden-office" name="hidden-office" type="hidden" value="">
            <input id="hidden-id-assoc-office" name="hidden-id-assoc-office" type="hidden" value="">
        `;
    }
    linha.innerHTML = conteudo;
}

function liberarCampo2(str1) {
    if (str1 === 'Office') {
        let campo = document.getElementById('ed-ms');
        campo.setAttribute('placeholder', 'Escolha a edição');
        campo.disabled = false;
        campo.value = '';
    }
    if (str1 === 'Free') {
        let campo = document.getElementById('ver-free');
        campo.setAttribute('placeholder', 'Escolha a versão');
        campo.disabled = false;
        campo.value = '';
    }
    document.getElementById('hidden-office').value = '';
}

function passarIdOffice(id) {
    let hiddenOffice = document.getElementById('hidden-office');
    if (hiddenOffice) {
        hiddenOffice.value = id;
    }
}

function liberaSerialOffice() {
    let serial = document.getElementById('serial-office');
    serial.disabled = false;
}

function desativaSerialOffice() {
    let serial = document.getElementById('serial-office');
    serial.value = '';
    serial.disabled = true;
}