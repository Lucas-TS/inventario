function confirmaApagar(id, local) {
    let overlayApagar = document.getElementById('overlay')
    overlayApagar.innerHTML = `
    <div id="bloco-overlay" class="bloco-overlay" style="width:450px">
        <div class="header">
            <span>Remover</span>
            <div id="b-line-header-1" class="b-line">
            </div>
        </div>
    <div id="linha-1" class="linha fim">
        <div id="b-line-del-1" class="b-line centralizado" style="width:100%">Tem certeza que deja remover este registro?</div>
        <div id="b-line-del-2" class="b-line centralizado" style="width:100%;font-weight:bold">» ID ${id} da tabela ${local}</div>
    </div>
    <div id="linha-2" class="linha fim centralizado">
        <div id="b-line-del-3" class="b-line">
            <div id="fecharOverlay" class="large-button adjust-position flex-center"><a title="Cancelar" href="#" onclick="ShowObjectWithEffect('overlay', 0, 'fade', 200);">${rejectSVG}</a></div>
        </div>
        <div id="h-spacer"></div>
        <div id="b-line-del-4" class="b-line">
            <div id="okOverlay" class="large-button adjust-position flex-center"><a title="Ok" href="#" onclick="apagarItem(${id}, '${local}')">${okSVG}</a></div>
        </div>
    </div>
    `;
    ShowObjectWithEffect('overlay', 1, 'fade', 200);
}

async function apagarItem(id, local) {
    let formData = {
        id: id,
        tabela: local,
    };

    try {
        let response = await fetch('./includes/apagar_item.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=UTF-8'
            },
            body: JSON.stringify(formData)
        });

        let data = await response.json();

        if (!response.ok) {
            throw new Error(data.error || 'Erro ao remover a linha do banco de dados.');
        }

        if (data.error) {
            throw new Error(data.error);
        }

        let overlayApagar = document.getElementById('overlay');
        overlayApagar.innerHTML = `
        <div id="bloco-overlay" class="bloco-overlay">
            <div class="header">
                <span>Remover</span>
                <div id="botoes">
                    <div id="b-line-header-1" class="b-line">
                        <div id="fecharOverlay" class="flex-center icon-button margin-bottom rotated-icon">
                            <a title="Fechar" href="#" onclick="closeOverlay()">${addSVG}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="linha-1" class="linha fim">
                <div id="b-line-1" class="b-line centralizado">${data.message || 'Item removido com sucesso!'}</div>
            </div>
            <div id="linha-2" class="linha fim centralizado">
                <div id="b-line-2" class="b-line">
                    <div id="okOverlay" class="large-button adjust-position flex-center">
                        <a title="Ok" href="#" onclick="closeOverlay()">${okSVG}</a>
                    </div>
                </div>
            </div>
        </div>
        `;

        atualizarTabela();
        if (local === 'users') {
            
        }
        
        // Fechar o overlay após a inserção com um retardo de 5 segundos
        closeTimeout = setTimeout(function () {
            closeOverlay();
        }, 5000); // 5000 milissegundos = 5 segundos
    } catch (error) {
        alert(error.message); // Exibe um alert com a mensagem de erro
    }
}