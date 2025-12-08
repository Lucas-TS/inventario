var personalizedImages = [];

function initialSelect() {
    var avatar1 = document.getElementById('avatar1');
    if (avatar1) {
        selectImage(avatar1);
    } else {
        console.error("Elemento com ID 'avatar1' não encontrado.");
    }
}

function loadFile(event) {
    var image = document.getElementById('avatar-preview');
    var file = event.target.files[0];
    var reader = new FileReader();
    reader.onload = function(e) {
        var img = new Image();
        img.src = e.target.result;
        img.onload = function() {
            var canvas = document.createElement('canvas');
            var ctx = canvas.getContext('2d');
            var size = 300; // Tamanho maior para melhor qualidade
            canvas.width = size;
            canvas.height = size;
            ctx.beginPath();
            ctx.arc(size / 2, size / 2, size / 2, 0, Math.PI * 2, true);
            ctx.closePath();
            ctx.clip();
            ctx.imageSmoothingEnabled = true; // Suavização de imagem
            ctx.imageSmoothingQuality = 'high'; // Alta qualidade de suavização
            ctx.drawImage(img, 0, 0, img.width, img.height, 0, 0, size, size);
            var dataURL = canvas.toDataURL('image/png');
            image.src = dataURL;
            addToGallery(dataURL, true);
        };
    };
    reader.readAsDataURL(file);
}

function addToGallery(dataURL, selectNew = false) {
    // Verifica se a imagem já existe na lista personalizada
    var existingImage = personalizedImages.find(img => img.src === dataURL);
    if (existingImage) {
        selectImage(existingImage);
        return;
    }

    var gallery = document.getElementById('gallery');
    var newImg = document.createElement('img');
    newImg.src = dataURL;
    newImg.classList.add('gallery-item');
    newImg.onclick = function() { selectImage(this); };

    var addButton = document.getElementById('add-avatar-button');

    if (personalizedImages.length >= 8) {
        personalizedImages.shift().remove();
    }

    gallery.insertBefore(newImg, addButton);
    personalizedImages.push(newImg);

    if (selectNew) {
        selectImage(newImg);
    }
}

function selectImage(imgElement) {
    var image = document.getElementById('avatar-preview');
    var img = new Image();
    img.src = imgElement.src;
    img.onload = function() {
        var canvas = document.createElement('canvas');
        var ctx = canvas.getContext('2d');
        var size = 300; // Tamanho maior para melhor qualidade
        canvas.width = size;
        canvas.height = size;
        ctx.beginPath();
        ctx.arc(size / 2, size / 2, size / 2, 0, Math.PI * 2, true);
        ctx.closePath();
        ctx.clip();
        ctx.imageSmoothingEnabled = true; // Suavização de imagem
        ctx.imageSmoothingQuality = 'high'; // Alta qualidade de suavização
        ctx.drawImage(img, 0, 0, img.width, img.height, 0, 0, size, size);
        image.src = canvas.toDataURL('image/png');
    };

    // Remove a borda de todos os itens da galeria
    var galleryItems = document.querySelectorAll('.gallery-item');
    galleryItems.forEach(item => item.style.border = '');

    // Adiciona a borda ao item selecionado
    imgElement.style.border = '2px solid #158CBA';
}

