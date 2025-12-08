function selecionaOutro() {
    let soAdd = document.getElementById('outro-add-so');
    let soEdit = document.getElementById('outro-edit-so');

    if (soAdd) {
        //soAdd.required = true;
        //soAdd.disabled = false;
        formularioAddSO('Outro');
    } else if (soEdit) {
        //soEdit.required = true;
        //soEdit.disabled = false;
        formularioEditSO('Outro');
    } else {
        console.log("Nenhum campo encontrado");
    }
}

function selecionaLinux() {
    let soAdd = document.getElementById('add-linux');
    let soEdit = document.getElementById('edit-linux');

    if (soAdd) {
        //soAdd.required = false;
        //soAdd.disabled = true;
        formularioAddSO('Linux');
    } else if (soEdit) {
        //soEdit.required = false;
        //soEdit.disabled = true;
        formularioEditSO('Linux');
    } else {
        console.log("Nenhum campo encontrado");
    }
}

function selecionaWindows() {
    let soAdd = document.getElementById('add-windows');
    let soEdit = document.getElementById('edit-windows');

    if (soAdd) {
        //soAdd.required = false;
        //soAdd.disabled = true;
        formularioAddSO('Windows');
    } else if (soEdit) {
        //soEdit.required = false;
        //soEdit.disabled = true;
        formularioEditSO('Windows');
    } else {
        console.log("Nenhum campo encontrado");
    }
}

function formularioAddSO(kernel) {
    let linha = document.getElementById("linha-2");
    let conteudo = '';
    if (kernel === 'Windows') {
        conteudo = `
            <div id="h-line-add-so-2" class="h-line">Informações do sistema:</div>
            <div id="b-line-add-so-2" class="b-line" style="flex-basis:100%">
                <label class="label" for="ver-add-so">Versão:</label>
                <input id="ver-add-so" class="input" type="text" name="ver-add-so" placeholder="Digite a versão" required  style="width:100%">
            </div>
            <div id="b-line-add-so-3" class="b-line" style="flex-basis:100%">
                <label class="label" for="ed-add-so">Edição:</label>
                <input id="ed-add-so" class="input" type="text" name="ed-add-so" placeholder="Digite o nome da edição" required style="width:100%">    
            </div>
            <div id="b-line-add-so-4" class="b-line" style="flex-basis:100%">
                <span class="label">Arquitetura:</span>
                <input type="radio" id="x86" name="arq-add-so" required class="radio" value="x86">
                <label for="x86"><span></span>x86</label>
                <input type="radio" id="x64" name="arq-add-so" class="radio" value="x64">
                <label for="x64"><span></span>x64</label>
            </div>
        `;
    } else if (kernel === 'Linux') {
        conteudo = `
            <div id="h-line-add-so-2" class="h-line">Informações do sistema:</div>
            <div id="b-line-add-so-2" class="b-line" style="flex-basis:100%">
                <label class="label" for="dev-add-so">Desenvolvedor:</label>
                <input id="dev-add-so" class="input" type="text" name="dev-so" placeholder="Digite o nome do desenvolvedor" required style="width:100%">
            </div>
            <div id="b-line-add-so-3" class="b-line" style="flex-basis:100%">
                <label class="label" for="distro-add-so">Distribuição:</label>
                <input id="distro-add-so" class="input" type="text" name="distro-add-so" placeholder="Digite o nome da distribuição" required style="width:100%">
            </div>
            <div id="b-line-add-so-4" class="b-line" style="flex-basis:100%">
                <label class="label" for="ver-add-so">Versão:</label>
                <input id="ver-add-so" class="input" type="text" name="ver-add-so" placeholder="Digite a versão" required style="width:100%">
            </div>
            <div id="b-line-add-so-5" class="b-line" style="flex-basis:100%">
                <label class="label" for="ed-add-so">Interface:</label>
                <input id="ed-add-so" class="input" type="text" name="ed-add-so" placeholder="Digite o nome da interface" required style="width:100%">
            </div>
            <div id="b-line-add-so-6" class="b-line" style="flex-basis:100%">
                <span class="label">Arquitetura:</span>
                <input type="radio" id="x86" name="arq-add-so" required class="radio" value="x86">
                <label for="x86"><span></span>x86</label>
                <input type="radio" id="x64" name="arq-add-so" class="radio" value="x64">
                <label for="x64"><span></span>x64</label>
            </div>
        `;
    } else if (kernel === 'Outro') {
        conteudo = `
            <div id="h-line-add-so-2" class="h-line">Informações do sistema:</div>
            <div id="b-line-add-so-2" class="b-line" style="flex-basis:100%">
                <label class="label" for="dev-add-so">Desenvolvedor:</label>
                <input id="dev-add-so" class="input" type="text" name="dev-add-so" placeholder="Digite o nome do desenvolvedor" required style="width:100%">
            </div>
            <div id="b-line-add-so-3" class="b-line" style="flex-basis:100%">
                <label class="label" for="distro-add-so">Distribuição:</label>
                <input id="distro-add-so" class="input" type="text" name="distro-add-so" placeholder="Digite o nome da distribuição (opcional)" style="width:100%">
            </div>
            <div id="b-line-add-so-4" class="b-line" style="flex-basis:100%">
                <label class="label" for="ver-add-so">Versão:</label>
                <input id="ver-add-so" class="input" type="text" name="ver-add-so" placeholder="Digite a versão" required style="width:100%">
            </div>
            <div id="b-line-add-so-5" class="b-line" style="flex-basis:100%">
                <label class="label" for="ed-add-so">Edição/Interface:</label>
                <input id="ed-add-so" class="input" type="text" name="ed-add-so" placeholder="Digite o nome da edição ou da interface" required style="width:100%">
            </div>
            <div id="b-line-add-so-6" class="b-line" style="flex-basis:100%">
                <span class="label">Arquitetura:</span>
                <input type="radio" id="x86" name="arq-add-so" required class="radio" value="x86">
                <label for="x86"><span></span>x86</label>
                <input type="radio" id="x64" name="arq-add-so" class="radio" value="x64">
                <label for="x64"><span></span>x64</label>
            </div>
        `;
    }
    linha.innerHTML = conteudo;
}

