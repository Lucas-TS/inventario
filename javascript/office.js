function selecionaFree() {
    let officeAdd = document.getElementById('nome-add-office');
    let officeEdit = document.getElementById('nome-edit-office');

    if (officeAdd) {
        officeAdd.required = true;
        officeAdd.disabled = false;
        formularioAddOffice('Free');
    } else if (officeEdit) {
        officeEdit.required = true;
        officeEdit.disabled = false;
        formularioEditOffice('Free');
    } else {
        console.log("Nenhum campo encontrado");
    }
}

function selecionaOffice() {
    let officeAdd = document.getElementById('nome-add-office');
    let officeEdit = document.getElementById('nome-edit-office');

    if (officeAdd) {
        officeAdd.required = false;
        officeAdd.disabled = true;
        formularioAddOffice('Microsoft Office');
    } else if (officeEdit) {
        officeEdit.required = false;
        officeEdit.disabled = true;
        formularioEditOffice('Microsoft Office');
    } else {
        console.log("Nenhum campo encontrado");
    }
}

function formularioAddOffice(str1) {

    let linha = document.getElementById("linha-2");
    let conteudo = '';
    if (str1 === 'Microsoft Office') {
        conteudo = `
            <div id="h-line-add-office-2" class="h-line">Informações do pacote:</div>
            <div id="b-line-add-office-2" class="b-line" style="flex-basis:100%">
                <label class="label" for="ver-add-office">Versão:</label>
                <input id="ver-add-office" class="input" type="text" name="ver-add-office" placeholder="Digite a versão" required  style="width:100%">
            </div>
            <div id="b-line-add-office-3" class="b-line" style="flex-basis:100%">
                <label class="label" for="ed-add-office">Edição:</label>
                <input id="ed-add-office" class="input" type="text" name="ed-add-office" placeholder="Digite o nome da edição" required style="width:100%">    
            </div>
        `;
    } else if (str1 === 'Free') {
        conteudo = `
            <div id="h-line-add-office-2" class="h-line">Informações do sistema:</div>
            <div id="b-line-office-2" class="b-line" style="flex-basis:100%">
                <label class="label" for="dev-add-office">Desenvolvedor:</label>
                <input id="dev-add-office" class="input" type="text" name="dev-add-office" placeholder="Digite o nome do desenvolvedor" required style="width:100%">
            </div>
            <div id="b-line-office-3" class="b-line" style="flex-basis:100%">
                <label class="label" for="ver-add-office">Versão:</label>
                <input id="ver-add-office" class="input" type="text" name="ver-add-office" placeholder="Digite a versão" required style="width:100%">
            </div>
            <div id="b-line-office-4" class="b-line" style="flex-basis:100%">
                <label class="label" for="ed-add-office">Edição:</label>
                <input id="ed-add-office" class="input" type="text" name="ed-add-office" placeholder="Digite o nome da edição (opcional)" style="width:100%">
            </div>
        `;
    }
    linha.innerHTML = conteudo;
}

function formularioEditOffice(str1) {

    let linha = document.getElementById("linha-3");
    let conteudo = '';
    if (str1 === 'Microsoft Office') {
        conteudo = `
            <div id="h-line-edit-office-3" class="h-line">Informações do pacote:</div>
            <div id="b-line-edit-office-4" class="b-line" style="flex-basis:100%">
                <label class="label" for="ver-edit-office">Versão:</label>
                <input id="ver-edit-office" class="input" type="text" name="ver-edit-office" placeholder="Digite a versão" required  style="width:100%">
            </div>
            <div id="b-line-edit-office-5" class="b-line" style="flex-basis:100%">
                <label class="label" for="ed-edit-office">Edição:</label>
                <input id="ed-edit-office" class="input" type="text" name="ed-edit-office" placeholder="Digite o nome da edição" required style="width:100%">    
            </div>
        `;
    } else if (str1 === 'Free') {
        conteudo = `
            <div id="h-line-edit-office-3" class="h-line">Informações do sistema:</div>
            <div id="b-line-office-4" class="b-line" style="flex-basis:100%">
                <label class="label" for="dev-edit-office">Desenvolvedor:</label>
                <input id="dev-edit-office" class="input" type="text" name="dev-edit-office" placeholder="Digite o nome do desenvolvedor" required style="width:100%">
            </div>
            <div id="b-line-office-5" class="b-line" style="flex-basis:100%">
                <label class="label" for="ver-edit-office">Versão:</label>
                <input id="ver-edit-office" class="input" type="text" name="ver-edit-office" placeholder="Digite a versão" required style="width:100%">
            </div>
            <div id="b-line-office-6" class="b-line" style="flex-basis:100%">
                <label class="label" for="ed-edit-office">Edição:</label>
                <input id="ed-edit-office" class="input" type="text" name="ed-edit-office" placeholder="Digite o nome da edição (opcional)" style="width:100%">
            </div>
        `;
    }
    linha.innerHTML = conteudo;
}

