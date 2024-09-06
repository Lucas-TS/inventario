function formularioSO(str1) {
    let linha = document.getElementById("formulario-so-1");
    let conteudo = '';
    if (str1 === 'Windows') {
        conteudo = `
            <div id="b-line-so-2" class="b-line"><label class="label" for="ver-so">Versão:</label><input id="ver-win" class="input openBox" type="text" name="ver-so" placeholder="Escolha a versão" required  style="width:190px"></div>
            <div id="suggestions-ver-win" class="suggestions-box ver-so win">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-so-3" class="b-line oculto"><label class="label" for="ed-so">Edição:</label><input id="ed-win" class="input openBox" type="text" name="ed-so" placeholder="Escolha a versão" required disabled style="width:190px"></div>
            <div id="suggestions-ed-win" class="suggestions-box ed-so win">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-so-4" class="b-line oculto">
                <span class="label">Arquitetura:</span>
                <input type="radio" id="x86-win" name="arq-so" class="radio" value="x86">
                <label for="x86"><span></span>32-bits</label>
                <input type="radio" id="x64-win" name="arq-so" class="radio" value="x64">
                <label for="x64"><span></span>64-bits</label>
            </div>
            <input id="hidden-os" name="hidden-os" type="hidden" value="">
            <div id="h-spacer"></div>
            <div id="b-line-so-5" class="b-line"><label class="label" for="serial-win">Serial:</label><input id="serial-so" class="input" type="text" maxlength="29" name="serial-so" placeholder="xxxxx-xxxxx-xxxxx-xxxxx-xxxxx" style="width:420px" onkeyup="applyMasks()"></div>
            <div id="h-spacer" style="flex-basis: 100%;"></div>
            <div id="b-line-so-6" class="b-line"><label class="label" for="user-win">Usuário:</label><input id="user-so" class="input" type="text" name="user-so" placeholder="Usuário" required style="width:190px"></div>
            <div id="h-spacer"></div>
            <div id="b-line-so-7" class="b-line"><label class="label" for="pw-win">Senha:</label><input id="pw-so" class="input" type="text" name="pw-so" placeholder="Senha" required style="width:190px"></div>

        `;
    } else if (str1 === 'Linux') {
        conteudo = `
            <div id="b-line-so-2" class="b-line"><label class="label" for="distro-so">Distribuição:</label><input id="distro-linux" class="input openBox" type="text" name="distro-so" placeholder="Escolha a distribuição" required style="width:190px"></div>
            <div id="suggestions-distro-linux" class="suggestions-box distro-so linux">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-so-3" class="b-line oculto"><label class="label" for="ver-so">Versão:</label><input id="ver-linux" class="input openBox" type="text" name="ver-so" placeholder="Escolha a distribuição" required disabled style="width:190px"></div>
            <div id="suggestions-ver-linux" class="suggestions-box ver-so linux">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-so-4" class="b-line oculto"><label class="label" for="if-so">Interface:</label><input id="if-linux" class="input openBox" type="text" name="if-so" placeholder="Escolha a distribuição" required disabled style="width:190px"></div>
            <div id="suggestions-if-linux" class="suggestions-box if-so linux">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-so-4" class="b-line oculto">
                <span class="label">Arquitetura:</span>
                <input type="radio" id="x86-linux" name="arq-so" class="radio" value="x86">
                <label for="x86"><span></span>32-bits</label>
                <input type="radio" id="x64-linux" name="arq-so" class="radio" value="x64">
                <label for="x64"><span></span>64-bits</label>
            </div>
            <input id="hidden-os" name="hidden-os" type="hidden" value="">
            <div id="h-spacer" style="flex-basis: 100%;"></div>
            <div id="b-line-so-5" class="b-line"><label class="label" for="user-so">Usuário:</label><input id="user-linux" class="input" type="text" name="user-so" placeholder="Usuário" required  style="width:190px"></div>
            <div id="h-spacer"></div>
            <div id="b-line-so-6" class="b-line"><label class="label" for="pw-so">Senha:</label><input id="pw-linux" class="input" type="text" name="pw-so" placeholder="Senha" required  style="width:190px"></div>
            
        `;
    }
    linha.innerHTML = conteudo;

    // Adiciona máscara e transforma em caixa alta
    let serialInput = document.getElementById('serial-so');
    if (serialInput) {
        serialInput.addEventListener('input', function (e) {
            let value = e.target.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
            let formattedValue = value.match(/.{1,5}/g)?.join('-') || '';
            e.target.value = formattedValue;
        });
    }
}

function mostrarCampo2(str1) {
    let campo2;

    if (str1.startsWith('Linux ')) {
        const campo0 = document.getElementById(`ver-linux`);
        campo0.removeAttribute('disabled');
        campo0.setAttribute('placeholder', 'Escolha a versão');
        const campo1 = document.getElementById(`if-linux`);
        campo1.setAttribute('placeholder', 'Escolha a versão');
        const versao = document.getElementById(`b-line-so-3`);
        versao.classList.remove('oculto');
        campo2 = `ver-linux`;
    }
    if (str1.startsWith('Windows ')) {
        const campo0 = document.getElementById(`ed-win`);
        campo0.removeAttribute('disabled');
        campo0.setAttribute('placeholder', 'Escolha a edição');
        const versao = document.getElementById(`b-line-so-3`);
        versao.classList.remove('oculto');
        campo2 = `ed-win`;
    }
    showSuggestions('', campo2);
}