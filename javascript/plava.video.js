let closeTimeout; // Variável para armazenar a referência do timeout

async function insertPv(event) {
    event.preventDefault(); // Previne o comportamento padrão do formulário

    // Capturar valor do campo de texto ou definir como nulo
    let chipset = document.getElementById('chipset-add-pv').value;
    let marca = document.getElementById('marca-add-pv').value;
    let modelo = document.getElementById('modelo-add-pv').value;
    let qtde = document.getElementById('mem-add-pv').value;
    let tipo = document.getElementById('mem-pv').value;
    let memoria = qtde + " " + tipo;

    let formData = {
        chipset: chipset,
        marca: marca,
        modelo: modelo,
        memoria: memoria,
    };

    try {
        let response = await fetch('./includes/inserir_pv.php', {
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