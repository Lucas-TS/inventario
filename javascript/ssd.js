let closeTimeout; // Variável para armazenar a referência do timeout

async function insertSsd(event) {
    event.preventDefault(); // Previne o comportamento padrão do formulário

    // Capturar valor do campo de texto ou definir como nulo
    let radios = document.getElementsByName('un-add-ssd');
    let unidade;
    for (let i = 0; i < radios.length; i++) {
        if (radios[i].checked) {
            unidade = radios[i].value;
            break;
        }
    }
    
    let numero = document.getElementById('tam-add-ssd').value;
    let numeroDecimal = parseFloat(numero); // Converter para número decimal
    let numeroInteiro = parseInt(numero, 10); // Converter para número inteiro
    let ehDecimal = (numeroDecimal !== numeroInteiro); // Verificar se é decimal
    
    // Ajustar o número conforme a unidade
    if (ehDecimal && unidade === 'GB') {
        numero = numeroInteiro.toString(); // Desconsiderar a casa decimal
    } else if (!ehDecimal && unidade === 'TB') {
        numero = numero + ",0"; // Acrescentar ",0" ao final
    }
    
    let tamanho = numero + " " + unidade;
    let formData = {
        tamanho: tamanho,
    };

    try {
        let response = await fetch('./includes/inserir_ssd.php', {
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
                throw new Error('Erro ao inserir o SSD.');
            }
        }

        let overlay = document.getElementById('overlay');
        overlay.innerHTML = `
        <div id="add_ssd" class="bloco-overlay">
            <div class="header">
                <span>Adicionar SSD</span>
                <div id="botoes">
                    <div id="b-line-header-1" class="b-line">
                        <div id="fecharOverlay" class="flex-center icon-button margin-bottom rotated-icon">
                            <a title="Fechar" href="#" onclick="closeOverlay()">${addSVG}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="linha-1" class="linha fim">
                <div id="h-line-add-ssd-1" class="h-line centralizado">${tamanho} inserido com sucesso!</div>
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