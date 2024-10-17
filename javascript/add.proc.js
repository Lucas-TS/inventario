function liberaModeloIGPU() {
    let igpu = document.getElementById('modelo-igpu-proc');
    igpu.required = true;
    igpu.disabled = false;
}

function desativaModeloIGPU() {
    let igpu = document.getElementById('modelo-igpu-proc');
    igpu.value = '';
    igpu.required = false;
    igpu.disabled = true;
}

let closeTimeout; // Variável para armazenar a referência do timeout

async function insertProc(event) {
    event.preventDefault(); // Previne o comportamento padrão do formulário

    // Capturar valores dos checkboxes marcados
    const memoriaValues = [];
    const checkboxes = document.querySelectorAll('#linha-5 input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
            memoriaValues.push(checkbox.value);
        }
    });

    // Capturar valor do campo de texto ou definir como nulo
    const igpuValue = document.getElementById('off-proc').checked ? null : document.getElementById('modelo-igpu-proc').value;
    const marca = document.getElementById('marca-proc').value;
    const modelo = document.getElementById('modelo-proc').value;

    const formData = {
        marca: document.getElementById('marca-proc').value,
        modelo: document.getElementById('modelo-proc').value,
        geracao: document.getElementById('ger-proc').value,
        socket: document.getElementById('skt-proc').value,
        seguimento: document.getElementById('seg-proc').value,
        pcores: document.getElementById('pcores-proc').value,
        ecores: document.getElementById('ecores-proc').value,
        threads: document.getElementById('threads-proc').value,
        clock: document.getElementById('clock-proc').value,
        turbo: document.getElementById('turbo-proc').value,
        memoria: memoriaValues.join(', '), // Unir valores dos checkboxes marcados
        igpu: igpuValue // Valor do campo de texto ou nulo
    };

    try {
        const response = await fetch('./includes/inserir_proc.php', {
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
                    <div id="fecharOverlay" class="flex-center icon-button margin-bottom rotated-icon"><a title="Fechar" href="#" onclick="closeOverlay()">${addSVG}</a></div>
                </div>
            </div>
        </div>
        <div id="linha-1" class="linha fim">
            <div id="h-line-add-proc-1" class="h-line centralizado">${marca} ${modelo} inserido com sucesso!</div>
        </div>
        <div id="linha-2" class="linha fim centralizado">
            <div id="b-line-1" class="b-line">
                <div id="okOverlay" class="large-button adjust-position flex-center"><a title="Ok" href="#" onclick="closeOverlay()">${okSVG}</a></div>
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