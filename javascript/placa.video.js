async function insertPv(event) {
    event.preventDefault(); // Previne o comportamento padrão do formulário

    let funcao = 'inserir';
    // Capturar valor do campo de texto ou definir como nulo
    let seguimento = document.getElementById('seg-add-pv').value;
    let chipset = document.getElementById('chipset-add-pv').value;
    let marca = document.getElementById('marca-add-pv').value;
    let modelo = document.getElementById('modelo-add-pv').value;
    let qtde = document.getElementById('mem-add-pv').value;

    // Extrai a parte numérica e a unidade
    let numberPart = qtde.match(/[\d,\.]+/)[0];
    let unitPart = qtde.match(/[^\d,\.]+/)[0].trim();

    // Converte a parte numérica para um número com ponto decimal
    numberPart = parseFloat(numberPart.replace(',', '.'));

    // Verifica se a parte numérica é menor que 10
    if (numberPart < 10) {
        // Adiciona uma casa decimal se não houver
        if (numberPart % 1 === 0) {
            numberPart = numberPart.toFixed(1).replace('.', ',');
        } else {
            numberPart = numberPart.toString().replace('.', ',');
        }
    } else {
        // Remove a casa decimal se houver
        numberPart = Math.floor(numberPart).toString();
    }

    // Atualiza o valor formatado em qtde
    let tamanhoMemoria = `${numberPart} ${unitPart}`;

    // Seleciona todos os rádios com o name 'mem-pv'
    let radios = document.querySelectorAll('input[name="mem-pv"]');

    // Encontra o rádio marcado
    let tipoMemoria;
    for (let radio of radios) {
        if (radio.checked) {
            tipoMemoria = radio.value;
            break;
        }
    }

    let memoria = tamanhoMemoria + ' ' + tipoMemoria;

    let formData = {
        funcao: funcao,
        seguimento: seguimento,
        chipset: chipset,
        marca: marca,
        modelo: modelo,
        memoria: memoria,
    };

    try {
        let response = await fetch('./includes/pv.php', {
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
                throw new Error('Erro ao inserir a placa de vídeo.');
            }
        }

        let overlay = document.getElementById('overlay');
        overlay.innerHTML = `
        <div id="add_pv" class="bloco-overlay">
            <div class="header">
                <span>Adicionar Placa de Vídeo</span>
                <div id="botoes">
                    <div id="b-line-header-1" class="b-line">
                        <div id="fecharOverlay" class="flex-center icon-button margin-bottom rotated-icon">
                            <a title="Fechar" href="#" onclick="closeOverlay()">${addSVG}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="linha-1" class="linha fim">
                <div id="h-line-add-pv-1" class="h-line centralizado">${marca} ${chipset} ${modelo} ${memoria} inserida com sucesso!</div>
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

async function editarPvOverlay(id, arquivo) {
    await exibirOverlay(arquivo); // Espera a execução e finalização de exibirOverlay
    let funcao = 'buscar';

    let formData = {
        funcao: funcao,
        id: id,
    };

    try {
        let response = await fetch('./includes/pv.php', {
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
        document.getElementById('id-edit-pv').value = data.id;
        document.getElementById('seg-edit-pv').value = data.seguimento;
        if (data.seguimento === 'Notebook') {
            document.getElementById('marca-edit-pv').disabled = true; // Desabilita o campo de marca
            document.getElementById('marca-edit-pv').placeholder = '---';
            document.getElementById('modelo-edit-pv').disabled = true; // Desabilita o campo de modelo
            document.getElementById('modelo-edit-pv').placeholder = '---';
        }
        document.getElementById('marca-edit-pv').value = data.marca;
        document.getElementById('modelo-edit-pv').value = data.modelo;
        document.getElementById('chipset-edit-pv').value = data.gpu;
        let dadosMemoria = data.memoria.split(' ');
        let tamanhoMemoria = dadosMemoria[0] + ' ' + dadosMemoria[1];
        document.getElementById('mem-edit-pv').value = tamanhoMemoria;
        let tipoMemoria = dadosMemoria[2];
        document.getElementById(tipoMemoria + '-pv').checked = true;
        if (data.ativo === 1) {
            document.getElementById('ativo-edit-pv').checked = true;
        }
    } catch (error) {
        console.error(error.message);
    }
}

async function editarPv(event) {
    event.preventDefault(); // Previne o comportamento padrão do formulário

    // Capturar valor do campo de texto ou definir como nulo
    let funcao = 'editar';
    let id = document.getElementById('id-edit-pv').value;
    let seguimento = document.getElementById('seg-edit-pv').value;
    let marca = document.getElementById('marca-edit-pv').value;
    let modelo = document.getElementById('modelo-edit-pv').value;
    let gpu = document.getElementById('chipset-edit-pv').value;
    let qtde = document.getElementById('mem-edit-pv').value;

    // Extrai a parte numérica e a unidade
    let numberPart = qtde.match(/[\d,\.]+/)[0];
    let unitPart = qtde.match(/[^\d,\.]+/)[0].trim();
    console.log(numberPart);

    // Converte a parte numérica para um número com ponto decimal
    numberPart = parseFloat(numberPart.replace(',', '.'));

    // Verifica se a parte numérica é menor que 10
    if (numberPart < 10) {
        // Adiciona uma casa decimal se não houver
        if (numberPart % 1 === 0) {
            numberPart = numberPart.toFixed(1).replace('.', ',');
        } else {
            numberPart = numberPart.toString().replace('.', ',');
        }
    } else {
        // Remove a casa decimal se houver
        numberPart = Math.floor(numberPart).toString();
    }

    // Atualiza o valor formatado em qtde
    let tamanhoMemoria = `${numberPart} ${unitPart}`;

    let radios = document.getElementsByName('mem-pv');
    let tipoMemoria;

    for (let i = 0; i < radios.length; i++) {
        if (radios[i].checked) {
            tipoMemoria = radios[i].value;
            break;
        }
    }

    let memoria = tamanhoMemoria + ' ' + tipoMemoria;

    let ativo = document.getElementById('ativo-edit-pv').checked ? '1' : '0';

    let formData = {
        funcao: funcao,
        id: id,
        seguimento: seguimento,
        marca: marca,
        modelo: modelo,
        gpu: gpu,
        memoria: memoria,
        ativo: ativo
    };

    try {
        let response = await fetch('./includes/pv.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=UTF-8'
            },
            body: JSON.stringify(formData)
        });

        if (!response.ok) {
            if (response.status === 409) {
                throw new Error('Erro ao atualizar os dados da placa de vídeo.');
            }
        }

        let responseData = await response.json();
        let overlay = document.getElementById('overlay');
        overlay.innerHTML = `
        <div id="edit_pv" class="bloco-overlay">
            <div class="header">
                <span>Editar Placa de Vídeo</span>
                <div id="botoes">
                    <div id="b-line-header-1" class="b-line">
                        <div id="fecharOverlay" class="flex-center icon-button margin-bottom rotated-icon">
                            <a title="Fechar" href="#" onclick="closeOverlay()">${addSVG}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="linha-1" class="linha fim">
                <div id="h-line-edit-pv-1" class="b-line centralizado">${responseData.mensagem}</div>
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

let valorMarca = ''; // Armazena a marca original
let valorModelo = ''; // Armazena o modelo original

function mobileGPU() {
    let campo = document.getElementById('marca-add-pv') || document.getElementById('marca-edit-pv');
    let campo2 = document.getElementById('modelo-add-pv') || document.getElementById('modelo-edit-pv');

    // Armazena os valores antes de limpar, mas apenas se forem campos de edição
    if (campo && campo.id === 'marca-edit-pv') {
        valorMarca = campo.value; // Salva o valor original
        campo.value = ''; // Limpa o campo
    }
    if (campo2 && campo2.id === 'modelo-edit-pv') {
        valorModelo = campo2.value; // Salva o valor original
        campo2.value = ''; // Limpa o campo
    }

    // Desativa os campos
    if (campo) {
        campo.disabled = true;
        campo.placeholder = '---';
    }
    if (campo2) {
        campo2.disabled = true;
        campo2.placeholder = '---';
    }
}

function desktopGPU() {
    let campo = document.getElementById('marca-add-pv') || document.getElementById('marca-edit-pv');
    let campo2 = document.getElementById('modelo-add-pv') || document.getElementById('modelo-edit-pv');

    // Se os campos forem editáveis, recupera os valores armazenados
    if (campo && campo.id === 'marca-edit-pv') {
        campo.value = valorMarca; // Recupera o valor original
    }
    if (campo2 && campo2.id === 'modelo-edit-pv') {
        campo2.value = valorModelo; // Recupera o valor original
    }

    // Reativa os campos
    if (campo) {
        campo.disabled = false;
        campo.placeholder = 'Digite o nome';
    }
    if (campo2) {
        campo2.disabled = false;
        campo2.placeholder = 'Digite o modelo';
    }
}