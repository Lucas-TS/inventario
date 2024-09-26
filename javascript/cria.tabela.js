let dadosTabela = [];
let nomeTabela = '';

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
    tabela.cellSpacing = '0';

    // Cria o cabeçalho da tabela
    const thead = document.createElement('thead');
    const headerRow = document.createElement('tr');
    const colunas = colunasSelecionadas || Object.keys(dados[0]);
    colunas.forEach(coluna => {
        const th = document.createElement('th');
        th.textContent = coluna; // Use o nome da coluna diretamente
        headerRow.appendChild(th);
    });
    thead.appendChild(headerRow);
    tabela.appendChild(thead);

    // Cria o corpo da tabela
    const tbody = document.createElement('tbody');
    dados.forEach(linha => {
        const tr = document.createElement('tr');
        colunas.forEach(coluna => {
            const td = document.createElement('td');
            td.textContent = linha[coluna];
            tr.appendChild(td);
        });
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
                colunasSelecionadas = carregarPreferencias(nomeTabela) || Object.keys(dadosTabela[0]); // Carrega preferências ou todas as colunas
                renderizarTabela(dadosTabela, pagina, resultadosPorPagina, colunasSelecionadas);
            },
            error: function() {
                alert('Erro ao carregar a tabela.');
            }
        });
    } else {
        colunasSelecionadas = carregarPreferencias(nomeTabela) || colunasSelecionadas;
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
    nomeTabela = urlParams.get('tabela');

    const selectResultadosPorPagina = document.getElementById('resultadosPorPagina');
    selectResultadosPorPagina.onchange = function() {
        const valor = this.value === 'todos' ? 'todos' : parseInt(this.value);
        carregarTabela(nomeTabela, 1, valor);
    };

    carregarTabela(nomeTabela);
});