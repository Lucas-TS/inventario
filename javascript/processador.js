function liberaModeloIGPU() {
    let igpu = document.getElementById('modelo-igpu-proc') || document.getElementById('modelo-igpu-edit-proc');
    igpu.required = true;
    igpu.disabled = false;
}

function desativaModeloIGPU() {
    let igpu = document.getElementById('modelo-igpu-proc') || document.getElementById('modelo-igpu-edit-proc');
    igpu.value = '';
    igpu.required = false;
    igpu.disabled = true;
}

async function insertProc(event) {
    event.preventDefault(); // Previne o comportamento padrão do formulário

    let funcao = 'inserir';
    // Capturar valores dos checkboxes marcados
    let memoriaValues = [];
    let checkboxes = document.querySelectorAll('#linha-5 input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
            memoriaValues.push(checkbox.value);
        }
    });
    let memoria = memoriaValues.join(', ')

    // Capturar valor do campo de texto ou definir como nulo
    let igpuValue = document.getElementById('off-proc').checked ? null : document.getElementById('modelo-igpu-proc').value;
    let marca = document.getElementById('marca-proc').value;
    let modelo = document.getElementById('modelo-proc').value;
    let geracao = document.getElementById('ger-proc').value;
    let socket = document.getElementById('skt-proc').value;
    let seguimento = document.getElementById('seg-proc').value;
    let pcores = document.getElementById('pcores-proc').value;
    let ecores = document.getElementById('ecores-proc').value;
    let threads = document.getElementById('threads-proc').value;
    let clock = document.getElementById('clock-proc').value;
    let turbo = document.getElementById('turbo-proc').value;

    let formData = {
        funcao: funcao,
        marca: marca,
        modelo: modelo,
        geracao: geracao,
        socket: socket,
        seguimento: seguimento,
        pcores: pcores,
        ecores: ecores,
        threads: threads,
        clock: clock,
        turbo: turbo,
        memoria: memoria,
        igpu: igpuValue
    };

    try {
        const response = await fetch('./includes/processador.php', {
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
                throw new Error('Erro ao inserir o processador.');
            }
        }

        const overlay = document.getElementById('overlay'); // Seleciona a div com o ID 'overlay'
        overlay.innerHTML = `
        <div id="add_proc" class="bloco-overlay">
            <div class="header">
                <span>Adicionar Processador</span>
                <div id="botoes">
                    <div id="b-line-header-1" class="b-line">
                        <div id="fecharOverlay" class="flex-center icon-button margin-bottom rotated-icon">
                            <a title="Fechar" href="#" onclick="closeOverlay()">${addSVG}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="linha-1" class="linha fim">
                <div id="h-line-add-proc-1" class="h-line centralizado">${marca} ${modelo} inserido com sucesso!</div>
            </div>
            <div id="linha-2" class="linha fim centralizado">
                <div id="b-line-1" class="b-line">
                    <div id="okOverlay" class="large-button adjust-position flex-center">
                        <a title="Ok" href="#" onclick="closeOverlay()">${okSVG}</a>
                    </div>
                </div>
            </div>
        </div>
        `; // Insere a mensagem de sucesso na div 'overlay'

        atualizarTabela();

        // Fechar o overlay após a inserção com um retardo de 5 segundos
        closeTimeout = setTimeout(function () {
            closeOverlay();
        }, 5000); // 5000 milissegundos = 5 segundos
    } catch (error) {
        alert(error.message); // Exibe um alert com a mensagem de erro
    }
}

