async function insertMil(event) {
    event.preventDefault(); // Previne o comportamento padrão do formulário

    // Capturar valor do campo de texto ou definir como nulo
    let funcao = 'inserir';
    let nc = document.getElementById('nc-add-mil').value;
    let pg = document.getElementById('pg-add-mil').value;
    let id_pg = document.getElementById('hidden-pg-add-mil').value;
    let ng = document.getElementById('ng-add-mil').value;
    let id_sec = document.getElementById('hidden-sec-add-mil').value;
    let formData = {
        funcao: funcao,
        nc: nc,
        pg: id_pg,
        ng: ng,
        sec: id_sec,
    };

    try {
        let response = await fetch('./includes/militar.php', {
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
                throw new Error('Erro ao inserir o militar.');
            }
        }

        let overlay = document.getElementById('overlay');
        overlay.innerHTML = `
        <div id="add_mil" class="bloco-overlay">
            <div class="header">
                <span>Adicionar Militar</span>
                <div id="botoes">
                    <div id="b-line-header-1" class="b-line">
                        <div id="fecharOverlay" class="flex-center icon-button margin-bottom rotated-icon">
                            <a title="Fechar" href="#" onclick="closeOverlay()">${addSVG}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="linha-1" class="linha fim">
                <div id="h-line-add-mil-1" class="b-line centralizado">${pg} ${ng} inserido com sucesso!</div>
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

async function editarMilOverlay(id, arquivo) {
    await exibirOverlay(arquivo); // Espera a execução e finalização de exibirOverlay
    let funcao = 'buscar';

    let formData = {
        funcao: funcao,
        id: id,
    };

    try {
        let response = await fetch('./includes/militar.php', {
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
        document.getElementById('id-edit-mil').value = data.id;
        document.getElementById('nc-edit-mil').value = data.nome_completo;
        document.getElementById('ng-edit-mil').value = data.nome_guerra;
        document.getElementById('pg-edit-mil').value = data.lista_pg;
        document.getElementById('hidden-pg-edit-mil').value = data.id_pg;
        document.getElementById('sec-edit-mil').value = data.lista_secao;
        document.getElementById('hidden-sec-edit-mil').value = data.id_secao;
        if (data.ativo === 1) {
            document.getElementById('ativo-edit-mil').checked = true;
        }
        // Continue para outros campos conforme necessário
    } catch (error) {
        console.error(error.message);
    }
}

async function editarMil(event) {
    event.preventDefault(); // Previne o comportamento padrão do formulário

    // Capturar valor do campo de texto ou definir como nulo
    let funcao = 'editar';
    let id = document.getElementById('id-edit-mil').value;
    let nc = document.getElementById('nc-edit-mil').value;
    let id_pg = document.getElementById('hidden-pg-edit-mil').value;
    let ng = document.getElementById('ng-edit-mil').value;
    let id_sec = document.getElementById('hidden-sec-edit-mil').value;
    let ativo = document.getElementById('ativo-edit-mil').checked ? '1' : '0';

    let formData = {
        funcao: funcao,
        id: id,
        nc: nc,
        pg: id_pg,
        ng: ng,
        sec: id_sec,
        ativo: ativo,
    };

    try {
        let response = await fetch('./includes/militar.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=UTF-8'
            },
            body: JSON.stringify(formData)
        });

        if (!response.ok) {
            if (response.status === 409) {
                throw new Error('Erro ao atualizar os dados do militar.');
            }
        }

        let responseData = await response.json();
        let overlay = document.getElementById('overlay');
        overlay.innerHTML = `
        <div id="edit_mil" class="bloco-overlay">
            <div class="header">
                <span>Editar Militar</span>
                <div id="botoes">
                    <div id="b-line-header-1" class="b-line">
                        <div id="fecharOverlay" class="flex-center icon-button margin-bottom rotated-icon">
                            <a title="Fechar" href="#" onclick="closeOverlay()">${addSVG}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="linha-1" class="linha fim">
                <div id="h-line-edit-mil-1" class="b-line centralizado">${responseData.mensagem}</div>
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