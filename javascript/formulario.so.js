function formularioSO(str1) {
    let linha = document.getElementById("formulario-so-1");
    let conteudo = '';
    console.log(str1);
    if (str1 === 'Windows') {
        conteudo = `
            <div id="b-line-so-2" class="b-line"><label class="label" for="ver-so">Versão:</label><input id="ver-so" class="input" type="text" name="ver-so" placeholder="Escolha uma versão" required readonly style="width:190px"></div>
            <div id="suggestions-ver-so" class="suggestions-box ver-so">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-so-3" class="b-line"><label class="label" for="ed-so">Edição:</label><input id="ed-so" class="input" type="text" name="ed-so" placeholder="Escolha uma edição" required readonly style="width:190px"></div>
            <div id="suggestions-ed-so" class="suggestions-box ed-so">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-so-4" class="b-line"><label class="label" for="serial-so">Serial:</label><input id="serial-so" class="input" type="text" name="serial-so" placeholder="Escolha uma versão" required readonly style="width:290px"></div>
            <div id="h-spacer"></div>
            <div id="b-line-so-5" class="b-line"><label class="label" for="user-so">Usuário:</label><input id="user-so" class="input" type="text" name="user-so" placeholder="Usuário" required readonly style="width:190px"></div>
            <div id="h-spacer"></div>
            <div id="b-line-so-5" class="b-line"><label class="label" for="pw-so">Senha:</label><input id="pw-so" class="input" type="text" name="pw-so" placeholder="Senha" required readonly style="width:190px"></div>

        `;
    } else if (str1 === 'Linux') {
        conteudo = `
            <div id="b-line-so-2" class="b-line"><label class="label" for="distro-so">Distribuição:</label><input id="distro-so" class="input" type="text" name="distro-so" placeholder="Escolha uma distribuição" required readonly style="width:190px"></div>
            <div id="suggestions-distro-so" class="suggestions-box distro-so">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-so-2" class="b-line"><label class="label" for="ver-so">Versão:</label><input id="ver-so" class="input" type="text" name="ver-so" placeholder="Escolha uma versão" required readonly style="width:190px"></div>
            <div id="suggestions-ver-so" class="suggestions-box ver-so">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-so-3" class="b-line"><label class="label" for="ed-so">Interface:</label><input id="ed-so" class="input" type="text" name="ed-so" placeholder="Escolha uma edição" required readonly style="width:190px"></div>
            <div id="suggestions-ed-so" class="suggestions-box ed-so">
            </div>
            <div id="h-spacer"></div>
        `;
    }
    linha.innerHTML = conteudo;
}