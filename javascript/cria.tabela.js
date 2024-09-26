let dadosTabela = [];
let nomeTabela = '';
const colunasNaoExibirPorPadrao = ['ativo', 'coluna2', 'coluna3']; // Substitua pelos nomes das colunas que não devem ser exibidas

function carregarPreferencias(nomeTabela) {
    const cookies = document.cookie.split('; ');
    const cookie = cookies.find(row => row.startsWith(`preferencias_${nomeTabela}=`));
    if (cookie) {
        const preferencias = JSON.parse(cookie.split('=')[1]);
        return preferencias.colunas;
    }
    return null;
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

    // Adiciona uma coluna para ações
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

        // Adiciona as ações na última coluna
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
    const totalPaginas = Math.ceil(total / resultadosPorPagina);

    const criarLink = (texto, pagina, classe) => {
        const link = document.createElement('a');
        link.href = '#';
        link.textContent = texto;
        link.className = classe;
        link.onclick = () => {
            carregarTabela(nomeTabela, pagina, resultadosPorPagina);
            return false;
        };
        return link;
    };

    const fragment = document.createDocumentFragment();

    if (paginaAtual > 1) {
        fragment.appendChild(criarLink('<<', 1, 'primeira'));
        fragment.appendChild(criarLink('<', paginaAtual - 1, 'anterior'));
    }

    for (let i = Math.max(1, paginaAtual - 2); i <= Math.min(totalPaginas, paginaAtual + 2); i++) {
        const classe = i === paginaAtual ? 'atual' : 'numero';
        fragment.appendChild(criarLink(i, i, classe));
    }

    if (paginaAtual < totalPaginas) {
        fragment.appendChild(criarLink('>', paginaAtual + 1, 'proxima'));
        fragment.appendChild(criarLink('>>', totalPaginas, 'ultima'));
    }

    return fragment;
}

function carregarTabela(nomeTabela, pagina = 1, resultadosPorPagina = 10) {
    if (dadosTabela.length === 0) {
        $.ajax({
            url: './includes/cria_tabela.php',
            type: 'GET',
            data: { tabela: nomeTabela },
            success: function(response) {
                dadosTabela = JSON.parse(response);
                colunasSelecionadas = carregarPreferencias(nomeTabela) || Object.keys(dadosTabela[0]).filter(coluna => !colunasNaoExibirPorPadrao.includes(coluna));
                renderizarTabela(dadosTabela, pagina, resultadosPorPagina, colunasSelecionadas);
            },
            error: function() {
                alert('Erro ao carregar a tabela.');
            }
        });
    } else {
        colunasSelecionadas = carregarPreferencias(nomeTabela) || Object.keys(dadosTabela[0]).filter(coluna => !colunasNaoExibirPorPadrao.includes(coluna));
        renderizarTabela(dadosTabela, pagina, resultadosPorPagina, colunasSelecionadas);
    }
}

function renderizarTabela(dados, pagina, resultadosPorPagina, colunasSelecionadas = null) {
    const total = dados.length;
    const inicio = (pagina - 1) * resultadosPorPagina;
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
    const queryString = window.location.search;

    const urlParams = new URLSearchParams(queryString);

    const valor = urlParams.get('tabela');

    carregarTabela(valor);
});