async function insertOffice(event) {
    event.preventDefault(); // Previne o comportamento padrão do formulário

    let funcao = 'inserir';
    // Capturar valor do campo de texto ou definir como nulo

    let devElement = document.getElementById('dev-add-office');
    let dev = devElement ? devElement.value : 'Microsoft';

    let radioOffice = document.getElementById('office');
    let nome = radioOffice.checked ? 'Office' : document.getElementById('nome-add-office').value;

    let edElement = document.getElementById('ed-add-office');
    let ed = edElement ? edElement.value : null;
    if (ed === "") {
        ed = null;
    }

    let versao = document.getElementById('ver-add-office').value;

    let formData = {
        funcao: funcao,
        dev: dev,
        nome: nome,
        ed: ed,
        versao: versao,
    };

    try {
        let response = await fetch('./includes/office.php', {
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
                throw new Error('Erro ao inserir o pacote office.');
            }
        }

        let overlay = document.getElementById('overlay');
        
        let mensagem = `
        <div id="add_office" class="bloco-overlay">
            <div class="header">
                <span>Adicionar Pacote Office</span>
                <div id="botoes">
                    <div id="b-line-header-1" class="b-line">
                        <div id="fecharOverlay" class="flex-center icon-button margin-bottom rotated-icon">
                            <a title="Fechar" href="#" onclick="closeOverlay()">${addSVG}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="linha-1" class="linha fim">
                <div id="h-line-add-os-1" class="h-line centralizado">${dev} ${nome} ${versao} ${ed} inserido com sucesso!</div>
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

async function editarOfficeOverlay(id, arquivo) {
    await exibirOverlay(arquivo); // Espera a execução e finalização de exibirOverlay
    let funcao = 'buscar';

    let formData = {
        funcao: funcao,
        id: id,
    };

    try {
        let response = await fetch('./includes/office.php', {
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
        let tipo = data.dev + ' ' + data.nome

        if (tipo === 'Microsoft Office') {
            selecionaOffice();
            document.getElementById('office').checked = true;
        } else {
            selecionaFree();
            document.getElementById('free').checked = true;
            document.getElementById('nome-edit-office').value = data.nome
            document.getElementById('dev-edit-office').value = data.dev
        }

        document.getElementById('id-edit-office').value = data.id;
        document.getElementById('ver-edit-office').value = data.versao;
        document.getElementById('ed-edit-office').value = data.edicao;
        if (data.ativo === 1) {
            document.getElementById('ativo-edit-office').checked = true;
        }
        // Continue para outros campos conforme necessário
    } catch (error) {
        console.error(error.message);
    }
}

async function editarOffice(event) {
    event.preventDefault(); // Previne o comportamento padrão do formulário

    // Capturar valor do campo de texto ou definir como nulo
    let funcao = 'editar';
    let id = document.getElementById('id-edit-office').value;
    let ativo = document.getElementById('ativo-edit-office').checked ? '1' : '0';

    let radios = document.getElementsByName('knl-edit-office');
    let nome;
    let dev;

    for (let i = 0; i < radios.length; i++) {
        if (radios[i].checked) {
            nome = radios[i].value;
            break;
        }
    }

    if (nome === 'Office') {
        dev = 'Microsoft';

    } else {
        dev = document.getElementById('dev-edit-office').value;
        nome = document.getElementById('nome-edit-office').value;
    }

    let versao = document.getElementById('ver-edit-office').value;
    let edicao = document.getElementById('ed-edit-office').value;

    let formData = {
        funcao: funcao,
        id: id,
        nome: nome,
        dev: dev,
        versao: versao,
        edicao: edicao,
        ativo: ativo,
    };

    try {
        let response = await fetch('./includes/office.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=UTF-8'
            },
            body: JSON.stringify(formData)
        });

        if (!response.ok) {
            if (response.status === 409) {
                throw new Error('Erro ao atualizar os dados do pacote office.');
            }
        }

        let responseData = await response.json();
        let overlay = document.getElementById('overlay');
        overlay.innerHTML = `
        <div id="edit_office" class="bloco-overlay">
            <div class="header">
                <span>Editar Pacote Office</span>
                <div id="botoes">
                    <div id="b-line-header-1" class="b-line">
                        <div id="fecharOverlay" class="flex-center icon-button margin-bottom rotated-icon">
                            <a title="Fechar" href="#" onclick="closeOverlay()">${addSVG}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="linha-1" class="linha fim">
                <div id="h-line-edit-office-1" class="b-line centralizado">${responseData.mensagem}</div>
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