async function editarAvatarOverlay(id, arquivo) {
    await exibirOverlay(arquivo); // Espera a execução e finalização de exibirOverlay
    let funcao = 'buscar';

    let formData = {
        funcao: funcao,
        id: id,
    };

    try {
        let response = await fetch('./includes/avatar.php', {
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
        document.getElementById('cpf-edit-user').value = data.cpf;
        document.getElementById('email-edit-user').value = data.email;
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

async function buscaSessaoPhp() {
    fetch('includes/session_info.php')
        .then(response => response.json())
        .then(session => {
        if (session && session.username) {
            // Clona a sessão PHP no sessionStorage do navegador
            for (let key in session) {
                if (session[key] !== null) {
                    sessionStorage.setItem(key, session[key]);
                }
            }
        } else {
            console.warn('Sessão PHP não encontrada ou expirou');
        }
    })
    .catch(error => console.error('Erro ao obter a sessão:', error));
}

function atualizarSessao() {
    let dadosSessao = {
        email: sessionStorage.getItem('email'),
        cpf: sessionStorage.getItem('cpf'),
        fullname: sessionStorage.getItem('fullname'),
        username: sessionStorage.getItem('username'),
        id: sessionStorage.getItem('id'),
        grupo: sessionStorage.getItem('grupo'),
        avatar: sessionStorage.getItem('avatar')
    };
    fetch('includes/atualiza_sessao.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dadosSessao)
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            // Recarregar a imagem do avatar com um timestamp para evitar cache
            let avatarSrc = sessionStorage.getItem('avatar') + '?' + new Date().getTime();
            document.getElementById('avatar').src = avatarSrc;
        } else {
            console.error('Erro ao atualizar a sessão:', data.message);
        }
    })
    .catch(error => {
        console.error('Erro ao fazer o fetch:', error);
    });
}

function scrollGallery(direction) {
    let galleryList = document.getElementById("gallery-list");
    let leftArrow = document.getElementById("gallery-left");
    let rightArrow = document.getElementById("gallery-right");
    let columnWidth = 75; // Define a largura de uma única coluna
    let columnsPerMove = 1; // Define o deslocamento exato por coluna

    // Move o scroll exatamente uma coluna por vez
    galleryList.scrollLeft += direction * (columnWidth * columnsPerMove);

    setTimeout(() => {
        let maxScroll = galleryList.scrollWidth - galleryList.clientWidth;

        // 🔹 Usa opacity e cursor para ocultar/desativar a seta esquerda
        if (galleryList.scrollLeft <= 0) {
            leftArrow.style.opacity = "0";
            leftArrow.style.cursor = "default";
        } else {
            leftArrow.style.opacity = "1";
            leftArrow.style.cursor = "pointer";
        }

        // 🔹 Usa opacity e cursor para ocultar/desativar a seta direita
        if (galleryList.scrollLeft >= maxScroll) {
            rightArrow.style.opacity = "0";
            rightArrow.style.cursor = "default";
        } else {
            rightArrow.style.opacity = "1";
            rightArrow.style.cursor = "pointer";
        }
    }, 100); // Pequeno delay para atualização mais precisa
}

// 🔄 Inicializa corretamente ao carregar a página
const galleryObserver = new MutationObserver(() => {
  const galleryList = document.getElementById("gallery-list");
  if (galleryList) {
    galleryObserver.disconnect(); // Para de observar depois que o elemento apareceu
    scrollGallery(1); // ou -1
  }
});

async function editarAvatar(event) {
    event.preventDefault(); // Previne o comportamento padrão do formulário

    // Capturar valor do campo de texto ou definir como nulo
    let funcao = 'editar';
    let user = sessionStorage.getItem('username') || 'defaultUser'; // Pega o usuário da sessão ou define um padrão
    let id = document.getElementById('id-edit-user').value;
    let nc = document.getElementById('nc-edit-user').value;
    let cpf = document.getElementById('cpf-edit-user').value;
    let email = document.getElementById('email-edit-user').value;
    let pw = document.getElementById('pw-edit-user').value;
    let pw2 = document.getElementById('pw2-edit-user').value;

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
        nc: nc,
        cpf: cpf,
        email: email,
        pw: pw,
        avatar: avatarFileName,
    };
    
    try {
        let response = await fetch('./includes/avatar.php', {
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
                <span>Editar Perfil</span>
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
        // Fechar o overlay após a inserção com um retardo de 5 segundos
        closeTimeout = setTimeout(function () {
            closeOverlay();
        }, 5000); // 5000 milissegundos = 5 segundos
    } catch (error) {
        alert(error.message); // Exibe um alert com a mensagem de erro
    }
}