function formularioEditSO(kernel) {

    let linha = document.getElementById("linha-3");
    let conteudo = '';
    if (kernel === 'Windows') {
        conteudo = `
            <div id="h-line-edit-so-3" class="h-line">Informações do sistema:</div>
            <div id="b-line-edit-so-4" class="b-line" style="flex-basis:100%">
                <label class="label" for="ver-edit-so">Versão:</label>
                <input id="ver-edit-so" class="input" type="text" name="ver-edit-so" placeholder="Digite a versão" required  style="width:100%">
            </div>
            <div id="b-line-edit-so-5" class="b-line" style="flex-basis:100%">
                <label class="label" for="ed-edit-so">Edição:</label>
                <input id="ed-edit-so" class="input" type="text" name="ed-edit-so" placeholder="Digite o nome da edição" required style="width:100%">    
            </div>
            <div id="b-line-edit-so-6" class="b-line" style="flex-basis:100%">
                <span class="label">Arquitetura:</span>
                <input type="radio" id="x86" name="arq-edit-so" required class="radio" value="x86">
                <label for="x86"><span></span>x86</label>
                <input type="radio" id="x64" name="arq-edit-so" class="radio" value="x64">
                <label for="x64"><span></span>x64</label>
            </div>
        `;
    } else if (kernel === 'Linux') {
        conteudo = `
            <div id="h-line-edit-so-3" class="h-line">Informações do sistema:</div>
            <div id="b-line-so-4" class="b-line" style="flex-basis:100%">
                <label class="label" for="dev-edit-so">Desenvolvedor:</label>
                <input id="dev-edit-so" class="input" type="text" name="dev-so" placeholder="Digite o nome do desenvolvedor" required style="width:100%">
            </div>
            <div id="b-line-edit-so-5" class="b-line" style="flex-basis:100%">
                <label class="label" for="distro-edit-so">Distribuição:</label>
                <input id="distro-edit-so" class="input" type="text" name="distro-edit-so" placeholder="Digite o nome da distribuição" required style="width:100%">
            </div>
            <div id="b-line-edit-so-6" class="b-line" style="flex-basis:100%">
                <label class="label" for="ver-edit-so">Versão:</label>
                <input id="ver-edit-so" class="input" type="text" name="ver-edit-so" placeholder="Digite a versão" required style="width:100%">
            </div>
            <div id="b-line-edit-so-7" class="b-line" style="flex-basis:100%">
                <label class="label" for="ed-edit-so">Interface:</label>
                <input id="ed-edit-so" class="input" type="text" name="ed-edit-so" placeholder="Digite o nome da interface" required style="width:100%">
            </div>
            <div id="b-line-edit-so-8" class="b-line" style="flex-basis:100%">
                <span class="label">Arquitetura:</span>
                <input type="radio" id="x86" name="arq-edit-so" required class="radio" value="x86">
                <label for="x86"><span></span>x86</label>
                <input type="radio" id="x64" name="arq-edit-so" class="radio" value="x64">
                <label for="x64"><span></span>x64</label>
            </div>
        `;
    } else if (kernel === 'Outro') {
        conteudo = `
            <div id="h-line-edit-so-3" class="h-line">Informações do sistema:</div>
            <div id="b-line-so-4" class="b-line" style="flex-basis:100%">
                <label class="label" for="dev-edit-so">Desenvolvedor:</label>
                <input id="dev-edit-so" class="input" type="text" name="dev-edit-so" placeholder="Digite o nome do desenvolvedor" required style="width:100%">
            </div>
            <div id="b-line-edit-so-5" class="b-line" style="flex-basis:100%">
                <label class="label" for="distro-edit-so">Distribuição:</label>
                <input id="distro-edit-so" class="input" type="text" name="distro-edit-so" placeholder="Digite o nome da distribuição (opcional)" style="width:100%">
            </div>
            <div id="b-line-edit-so-6" class="b-line" style="flex-basis:100%">
                <label class="label" for="ver-edit-so">Versão:</label>
                <input id="ver-edit-so" class="input" type="text" name="ver-edit-so" placeholder="Digite a versão" required style="width:100%">
            </div>
            <div id="b-line-edit-so-7" class="b-line" style="flex-basis:100%">
                <label class="label" for="ed-edit-so">Edição/Interface:</label>
                <input id="ed-edit-so" class="input" type="text" name="ed-edit-so" placeholder="Digite o nome da edição ou da interface" required style="width:100%">
            </div>
            <div id="b-line-edit-so-8" class="b-line" style="flex-basis:100%">
                <span class="label">Arquitetura:</span>
                <input type="radio" id="x86" name="arq-edit-so" required class="radio" value="x86">
                <label for="x86"><span></span>x86</label>
                <input type="radio" id="x64" name="arq-edit-so" class="radio" value="x64">
                <label for="x64"><span></span>x64</label>
            </div>
        `;
    }
    linha.innerHTML = conteudo;
}

