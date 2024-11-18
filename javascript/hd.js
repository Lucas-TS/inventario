async function insertHd(event) {
    event.preventDefault(); // Previne o comportamento padrão do formulário

    let funcao = 'inserir';
    // Capturar valor do campo de texto ou definir como nulo
    let radios = document.getElementsByName('un-add-hd');
    let unidade;

    for (let i = 0; i < radios.length; i++) {
        if (radios[i].checked) {
            unidade = radios[i].value;
            break;
        }
    }

    let numero = document.getElementById('tam-add-hd').value;

    // Ajustar o número conforme a unidade
    if (unidade === 'GB') {
        // Remover qualquer valor decimal
        numero = parseInt(numero).toString();
    } else if (unidade === 'TB') {
        // Certificar que haja uma casa decimal, substituindo ponto por vírgula se necessário
        if (!numero.includes(',')) {
            if (numero.includes('.')) {
                numero = numero.replace('.', ',');
            } else {
                numero = numero + ",0";
            }
        } else if (numero.split(',')[1].length === 0) {
            numero = numero + "0"; // Adicionar 0 após a vírgula se estiver vazio
        }
    }

    let tamanho = numero + " " + unidade;

    let formData = {
        tamanho: tamanho,
        funcao: funcao,
    };

    try {
        let response = await fetch('./includes/hd.php', {
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
                throw new Error('Erro ao inserir o HD.');
            }
        }

        let overlay = document.getElementById('overlay');
        overlay.innerHTML = `
        <div id="add_hd" class="bloco-overlay">
            <div class="header">
                <span>Adicionar HD</span>
                <div id="botoes">
                    <div id="b-line-header-1" class="b-line">
                        <div id="fecharOverlay" class="flex-center icon-button margin-bottom rotated-icon">
                            <a title="Fechar" href="#" onclick="closeOverlay()">${addSVG}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="linha-1" class="linha fim">
                <div id="h-line-add-hd-1" class="h-line centralizado">${tamanho} inserido com sucesso!</div>
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

async function editarHdOverlay(id, arquivo) {
    await exibirOverlay(arquivo); // Espera a execução e finalização de exibirOverlay
    let funcao = 'buscar';

    let formData = {
        funcao: funcao,
        id: id,
    };

    try {
        let response = await fetch('./includes/hd.php', {
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
        let tamanho = data.tamanho.split(' ')

        document.getElementById('id-edit-hd').value = data.id;
        document.getElementById('tam-edit-hd').value = tamanho[0];
        let unidade = tamanho[1];
        if (unidade == 'GB') {
            document.getElementById('gb').checked = true;
        }
        if (unidade == 'TB') {
            document.getElementById('tb').checked = true;
        }
        if (data.ativo === 1) {
            document.getElementById('ativo-edit-hd').checked = true;
        }
        // Continue para outros campos conforme necessário
    } catch (error) {
        console.error(error.message);
    }
}

async function editarHd(event) {
    event.preventDefault(); // Previne o comportamento padrão do formulário

    // Capturar valor do campo de texto ou definir como nulo
    let funcao = 'editar';
    let id = document.getElementById('id-edit-hd').value;
    let ativo = document.getElementById('ativo-edit-hd').checked ? '1' : '0';

    let radios = document.getElementsByName('un-edit-hd');
    let unidade;

    for (let i = 0; i < radios.length; i++) {
        if (radios[i].checked) {
            unidade = radios[i].value;
            break;
        }
    }

    let numero = document.getElementById('tam-edit-hd').value;

    // Ajustar o número conforme a unidade
    if (unidade === 'GB') {
        // Remover qualquer valor decimal
        numero = parseInt(numero).toString();
    } else if (unidade === 'TB') {
        // Certificar que haja uma casa decimal, substituindo ponto por vírgula se necessário
        if (!numero.includes(',')) {
            if (numero.includes('.')) {
                numero = numero.replace('.', ',');
            } else {
                numero = numero + ",0";
            }
        } else if (numero.split(',')[1].length === 0) {
            numero = numero + "0"; // Adicionar 0 após a vírgula se estiver vazio
        }
    }

    let tamanho = numero + " " + unidade;

    let formData = {
        funcao: funcao,
        id: id,
        tamanho: tamanho,
        ativo: ativo,
    };

    try {
        let response = await fetch('./includes/hd.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=UTF-8'
            },
            body: JSON.stringify(formData)
        });

        if (!response.ok) {
            if (response.status === 409) {
                throw new Error('Erro ao atualizar os dados do HD.');
            }
        }

        let responseData = await response.json();
        let overlay = document.getElementById('overlay');
        overlay.innerHTML = `
        <div id="edit_hd" class="bloco-overlay">
            <div class="header">
                <span>Editar HD</span>
                <div id="botoes">
                    <div id="b-line-header-1" class="b-line">
                        <div id="fecharOverlay" class="flex-center icon-button margin-bottom rotated-icon">
                            <a title="Fechar" href="#" onclick="closeOverlay()">${addSVG}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="linha-1" class="linha fim">
                <div id="h-line-edit-hd-1" class="b-line centralizado">${responseData.mensagem}</div>
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