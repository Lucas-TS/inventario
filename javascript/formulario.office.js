function formularioOffice(str1) {
    let linha = document.getElementById("formulario-office-1");
    let conteudo = '';
    if (str1 === 'Office') {
        conteudo = `
            <div id="b-line-office-2" class="b-line"><label class="label" for="ver-office">Versão:</label><input id="ver-ms" class="input openBox" type="text" name="ver-office" placeholder="Escolha a versão" required  style="width:190px"></div>
            <div id="suggestions-ver-ms" class="suggestions-box ver-office ms">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-office-3" class="b-line"><label class="label" for="ed-office">Edição:</label><input id="ed-ms" class="input openBox" type="text" name="ed-office" placeholder="Escolha a versão" required disabled style="width:190px"></div>
            <div id="suggestions-ed-ms" class="suggestions-box ed-office ms">
            </div>
            <input id="hidden-office" name="hidden-office" type="hidden" value="">
            <div id="h-spacer"></div>
            <div id="b-line-office-4" class="b-line"><label class="label" for="serial-office">Serial:</label><input id="serial-ms" class="input" type="text" maxlength="29" name="serial-office" placeholder="xxxxx-xxxxx-xxxxx-xxxxx-xxxxx" style="width:420px" onkeyup="applyMasks()"></div>
        `;
    } else if (str1 === 'Free') {
        conteudo = `
            <div id="b-line-office-2" class="b-line"><label class="label" for="nome-office">Nome:</label><input id="nome-free" class="input openBox" type="text" name="nome-office" placeholder="Escolha o pacote" required  style="width:190px"></div>
            <div id="suggestions-nome-free" class="suggestions-box nome-office free">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-office-4" class="b-line"><label class="label" for="ver-office">Versão:</label><input id="ver-free" class="input openBox" type="text" name="ver-office" placeholder="Escolha o pacote" required disabled style="width:190px"></div>
            <div id="suggestions-ver-free" class="suggestions-box ver-office free">
            </div>
            <input id="hidden-office" name="hidden-office" type="hidden" value="">
        `;
    }
    linha.innerHTML = conteudo;

    // Adiciona máscara e transforma em caixa alta
    let serialInput = document.getElementById('serial-ms');
    if (serialInput) {
        serialInput.addEventListener('input', function (e) {
            let value = e.target.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
            let formattedValue = value.match(/.{1,5}/g)?.join('-') || '';
            e.target.value = formattedValue;
        });
    }
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