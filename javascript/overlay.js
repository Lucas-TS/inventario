let closeTimeout; // Variável para armazenar a referência do timeout

function exibirOverlay(pagina) {
    return new Promise((resolve) => {
        ShowObjectWithEffect('overlay', 1, 'fade', 200);
        paginaOverlay(pagina);
        setTimeout(resolve, 200); // Tempo ajustado conforme o fade
    });
}

function exibirOverlayEditar(id, tabela) {
    let arquivo = './overlay/';
    switch (tabela) {
        case 'militares':
            arquivo += 'edit_mil_overlay.php';
            editarMilOverlay(id, arquivo);
            break;
        case 'secao':
            arquivo += 'edit_sec_overlay.php';
            editarSecOverlay(id, arquivo);
            break;
        case 'users':
            arquivo += 'edit_user_overlay.php';
            editarUserOverlay(id, arquivo);
            break;
        case 'avatar':
            arquivo += 'edit_avatar_overlay.php';
            editarAvatarOverlay(id, arquivo);
            break;
        case 'lista_hd':
            arquivo += 'edit_hd_overlay.php';
            editarHdOverlay(id, arquivo);
            break;
        case 'lista_monitor':
            arquivo += 'edit_mon_overlay.php';
            editarMonOverlay(id, arquivo);
            break;
        case 'lista_office':
            arquivo += 'edit_office_overlay.php';
            editarOfficeOverlay(id, arquivo);
            break;
        case 'lista_placa_video':
            arquivo += 'edit_pv_overlay.php';
            editarPvOverlay(id, arquivo);
            break;
        case 'lista_processador':
            arquivo += 'edit_proc_overlay.php';
            editarProcOverlay(id, arquivo);
            break;
        case 'lista_so':
            arquivo += 'edit_so_overlay.php';
            editarSoOverlay(id, arquivo);
            break;
        case 'lista_ssd':
            arquivo += 'edit_ssd_overlay.php';
            editarSsdOverlay(id, arquivo);
            break;
        case 'computadores':
            arquivo = './edit_pc.php?id=' + id;
            window.location.href = arquivo; // Redirecionar para a página
            break;
        default:
            return;
    }
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
        setTimeout(() => {
            initializeListeners();
        }, 1000); 
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
            <div id="fecharOverlay" class="flex-center icon-button margin-bottom rotated-icon"><a title="Fechar" href="#" onclick="ShowObjectWithEffect('overlay', 0, 'fade', 200);">${addSVG}</a></div>
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
                    <option value="10" ${preferenciasAtuais.resultadosPorPagina == 10 ? 'selected' : ''}>10</option>
                    <option value="25" ${preferenciasAtuais.resultadosPorPagina == 25 ? 'selected' : ''}>25</option>
                    <option value="50" ${preferenciasAtuais.resultadosPorPagina == 50 ? 'selected' : ''}>50</option>
                    <option value="100" ${preferenciasAtuais.resultadosPorPagina == 100 ? 'selected' : ''}>100</option>
                    <option value="todos" ${preferenciasAtuais.resultadosPorPagina == 'todos' ? 'selected' : ''}>Todos</option>
                </select>
            </div>
        </div>
    `;

    overlayContent += `
        <div id="linha-3" class="linha">
            <div id="h-line-filtro-3" class="h-line">Filtrar por status:</div>
            <div id="b-line-filtro-3" class="b-line">
                <input type="checkbox" id="filtro-ativo" name="filtroAtivo" class="checkbox" value="1" ${preferenciasAtuais.filtroAtivo ? 'checked' : ''}>
                <label for="filtro-ativo"><span></span>Ativo</label>
                <input type="checkbox" id="filtro-inativo" name="filtroInativo" class="checkbox" value="0" ${preferenciasAtuais.filtroInativo ? 'checked' : ''}>
                <label for="filtro-inativo"><span></span>Inativo</label>
            </div>
        </div>
    `;

    overlayContent += `
        <div id="linha-4" class="linha">
            <div id="h-line-filtro-4" class="h-line">Salvar Configuração:</div>
            <div id="b-line-filtro-4" class="b-line">
                <input type="radio" id="salvar-sim" name="salvarConfiguracao" class="radio" value="sim">
                <label for="salvar-sim"><span></span>Sim</label>
                <input type="radio" id="salvar-nao" name="salvarConfiguracao" class="radio" value="nao" checked>
                <label for="salvar-nao"><span></span>Não</label>
            </div>
        </div>
    `;
    
    overlayContent += `
        <div id="linha-7" class="linha fim botoes">
            <div id="botoes">
                <div id="b-line-filtro-20" class="b-line">
                    <button id="enviar" title="Enviar" class="flex-center large-button" type="button" onclick="aplicarFiltros()">${okSVG}</button>
                </div>
            </div>
        </div>
    `;

    overlayContent += '</form>';
    overlayContent += '</div>';

    document.getElementById('overlay').innerHTML = overlayContent;
    const blocoOverlay = document.getElementById("bloco-overlay");
    const width = blocoOverlay.offsetWidth;
    const height = blocoOverlay.offsetHeight;
    blocoOverlay.style.width = `${width}px`;
    blocoOverlay.style.height = `${height}px`;
    atualizarBotaoMarcarTudo();
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

function atualizarTabela() {
    const params2 = new URLSearchParams(window.location.search);
    if (window.location.pathname.includes('lista.php') && params2.has('tabela')) {
        const novaTabela = params2.get('tabela');
        dadosTabela = [];
        carregarTabela(novaTabela);
    }
}

function closeOverlay() {
    // Limpa o timeout caso o overlay seja fechado manualmente
    clearTimeout(closeTimeout);
    
    // Limpa o conteúdo da div #overlay
    document.getElementById('overlay').innerHTML = "";
    ShowObjectWithEffect('overlay', 0, 'fade', 200);
    atualizarTabela();
}


async function insertDsk(event) {
    event.preventDefault(); // Impede o envio padrão do formulário

    const tipo = document.querySelector('input[name="tipo-add-dsk"]:checked')?.value;

    if (!tipo) {
        alert("Por favor, selecione um tipo de disco.");
        return;
    }

    const campoTamanho = document.getElementById('tam-add-ssd');

    // Atualiza o ID e name do campo de tamanho conforme o tipo
    if (tipo === 'HD') {
        campoTamanho.id = 'tam-add-hd';
        campoTamanho.name = 'tam-add-hd';

        // Atualiza os radio buttons de unidade
        document.querySelectorAll('input[name="un-add-ssd"]').forEach(radio => {
            radio.name = 'un-add-hd';
        });

        await insertHd(event);
    } else if (tipo === 'SSD') {
        campoTamanho.id = 'tam-add-ssd';
        campoTamanho.name = 'tam-add-ssd';

        document.querySelectorAll('input[name="un-add-hd"]').forEach(radio => {
            radio.name = 'un-add-ssd';
        });

        await insertSsd(event);
    }
}