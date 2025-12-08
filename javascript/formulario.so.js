function formularioSO(str1) {
    let linha = document.getElementById("formulario-so-1");
    let conteudo = '';
    if (str1 === 'Windows') {
        conteudo = `
            <div id="b-line-so-2" class="b-line"><label class="label" for="ver-win">Versão:</label><input id="ver-win" class="input openBox" type="text" name="ver-so" placeholder="Escolha a versão" required  style="width:190px"></div>
            <div id="suggestions-ver-win" class="suggestions-box ver-so win">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-so-3" class="b-line display-none"><label class="label" for="ed-win">Edição:</label><input id="ed-win" class="input openBox" type="text" name="ed-so" placeholder="Escolha a versão" required style="width:190px"></div>
            <div id="suggestions-ed-win" class="suggestions-box ed-so win">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-so-5" class="b-line display-none">
                <span class="label">Arquitetura:</span>
                <input type="radio" id="x86-win" name="arq-so" class="radio" required value="x86">
                <label for="x86-win"><span></span>32-bits</label>
                <input type="radio" id="x64-win" name="arq-so" class="radio" value="x64">
                <label for="x64-win"><span></span>64-bits</label>
            </div>
            <input id="hidden-so" name="hidden-so" type="hidden" value="">
            <input id="hidden-id-assoc-so" name="hidden-id-assoc-so" type="hidden" value="">
            <div id="h-spacer" style="flex-basis: 100%;"></div>
            <div id="b-line-so-4" class="b-line">
                <input type="radio" id="pirata-rd-win" name="licenca" class="radio" required value="0" onclick="desativaSerial()">
                <label for="pirata-rd-win"><span></span>Sem licença</label>
                <input type="radio" id="digital-rd-win" name="licenca" class="radio" value="1" onclick="desativaSerial()">
                <label for="digital-rd-win"><span></span>Licença digital</label>
                <input type="radio" id="serial-rd-win" name="licenca" class="radio" value="serial" onclick="liberaSerial()">
                <label for="serial-rd-win"><span></span>Serial:
                <input id="serial-so" class="input trim" type="text" maxlength="29" name="serial-so" disabled placeholder="xxxxx-xxxxx-xxxxx-xxxxx-xxxxx" style="width:420px"></label>
            </div>
            <div id="h-spacer" style="flex-basis: 100%;"></div>
            <div id="b-line-so-6" class="b-line"><label class="label" for="user-win">Usuário:</label><input id="user-win" class="input" type="text" name="user-so" placeholder="Usuário" required style="width:190px"></div>
            <div id="h-spacer"></div>
            <div id="b-line-so-7" class="b-line"><label class="label" for="pw-win">Senha:</label><input id="pw-win" class="input trim" type="text" name="pw-so" placeholder="Senha" style="width:190px"></div>
        `;
    } else if (str1 === 'Linux') {
        conteudo = `
            <div id="b-line-so-2" class="b-line"><label class="label" for="distro-linux">Distribuição:</label><input id="distro-linux" class="input openBox" type="text" name="distro-so" placeholder="Escolha a distribuição" required style="width:190px"></div>
            <div id="suggestions-distro-linux" class="suggestions-box distro-so linux">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-so-3" class="b-line display-none"><label class="label" for="ver-linux">Versão:</label><input id="ver-linux" class="input openBox" type="text" name="ver-so" placeholder="Escolha a distribuição" required style="width:190px"></div>
            <div id="suggestions-ver-linux" class="suggestions-box ver-so linux">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-so-4" class="b-line display-none"><label class="label" for="if-linux">Interface:</label><input id="if-linux" class="input openBox" type="text" name="if-so" placeholder="Escolha a distribuição" required style="width:190px"></div>
            <div id="suggestions-if-linux" class="suggestions-box if-so linux">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-so-5" class="b-line display-none">
                <span class="label">Arquitetura:</span>
                <input type="radio" id="x86-linux" name="arq-so" class="radio" required value="x86">
                <label for="x86-linux"><span></span>32-bits</label>
                <input type="radio" id="x64-linux" name="arq-so" class="radio" value="x64">
                <label for="x64-linux"><span></span>64-bits</label>
            </div>
            <input id="hidden-so" name="hidden-so" type="hidden" value="">
            <input id="hidden-id-assoc-so" name="hidden-id-assoc-so" type="hidden" value="">
            <div id="h-spacer" style="flex-basis: 100%;"></div>
            <div id="b-line-so-6" class="b-line"><label class="label" for="user-linux">Usuário:</label><input id="user-linux" class="input" type="text" name="user-so" placeholder="Usuário" required style="width:190px"></div>
            <div id="h-spacer"></div>
            <div id="b-line-so-7" class="b-line"><label class="label" for="pw-linux">Senha:</label><input id="pw-linux" class="input" type="text" name="pw-so" placeholder="Senha" style="width:190px"></div>
        `;
    }
    linha.innerHTML = conteudo;
}

