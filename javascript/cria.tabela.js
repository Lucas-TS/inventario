let dadosTabela = [];
let nomeTabela = '';
const colunasNaoExibirPorPadrao = ['Ativo', 'Geração', 'Socket', 'Seguimento', 'P-Cores', 'E-Cores', 'Turbo', 'Memória'];

function carregarPreferencias(nomeTabela) {
    const cookies = document.cookie.split('; ');
    const cookie = cookies.find(row => row.startsWith(`preferencias_${nomeTabela}=`));
    if (cookie) {
        const preferencias = JSON.parse(cookie.split('=')[1]);
        return preferencias;
    }
    return null;
}

function salvarPreferencias(nomeTabela, colunasSelecionadas, resultadosPorPagina) {
    const preferencias = { colunas: colunasSelecionadas, resultadosPorPagina: resultadosPorPagina };
    document.cookie = `preferencias_${nomeTabela}=${JSON.stringify(preferencias)}; path=/; max-age=31536000`;
}

function criarTabela(dados, colunasSelecionadas = null) {
    const tabela = document.createElement('table');
    tabela.className = 'tabela-lista';

    const thead = document.createElement('thead');
    const headerRow = document.createElement('tr');
    const colunas = colunasSelecionadas || Object.keys(dados[0]);
    colunas.forEach(coluna => {
        const th = document.createElement('th');
        th.textContent = coluna; 
        headerRow.appendChild(th);
    });

    const thAcoes = document.createElement('th');
    thAcoes.textContent = 'Ações';
    headerRow.appendChild(thAcoes);

    thead.appendChild(headerRow);
    tabela.appendChild(thead);

    const tbody = document.createElement('tbody');
    dados.forEach(linha => {
        const tr = document.createElement('tr');
        colunas.forEach(coluna => {
            const td = document.createElement('td');
            td.textContent = linha[coluna];
            tr.appendChild(td);
        });

        const tdAcoes = document.createElement('td');
        tdAcoes.classList = 'acoes';
        tdAcoes.innerHTML = `
            <a title="Ver detalhes" class="icone-acao">${viewSVG}</a>
            <a title="Editar" class="icone-acao">${editSVG}</a>
            <a title="Apagar" class="icone-acao">${delSVG}</a>
        `;
        tr.appendChild(tdAcoes);

        tbody.appendChild(tr);
    });
    tabela.appendChild(tbody);

    return tabela;
}

function criarPaginacao(total, paginaAtual, resultadosPorPagina) {
    const totalPaginas = resultadosPorPagina === 'todos' ? 1 : Math.ceil(total / resultadosPorPagina);

    const criarLink = (svg, pagina, classe) => {
        const link = document.createElement('a');
        link.href = '#';
        link.innerHTML = svg;
        link.className = classe;
        link.onclick = () => {
            carregarTabela(nomeTabela, pagina, resultadosPorPagina);
            return false;
        };
        return link;
    };

    const criarDivComLink = (svg, pagina, classeDiv, classeLink) => {
        const div = document.createElement('div');
        div.className = classeDiv;
        div.appendChild(criarLink(svg, pagina, classeLink));
        return div;
    };

    const fragment = document.createDocumentFragment();

    if (paginaAtual > 1) {
        if (paginaAtual > 2) {
            fragment.appendChild(criarDivComLink(primeiraSVG, 1, 'botao-seta primeira', 'primeira'));
        }
        fragment.appendChild(criarDivComLink(anteriorSVG, paginaAtual - 1, 'botao-seta anterior', 'anterior'));
    }

    for (let i = Math.max(1, paginaAtual - 2); i <= Math.min(totalPaginas, paginaAtual + 2); i++) {
        if (i === paginaAtual) {
            const div = document.createElement('div');
            div.className = 'botao-atual';
            div.textContent = i;
            fragment.appendChild(div);
        } else {
            fragment.appendChild(criarDivComLink(i, i, 'botao-numero', 'numero'));
        }
    }

    if (paginaAtual < totalPaginas) {
        fragment.appendChild(criarDivComLink(proximoSVG, paginaAtual + 1, 'botao-seta proxima', 'proxima'));
        if (paginaAtual < totalPaginas - 1) {
            fragment.appendChild(criarDivComLink(ultimaSVG, totalPaginas, 'botao-seta ultima', 'ultima'));
        }
    }

    return fragment;
}

function carregarTabela(nomeTabela, pagina = 1, resultadosPorPagina = 10) {
    console.log("carregarTabela - resultadosPorPagina:", resultadosPorPagina);
    if (dadosTabela.length === 0) {
        $.ajax({
            url: './includes/cria_tabela.php',
            type: 'GET',
            data: { tabela: nomeTabela },
            success: function(response) {
                dadosTabela = JSON.parse(response);
                const preferencias = carregarPreferencias(nomeTabela);
                colunasSelecionadas = preferencias ? preferencias.colunas : Object.keys(dadosTabela[0]).filter(coluna => !colunasNaoExibirPorPadrao.includes(coluna));
                resultadosPorPagina = preferencias ? preferencias.resultadosPorPagina : resultadosPorPagina;
                console.log("carregarTabela - preferencias resultadosPorPagina:", resultadosPorPagina);
                renderizarTabela(dadosTabela, pagina, resultadosPorPagina, colunasSelecionadas);
                // Atualizar o valor de resultadosPorPagina no overlay
                $('#resultadosPorPaginaOverlay').val(resultadosPorPagina);
            },
            error: function() {
                alert('Erro ao carregar a tabela.');
            }
        });
    } else {
        const preferencias = carregarPreferencias(nomeTabela);
        colunasSelecionadas = preferencias ? preferencias.colunas : Object.keys(dadosTabela[0]).filter(coluna => !colunasNaoExibirPorPadrao.includes(coluna));
        resultadosPorPagina = preferencias ? preferencias.resultadosPorPagina : resultadosPorPagina;
        console.log("carregarTabela - preferencias resultadosPorPagina:", resultadosPorPagina);
        renderizarTabela(dadosTabela, pagina, resultadosPorPagina, colunasSelecionadas);
        // Atualizar o valor de resultadosPorPagina no overlay
        $('#resultadosPorPaginaOverlay').val(resultadosPorPagina);
    }
}

function renderizarTabela(dados, pagina, resultadosPorPagina, colunasSelecionadas = null) {
    const total = dados.length;
    const inicio = (pagina - 1) * (resultadosPorPagina === 'todos' ? total : resultadosPorPagina);
    const fim = resultadosPorPagina === 'todos' ? total : inicio + resultadosPorPagina;
    const dadosPagina = dados.slice(inicio, fim);

    const tabela = criarTabela(dadosPagina, colunasSelecionadas);
    document.getElementById('tabela').innerHTML = '';
    document.getElementById('tabela').appendChild(tabela);

    const paginacaoContainer = document.getElementById('paginacao');
    paginacaoContainer.innerHTML = '';

    if (resultadosPorPagina !== 'todos') {
        const paginacao = criarPaginacao(total, pagina, resultadosPorPagina);
        paginacaoContainer.appendChild(paginacao);
    }
}

$(document).ready(function() {

});