async function editarProcOverlay(id, arquivo) {
    await exibirOverlay(arquivo); // Espera a execução e finalização de exibirOverlay
    let funcao = 'buscar';

    let formData = {
        funcao: funcao,
        id: id,
    };

    try {
        let response = await fetch('./includes/processador.php', {
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
        document.getElementById('id-edit-proc').value = data.id;
        document.getElementById('marca-edit-proc').value = data.marca;
        document.getElementById('modelo-edit-proc').value = data.modelo;
        document.getElementById('ger-edit-proc').value = data.geracao;
        document.getElementById('skt-edit-proc').value = data.socket;
        document.getElementById('seg-edit-proc').value = data.seguimento;
        document.getElementById('clock-edit-proc').value = data.clock;
        document.getElementById('turbo-edit-proc').value = data.turbo;
        document.getElementById('pcores-edit-proc').value = data.pcores;
        document.getElementById('ecores-edit-proc').value = data.ecores;
        document.getElementById('threads-edit-proc').value = data.threads;
        if (data.igpu !== null) {
            document.getElementById('igpu-edit-proc').checked = true;
            document.getElementById('modelo-igpu-edit-proc').value = data.igpu;
            document.getElementById('modelo-igpu-edit-proc').disabled = false;
        } else {
            document.getElementById('off-edit-proc').checked = true;
            document.getElementById('modelo-igpu-edit-proc').disabled = true;
        }

        if (data.ativo === 1) {
            document.getElementById('ativo-edit-proc').checked = true;
        }
        // Supondo que data.memoria contém uma string com valores separados por vírgula
        let memorias = data.memoria.split(',');

        // Iterar pelos valores e marcar os checkboxes correspondentes
        memorias.forEach(valor => {
            valor = valor.trim(); // Remove espaços em branco ao redor do valor, se houver
            let checkbox = document.querySelector(`input[type="checkbox"][value="${valor}"]`);
            if (checkbox) {
                checkbox.checked = true;
            }
        });


        // Continue para outros campos conforme necessário
    } catch (error) {
        console.error(error.message);
    }
}

async function editarProc(event) {
    event.preventDefault(); // Previne o comportamento padrão do formulário

    // Capturar valor do campo de texto ou definir como nulo
    let funcao = 'editar';
    let id = document.getElementById('id-edit-proc').value;
    let marca = document.getElementById('marca-edit-proc').value;
    let modelo = document.getElementById('modelo-edit-proc').value;
    let geracao = document.getElementById('ger-edit-proc').value;
    let socket = document.getElementById('skt-edit-proc').value;
    let seguimento = document.getElementById('seg-edit-proc').value;
    let clock = document.getElementById('clock-edit-proc').value;
    let turbo = document.getElementById('turbo-edit-proc').value;
    let pcores = document.getElementById('pcores-edit-proc').value;
    let ecores = document.getElementById('ecores-edit-proc').value;
    let threads = document.getElementById('threads-edit-proc').value;
    let memoriaValues = [];
    let checkboxes = document.querySelectorAll('#linha-6 input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
            memoriaValues.push(checkbox.value);
        }
    });
    let memoria = memoriaValues.join(', ')

    // Capturar valor do campo de texto ou definir como nulo
    let igpuValue = document.getElementById('off-edit-proc').checked ? null : document.getElementById('modelo-igpu-edit-proc').value;
    
    let ativo = document.getElementById('ativo-edit-proc').checked ? '1' : '0';

    let formData = {
        funcao: funcao,
        id: id,
        marca: marca,
        modelo: modelo,
        geracao: geracao,
        socket: socket,
        seguimento: seguimento,
        pcores: pcores,
        ecores: ecores,
        threads: threads,
        clock: clock,
        turbo: turbo,
        memoria: memoria,
        igpu: igpuValue,
        ativo: ativo
    };
    
    try {
        let response = await fetch('./includes/processador.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=UTF-8'
            },
            body: JSON.stringify(formData)
        });

        if (!response.ok) {
            if (response.status === 409) {
                throw new Error('Erro ao atualizar os dados do processador.');
            }
        }

        let responseData = await response.json();
        let overlay = document.getElementById('overlay');
        overlay.innerHTML = `
        <div id="edit_proc" class="bloco-overlay">
            <div class="header">
                <span>Editar Processador</span>
                <div id="botoes">
                    <div id="b-line-header-1" class="b-line">
                        <div id="fecharOverlay" class="flex-center icon-button margin-bottom rotated-icon">
                            <a title="Fechar" href="#" onclick="closeOverlay()">${addSVG}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="linha-1" class="linha fim">
                <div id="h-line-edit-proc-1" class="b-line centralizado">${responseData.mensagem}</div>
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