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

function insertProc(event) {
    event.preventDefault(); // Previne o comportamento padrão do formulário

    // Capturar valores dos checkboxes marcados
    var memoriaValues = [];
    var checkboxes = document.querySelectorAll('#linha-5 input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
            memoriaValues.push(checkbox.value);
        }
    });

    // Capturar valor do campo de texto ou definir como nulo
    var igpuValue = document.getElementById('off-proc').checked ? null : document.getElementById('modelo-igpu-proc').value;
    let marca = document.getElementById('marca-proc').value;
    let modelo = document.getElementById('modelo-proc').value;

    var formData = {
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

    console.log(formData);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "./includes/inserir_proc.php", true);
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) { // Verifica se a requisição foi concluída
            var overlay = document.getElementById('overlay'); // Seleciona a div com o ID 'overlay'
            if (xhr.status === 200) { // Verifica se a resposta do servidor foi bem-sucedida (status 200)
                overlay.innerHTML = `
                <div id="add_proc" class="bloco-overlay">
                    <div class="header">
                        <span>Adicionar Processador</span>
                        <div id="botoes">
                            <div id="b-line-header-1" class="b-line">
                            <div id="fecharOverlay" class="flex-center icon-button margin-bottom rotated-icon adjust-position"><a title="Fechar" href="#" onclick="ShowObjectWithEffect('overlay', 0, 'fade', 200);">${maisSVG}</a></div>
                        </div>
                    </div>
                </div>
                <div id="linha-1" class="linha fim">
                    <div id="h-line-add-proc-1" class="h-line centralizado">${marca} ${modelo} inserido com sucesso!</div>
                </div>
                <div id="linha-2" class="linha fim centralizado">
                    <div id="b-line-1" class="b-line">
                        <div id="okOverlay" class="large-button"><a title="Ok" href="#" onclick="ShowObjectWithEffect('overlay', 0, 'fade', 200);">${okSVG}</a></div>
                    </div>
                </div>
                `; // Insere a mensagem de sucesso na div 'overlay'
                // Fechar o overlay após a inserção com um retardo de 5 segundos
                setTimeout(function() {
                    ShowObjectWithEffect('overlay', 0, 'fade', 200); // Função para fechar o overlay com efeito de fade
                }, 5000); // 5000 milissegundos = 5 segundos
            } else {
                alert("Erro: " + xhr.statusText); // Exibe um alert com a mensagem de erro
            }
        }
    };
    xhr.send(JSON.stringify(formData));
}