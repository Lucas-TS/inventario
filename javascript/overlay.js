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

function exibirOverlayComCheckboxes(colunas, colunasSelecionadas = [], resultadosPorPaginaSelecionado = 10) {
    ShowObjectWithEffect('overlay', 1, 'fade', 200);
  
    const colunasPorColuna = Math.ceil(colunas.length / 3);
    const colunasOrganizadas = [[], [], []];
  
    colunas.forEach((coluna, index) => {
      const colunaIndex = Math.floor(index / colunasPorColuna);
      colunasOrganizadas[colunaIndex].push(coluna);
    });
  
    let overlayContent = '<div id="bloco-overlay" class="bloco-overlay">';
    overlayContent += `
      <div class="header">
        <span>Opções de visualização</span>
        <div id="botoes">
          <div id="b-line-header-1" class="b-line">
            <div id="fecharOverlay" class="flex-center icon-button margin-bottom rotated-icon adjust-position"><a title="Fechar" href="#" onclick="ShowObjectWithEffect('overlay', 0, 'fade', 200);">${maisSVG}</a></div>
          </div>
        </div>
      </div>
    `;
    overlayContent += '<form id="formCheckboxes">';
  
    overlayContent += `
      <div id="linha-1" class="linha">
        <div id="h-line-filtro-1" class="h-line filtro">Colunas para exibir:
          <div class="seletor-colunas">
            <a id="toggleAll" onclick="toggleMarcarTudo()">Marcar Tudo</a>
            <span> | </span>
            <a onclick="inverterSelecao()">Inverter Seleção</a>
          </div>
        </div>
        <div class="checkbox-container">
    `;
    for (let i = 0; i < 3; i++) {
      overlayContent += '<div class="checkbox-column">';
      colunasOrganizadas[i].forEach(coluna => {
        const checked = colunasSelecionadas.includes(coluna) ? 'checked' : '';
        overlayContent += `
          <div class="b-line">
            <input type="checkbox" id="${coluna}" name="colunas" class="checkbox" value="${coluna}" ${checked}>
            <label for="${coluna}"><span></span>${coluna}</label>
          </div>
        `;
      });
      overlayContent += '</div>';
    }
    overlayContent += '</div></div>';

    overlayContent += `
        <div id="linha-2" class="linha">
            <div id="h-line-filtro-2" class="h-line">Resultados por página:</div>
            <div id="b-line-filtro-2" class="b-line">
                <select id="resultadosPorPaginaOverlay" name="resultadosPorPagina" class="select">
                    <option value="2" ${preferenciasAtuais.resultadosPorPagina == 2 ? 'selected' : ''}>2</option>
                    <option value="5" ${preferenciasAtuais.resultadosPorPagina == 5 ? 'selected' : ''}>5</option>
                    <option value="10" ${preferenciasAtuais.resultadosPorPagina == 10 ? 'selected' : ''}>10</option>
                    <option value="50" ${preferenciasAtuais.resultadosPorPagina == 50 ? 'selected' : ''}>50</option>
                    <option value="todos" ${preferenciasAtuais.resultadosPorPagina == 'todos' ? 'selected' : ''}>Todos</option>
                </select>
            </div>
        </div>
    `;

    overlayContent += `
        <div id="linha-3" class="linha">
            <div id="h-line-filtro-3" class="h-line">Salvar Configuração:</div>
            <div id="b-line-filtro-3" class="b-line">
                <input type="radio" id="salvar-sim" name="salvarConfiguracao" class="radio" value="sim" checked>
                <label for="salvar-sim"><span></span>Sim</label>
                <input type="radio" id="salvar-nao" name="salvarConfiguracao" class="radio" value="nao">
                <label for="salvar-nao"><span></span>Não</label>
            </div>
        </div>
    `;

    overlayContent += `
        <div id="linha-7" class="linha fim botoes">
            <div id="botoes">
                <div id="b-line-filtro-20" class="b-line">
                    <button id="enviar" class="flex-center large-button" type="button" onclick="aplicarFiltros()">${okSVG}</button>
                </div>
            </div>
        </div>
    `;

    overlayContent += '</form>';
    overlayContent += '</div>';

    document.getElementById('overlay').innerHTML = overlayContent;
    atualizarBotaoMarcarTudo();
}

function aplicarFiltros() {
    const checkboxes = document.querySelectorAll('#formCheckboxes input[name="colunas"]');
    colunasSelecionadas = Array.from(checkboxes)
        .filter(checkbox => checkbox.checked)
        .map(checkbox => checkbox.value);

    const salvarConfiguracao = document.querySelector('input[name="salvarConfiguracao"]:checked').value === 'sim';
    const resultadosPorPagina = document.getElementById('resultadosPorPaginaOverlay').value === 'todos' ? 'todos' : parseInt(document.getElementById('resultadosPorPaginaOverlay').value, 10);

    preferenciasAtuais = {
        colunas: colunasSelecionadas,
        resultadosPorPagina: resultadosPorPagina
    };

    if (salvarConfiguracao) {
        salvarPreferencias(nomeTabela, colunasSelecionadas, resultadosPorPagina);
    }
    renderizarTabela(dadosTabela, 1, resultadosPorPagina, colunasSelecionadas);
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
