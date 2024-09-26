let colunasSelecionadas = [];

function exibirOverlay(pagina) {
    ShowObjectWithEffect('overlay', 1, 'fade', 200);
    paginaOverlay(pagina);
    return false;
}

function paginaOverlay(nomeArquivo) {
    fetch(nomeArquivo)
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro ao carregar o arquivo: ' + response.statusText);
            }
            return response.text();
        })
        .then(data => {
            document.getElementById('overlay').innerHTML = data;
        })
        .catch(error => {
            console.error('Erro:', error);
        });
}

function mensagemOverlay(text) {
    fetch(nomeArquivo)
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro ao carregar o arquivo: ' + response.statusText);
            }
            return response.text();
        })
        .then(data => {
            document.getElementById('overlay').innerHTML = data;
        })
        .catch(error => {
            console.error('Erro:', error);
        });
}

function exibirOverlayComCheckboxes(colunas, colunasSelecionadas = []) {
    ShowObjectWithEffect('overlay', 1, 'fade', 200);

    let overlayContent = '<div id="bloco-overlay" class="bloco-overlay" onclick="event.stopPropagation();">';
    overlayContent += '<h3>Selecione as colunas para exibir</h3>';
    overlayContent += '<form id="formCheckboxes">';

    colunas.forEach(coluna => {
        const checked = colunasSelecionadas.includes(coluna) ? 'checked' : '';
        overlayContent += `
            <div>
                <input type="checkbox" id="${coluna}" name="colunas" value="${coluna}" ${checked}>
                <label for="${coluna}">${coluna}</label>
            </div>
        `;
    });

    overlayContent += `
        <div>
            <input type="checkbox" id="salvarConfiguracao" name="salvarConfiguracao">
            <label for="salvarConfiguracao">Salvar Configuração</label>
        </div>
    `;

    overlayContent += '</form>';
    overlayContent += '<button type="button" id="toggleAll" onclick="toggleMarcarTudo()">Marcar Tudo</button>';
    overlayContent += '<button type="button" onclick="inverterSelecao()">Inverter Seleção</button>';
    overlayContent += '<button type="button" onclick="aplicarFiltros()">Aplicar</button>';
    overlayContent += '</div>';

    document.getElementById('overlay').innerHTML = overlayContent;
    atualizarBotaoMarcarTudo();
}

function aplicarFiltros() {
    const checkboxes = document.querySelectorAll('#formCheckboxes input[name="colunas"]');
    colunasSelecionadas = Array.from(checkboxes)
        .filter(checkbox => checkbox.checked)
        .map(checkbox => checkbox.value);

    const salvarConfiguracao = document.getElementById('salvarConfiguracao').checked;

    if (salvarConfiguracao) {
        salvarPreferencias(nomeTabela, colunasSelecionadas);
    }

    renderizarTabela(dadosTabela, 1, parseInt(document.getElementById('resultadosPorPagina').value), colunasSelecionadas);
    ShowObjectWithEffect('overlay', 0, 'fade', 200);
}

function toggleMarcarTudo() {
    const checkboxes = document.querySelectorAll('#formCheckboxes input[name="colunas"]');
    const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);

    checkboxes.forEach(checkbox => checkbox.checked = !allChecked);
    atualizarBotaoMarcarTudo();
}

function atualizarBotaoMarcarTudo() {
    const checkboxes = document.querySelectorAll('#formCheckboxes input[name="colunas"]');
    const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
    const botao = document.getElementById('toggleAll');

    if (allChecked) {
        botao.textContent = 'Desmarcar Tudo';
    } else {
        botao.textContent = 'Marcar Tudo';
    }
}

function inverterSelecao() {
    const checkboxes = document.querySelectorAll('#formCheckboxes input[name="colunas"]');
    checkboxes.forEach(checkbox => checkbox.checked = !checkbox.checked);
    atualizarBotaoMarcarTudo();
}