async function insertSO(event) {
    event.preventDefault(); // Previne o comportamento padrão do formulário

    let funcao = 'inserir';
    // Capturar valor do campo de texto ou definir como nulo
    
    let radios = document.getElementsByName('knl-add-so');
    let radios2 = document.getElementsByName('arq-add-so');

    let devElement = document.getElementById('dev-add-so');
    let dev = devElement ? devElement.value : 'Microsoft';

    let ed = document.getElementById('ed-add-so').value;

    let distroElement = document.getElementById('distro-add-so');
    let distro = distroElement ? distroElement.value : null;

    let versao = document.getElementById('ver-add-so').value;
    let arq;

    for (let i = 0; i < radios.length; i++) {
        if (radios2[i].checked) {
            arq = radios2[i].value;
            break;
        }
    }

    let nome;

    for (let i = 0; i < radios.length; i++) {
        if (radios[i].checked) {
            nome = radios[i].value;
            if (nome === 'Outro') {
                var outroElement = document.getElementById('outro-add-so');
                nome = outroElement ? outroElement.value : ''; // Pega o valor do input 'outro-add-so' se existir
            }
            break;
        }
    }

    if (nome === 'Windows') {
        dev = 'Microsoft';
    }

    let formData = {
        funcao: funcao,
        dev: dev,
        nome: nome,
        distro: distro,
        ed: ed,
        versao: versao,
        arq: arq,
    };

    try {
        let response = await fetch('./includes/so.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=UTF-8'
            },
            body: JSON.stringify(formData)
        });

        if (!response.ok) {
            if (response.status === 409) { // Conflito
                throw new Error('Registro já existe.');
            } else {
                throw new Error('Erro ao inserir o sistema operacional.');
            }
        } 

        let overlay = document.getElementById('overlay');
        
        let mensagem = `
        <div id="add_so" class="bloco-overlay">
            <div class="header">
                <span>Adicionar Sistema Operacional</span>
                <div id="botoes">
                    <div id="b-line-header-1" class="b-line">
                        <div id="fecharOverlay" class="flex-center icon-button margin-bottom rotated-icon">
                            <a title="Fechar" href="#" onclick="closeOverlay()">${addSVG}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="linha-1" class="linha fim">`;
            if (nome === 'Windows') {
                mensagem += `<div id="h-line-add-so-1" class="h-line centralizado">${dev} ${nome} ${versao} ${ed} ${arq} inserido com sucesso!</div>`
            } else {
                mensagem += `<div id="h-line-add-so-1" class="h-line centralizado">${dev} ${nome} ${distro} ${versao} ${ed} ${arq} inserido com sucesso!</div>`
            }
        mensagem += `
            </div>
            <div id="linha-2" class="linha fim centralizado">
                <div id="b-line-1" class="b-line">
                    <div id="okOverlay" class="large-button adjust-position flex-center">
                        <a title="Ok" href="#" onclick="closeOverlay()">${okSVG}</a>
                    </div>
                </div>
            </div>
        </div>
        `;
        overlay.innerHTML = mensagem;

        atualizarTabela();

        // Fechar o overlay após a inserção com um retardo de 5 segundos
        closeTimeout = setTimeout(function () {
            closeOverlay();
        }, 5000); // 5000 milissegundos = 5 segundos
    } catch (error) {
        alert(error.message); // Exibe um alert com a mensagem de erro
    }
}