function mostrarCampo2(str1) {
    let campo2 = '';

    let versao = document.getElementById('b-line-so-3');
    versao.classList.remove('display-none');
    document.querySelector('#b-line-so-3 input').value = '';
    let arq = document.getElementById('b-line-so-5');
    arq.classList.add('display-none');
    let x64 = document.querySelector('[id^="x64"]');
    x64.checked = false;
    let x86 = document.querySelector('[id^="x86"]');
    x86.checked = false;

    document.querySelector(`#hidden-so`).value = '';

    if (str1.startsWith('Linux ')) {
        let interface = document.getElementById('b-line-so-4');
        interface.classList.add('display-none');
        document.querySelector('#b-line-so-4 input').value = '';
        document.querySelector('#b-line-so-3 input').placeholder = 'Escolha a versão';
        campo2 = 'ver-linux';
    }

    if (str1.startsWith('Windows ')) {
        document.querySelector('#b-line-so-3 input').placeholder = 'Escolha a edição';
        campo2 = 'ed-win';
    }

    showSuggestions('', campo2);
}


function mostrarCampo3(str1) {
    let campo2 = '';

    if (str1.startsWith('Linux ')) {
        let campo0 = document.getElementById(`if-linux`);
        campo0.setAttribute('placeholder', 'Escolha a interface');

        let interface = document.getElementById(`b-line-so-4`);
        interface.classList.remove('display-none');
        document.querySelector('#b-line-so-4 input').value = '';

        let arq = document.getElementById(`b-line-so-5`);
        arq.classList.add('display-none');
        let x64 = document.querySelector('[id^="x64"]');
        x64.checked = false;
        let x86 = document.querySelector('[id^="x86"]');
        x86.checked = false;

        document.querySelector(`#hidden-so`).value = '';

        campo2 = `if-linux`;
    }
    showSuggestions('', campo2);
}

async function mostrarArq(so4) {
    let so = '';

    document.querySelector(`#hidden-so`).value = '';

    let so1 = document.querySelector('input[name="so"]:checked').value;
    if (so1 === 'Linux') {
        let so2 = document.getElementById(`distro-linux`).value;
        let so3 = document.getElementById(`ver-linux`).value;
        so = `${so1} ${so2} ${so3} ${so4}`;
    } else if (so1 === 'Windows') {
        let so2 = document.getElementById(`ver-win`).value;
        so = `${so1} ${so2} ${so4}`;
    }

    try {
        const response = await fetch(`./includes/auto_complete.php?so=${so}`);
        if (!response.ok) throw new Error("Erro na requisição.");

        const data = await response.json();

        let hasX64 = data.hasOwnProperty('x64');
        let x64 = document.querySelector('[id^="x64"]');
        let labelX64 = document.querySelector('label[for="' + x64.id + '"]');

        let hasX86 = data.hasOwnProperty('x86');
        let x86 = document.querySelector('[id^="x86"]');
        let labelX86 = document.querySelector('label[for="' + x86.id + '"]');

        let div = document.getElementById(`b-line-so-5`);
        div.classList.remove('display-none');

        let hiddenSO = document.getElementById('hidden-so');

        if (hasX86 && hasX64) {
            x86.disabled = false;
            x86.checked = false;
            x86.classList.remove('display-none');
            labelX86.classList.remove('display-none');

            x86.onclick = function() {
                passarIdSo(data['x86']);
            };

            x64.disabled = false;
            x64.checked = false;
            x64.classList.remove('display-none');
            labelX64.classList.remove('display-none');

            x64.onclick = function() {
                passarIdSo(data['x64']);
            };

            hiddenSO.value = '';
        } else if (hasX86) {
            x86.disabled = true;
            x86.checked = true;
            x86.classList.remove('display-none');
            labelX86.classList.remove('display-none');

            x64.disabled = true;
            x64.classList.add('display-none');
            labelX64.classList.add('display-none');

            passarIdSo(data['x86']);
        } else if (hasX64) {
            x86.disabled = true;
            x86.classList.add('display-none');
            labelX86.classList.add('display-none');

            x64.disabled = true;
            x64.checked = true;
            x64.classList.remove('display-none');
            labelX64.classList.remove('display-none');

            passarIdSo(data['x64']);
        } else {
            console.log('Nenhum resultado recebido');
        }
    } catch (error) {
        console.error("Erro na requisição fetch:", error.message);
    }
}

function passarIdSo(id) {
    let hiddenSo = document.getElementById('hidden-so');
    if (hiddenSo) {
        hiddenSo.value = id;
    }
}

function liberaSerial() {
    let serial = document.getElementById('serial-so');
    serial.disabled = false;
}

function desativaSerial() {
    let serial = document.getElementById('serial-so');
    serial.value = '';
    serial.disabled = true;
}