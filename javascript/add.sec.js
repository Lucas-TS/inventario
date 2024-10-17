let closeTimeout; // Variável para armazenar a referência do timeout

async function insertSec(event) {
    event.preventDefault(); // Previne o comportamento padrão do formulário

    // Capturar valor do campo de texto ou definir como nulo
    let sigla = document.getElementById('sigla-add-sec').value;
    let nome = document.getElementById('nome-add-sec').value;

    let formData = {
        sigla: sigla,
        nome: nome,
    };

    try {
        let response = await fetch('./includes/inserir_sec.php', {
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
                throw new Error('Erro ao inserir a seção.');
            }
        }

        let overlay = document.getElementById('overlay');
        overlay.innerHTML = `
        <div id="add_sec" class="bloco-overlay">
            <div class="header">
                <span>Adicionar Seção</span>
                <div id="botoes">
                    <div id="b-line-header-1" class="b-line">
                    <div id="fecharOverlay" class="flex-center icon-button margin-bottom rotated-icon"><a title="Fechar" href="#" onclick="closeOverlay()">${addSVG}</a></div>
                </div>
            </div>
        </div>
        <div id="linha-1" class="linha fim">
            <div id="h-line-add-sec-1" class="h-line centralizado">${sigla} inserida com sucesso!</div>
        </div>
        <div id="linha-2" class="linha fim centralizado">
            <div id="b-line-1" class="b-line">
                <div id="okOverlay" class="large-button adjust-position flex-center"><a title="Ok" href="#" onclick="closeOverlay()">${okSVG}</a></div>
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