async function editarSoOverlay(id, arquivo) {
    await exibirOverlay(arquivo); // Espera a execução e finalização de exibirOverlay
    let funcao = 'buscar';

    let formData = {
        funcao: funcao,
        id: id,
    };

    try {
        let response = await fetch('./includes/so.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=UTF-8'
            },
            body: JSON.stringify(formData)
        });
        if (!response.ok) {
            throw new Error('Erro ao buscar os dados.');
        }
        let data = await response.json(); // Converte a resposta para JSON
        //Preenche os campos do formulário com os dados retornados

        if (data.nome === 'Windows') {
            selecionaWindows();
            document.getElementById('edit-windows').checked = true;
        } else if (data.nome === 'Linux') {
            selecionaLinux();
            document.getElementById('edit-linux').checked = true;
            document.getElementById('dev-edit-so').value = data.dev
            document.getElementById('distro-edit-so').value = data.distribuicao
        } else {
            selecionaOutro();
            document.getElementById('outro').checked = true;
            document.getElementById('dev-edit-so').value = data.dev
            document.getElementById('distro-edit-so').value = data.distribuicao
        }

        document.getElementById('id-edit-so').value = data.id;
        document.getElementById('ver-edit-so').value = data.versao;
        document.getElementById('ed-edit-so').value = data.edicao;
        let arq = data.arquitetura;
        if (arq == 'x64') {
            document.getElementById('x64').checked = true;
        }
        if (arq == 'x86') {
            document.getElementById('x86').checked = true;
        }
        if (data.ativo === 1) {
            document.getElementById('ativo-edit-so').checked = true;
        }
        // Continue para outros campos conforme necessário
    } catch (error) {
        console.error(error.message);
    }
}

async function editarSo(event) {
    event.preventDefault(); // Previne o comportamento padrão do formulário

    // Capturar valor do campo de texto ou definir como nulo
    let funcao = 'editar';
    let id = document.getElementById('id-edit-so').value;
    let ativo = document.getElementById('ativo-edit-so').checked ? '1' : '0';

    let radios = document.getElementsByName('knl-edit-so');
    let nome;
    let dev;
    let distro;

    for (let i = 0; i < radios.length; i++) {
        if (radios[i].checked) {
            nome = radios[i].value;
            break;
        }
    }

    if (nome === 'Windows') {
        dev = 'Microsoft';
        distro = '';
    } else {
        dev = document.getElementById('dev-edit-so').value;
        distro = document.getElementById('distro-edit-so').value;
    }

    let versao = document.getElementById('ver-edit-so').value;
    let edicao = document.getElementById('ed-edit-so').value;
    let arq = document.getElementById('x64').checked ? 'x64' : 'x86';

    let formData = {
        funcao: funcao,
        id: id,
        nome: nome,
        dev: dev,
        distro: distro,
        arq: arq,
        versao: versao,
        edicao: edicao,
        ativo: ativo,
    };

    try {
        let response = await fetch('./includes/so.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=UTF-8'
            },
            body: JSON.stringify(formData)
        });

        if (!response.ok) {
            if (response.status === 409) {
                throw new Error('Erro ao atualizar os dados do sistema operacional.');
            }
        }

        let responseData = await response.json();
        let overlay = document.getElementById('overlay');
        overlay.innerHTML = `
        <div id="edit_so" class="bloco-overlay">
            <div class="header">
                <span>Editar Sistema Operacional</span>
                <div id="botoes">
                    <div id="b-line-header-1" class="b-line">
                        <div id="fecharOverlay" class="flex-center icon-button margin-bottom rotated-icon">
                            <a title="Fechar" href="#" onclick="closeOverlay()">${addSVG}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="linha-1" class="linha fim">
                <div id="h-line-edit-so-1" class="b-line centralizado">${responseData.mensagem}</div>
            </div>
            <div id="linha-2" class="linha fim centralizado">
                <div id="b-line-1" class="b-line">
                    <div id="okOverlay" class="large-button adjust-position flex-center">
                        <a title="Ok" href="#" onclick="closeOverlay()">${okSVG}</a>
                    </div>
                </div>
            </div>
        </div>
        `;

        atualizarTabela();
        // Fechar o overlay após a inserção com um retardo de 5 segundos
        closeTimeout = setTimeout(function () {
            closeOverlay();
        }, 5000); // 5000 milissegundos = 5 segundos
    } catch (error) {
        alert(error.message); // Exibe um alert com a mensagem de erro
    }
}