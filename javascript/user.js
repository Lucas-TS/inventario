

async function insertUser(event) {
    event.preventDefault(); // Previne o comportamento padrão do formulário

    let funcao = 'inserir';
    let nc = document.getElementById('nc-add-user').value;
    let email = document.getElementById('email-add-user').value;
    let user = document.getElementById('user-add-user').value;
    let pw = document.getElementById('pw-add-user').value;
    let pw2 = document.getElementById('pw2-add-user').value;
    let grupo = document.getElementById('hidden-gp-add-user').value;

    if (pw != pw2) {
        alert("As senhas não conferem");
        return;
    }

    let avatarElement = document.getElementById('avatar-preview');
    let avatar = avatarElement.src;
    let avatarFileName;
    

    // Verifique se o avatar é um dos padrões ou um personalizado
    if (avatar.includes('./images/avatar')) {
        avatarFileName = avatar.split('/').pop(); // Pega o nome do arquivo do avatar padrão
    } else {
        avatarFileName = `avatar.${user}.png`; // Renomeia o avatar personalizado
        await uploadAvatar(avatar, avatarFileName); // Função para salvar o avatar personalizado
    }

    let formData = {
        funcao: funcao,
        nc: nc,
        email: email,
        user: user,
        pw: pw,
        avatar: avatarFileName,
        grupo: grupo,
    };

    try {
        let response = await fetch('./includes/user.php', {
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
                throw new Error('Erro ao inserir o usuário.');
            }
        }

        let overlay = document.getElementById('overlay');
        overlay.innerHTML = `
        <div id="add_user" class="bloco-overlay">
            <div class="header">
                <span>Adicionar Usuário</span>
                <div id="botoes">
                    <div id="b-line-header-1" class="b-line">
                        <div id="fecharOverlay" class="flex-center icon-button margin-bottom rotated-icon">
                            <a title="Fechar" href="#" onclick="closeOverlay()">${addSVG}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="linha-1" class="linha fim">
                <div id="h-line-add-user-1" class="h-line centralizado">${user} inserido com sucesso!</div>
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

async function uploadAvatar(dataURL, fileName) {
    let response = await fetch('./includes/upload_avatar.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ dataURL, fileName }),
    });

    if (!response.ok) {
        throw new Error("Erro ao fazer upload do avatar");
    }
}

async function editarUserOverlay(id, arquivo) {
    await exibirOverlay(arquivo); // Espera a execução e finalização de exibirOverlay
    let funcao = 'buscar';

    let formData = {
        funcao: funcao,
        id: id,
    };

    try {
        let response = await fetch('./includes/user.php', {
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
        document.getElementById('id-edit-user').value = data.id;
        document.getElementById('nc-edit-user').value = data.fullname;
        document.getElementById('email-edit-user').value = data.email;
        document.getElementById('user-edit-user').value = data.username;
        document.getElementById('hidden-gp-edit-user').value = data.grupo;
        if (data.grupo === 1) {
            document.getElementById('gp-edit-user').value = "Administradores";
        } else {
            document.getElementById('gp-edit-user').value = "Usuários";
        }
        if (data.ativo === 1) {
            document.getElementById('ativo-edit-user').checked = true;
        }

        if (data.avatar) { // Verificação correta para ver se data.avatar não está vazio
            let avatar = "./images/avatares/" + data.avatar;
            addToGallery(avatar, true);
        }

        // Continue para outros campos conforme necessário
    } catch (error) {
        console.error(error.message);
    }
}

async function editarUser(event) {
    event.preventDefault(); // Previne o comportamento padrão do formulário

    // Capturar valor do campo de texto ou definir como nulo
    let funcao = 'editar';
    let id = document.getElementById('id-edit-user').value;
    let ativo = document.getElementById('ativo-edit-user').checked ? '1' : '0';
    let nc = document.getElementById('nc-edit-user').value;
    let email = document.getElementById('email-edit-user').value;
    let user = document.getElementById('user-edit-user').value;
    let pw = document.getElementById('pw-edit-user').value;
    let pw2 = document.getElementById('pw2-edit-user').value;
    let grupo = document.getElementById('hidden-gp-edit-user').value;

    if (pw != pw2) {
        alert("As senhas não conferem");
        return;
    }

    let avatarElement = document.getElementById('avatar-preview');
    let avatar = avatarElement.src;
    let avatarFileName;
    

    // Verifique se o avatar é um dos padrões ou um personalizado
    if (avatar.includes('./images/avatar')) {
        avatarFileName = avatar.split('/').pop(); // Pega o nome do arquivo do avatar padrão
    } else {
        avatarFileName = `avatar.${user}.png`; // Renomeia o avatar personalizado
        await uploadAvatar(avatar, avatarFileName); // Função para salvar o avatar personalizado
    }

    let formData = {
        funcao: funcao,
        id: id,
        ativo: ativo,
        nc: nc,
        email: email,
        user: user,
        pw: pw,
        avatar: avatarFileName,
        grupo: grupo,
    };

    try {
        let response = await fetch('./includes/user.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=UTF-8'
            },
            body: JSON.stringify(formData)
        });

        if (!response.ok) {
            if (response.status === 409) {
                throw new Error('Erro ao atualizar os dados do usuário.');
            }
        }

        let responseData = await response.json();
        let overlay = document.getElementById('overlay');
        overlay.innerHTML = `
        <div id="edit_user" class="bloco-overlay">
            <div class="header">
                <span>Editar Usuário</span>
                <div id="botoes">
                    <div id="b-line-header-1" class="b-line">
                        <div id="fecharOverlay" class="flex-center icon-button margin-bottom rotated-icon">
                            <a title="Fechar" href="#" onclick="closeOverlay()">${addSVG}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="linha-1" class="linha fim">
                <div id="h-line-edit-user-1" class="b-line centralizado">${responseData.mensagem}</div>
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
        atualizarSessao();
        atualizarTabela();
        // Fechar o overlay após a inserção com um retardo de 5 segundos
        closeTimeout = setTimeout(function () {
            closeOverlay();
        }, 5000); // 5000 milissegundos = 5 segundos
    } catch (error) {
        alert(error.message); // Exibe um alert com a mensagem de erro
    }
}