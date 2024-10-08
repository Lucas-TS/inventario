let dadosTabela = [];
let colunasSelecionadas = [];
let nomeTabela = '';
const colunasNaoExibirPorPadrao = ['Ativo', 'Geração', 'Socket', 'Seguimento', 'P-Cores', 'E-Cores', 'Turbo', 'Memória'];
let preferenciasAtuais = {
  colunas: [],
  resultadosPorPagina: 10
};
let paginaCarregada = false;
const correspondenciaUnidades = {
  'Clock': ' Ghz', // metros
  'Turbo': ' Ghz', // quilogramas
  'idade': 'anos' // anos
};

window.addEventListener('load', function () {
  paginaCarregada = true;
});

function carregarPreferencias(nomeTabela) {
  const cookies = document.cookie.split('; ');
  const cookie = cookies.find(row => row.startsWith(`preferencias_${nomeTabela}=`));
  if (cookie && paginaCarregada) {
    const preferencias = JSON.parse(cookie.split('=')[1]);
    preferenciasAtuais = preferencias;
    paginaCarregada = false;
  }
  return preferenciasAtuais;
}

function salvarPreferencias(nomeTabela, colunasSelecionadas, resultadosPorPagina) {
  preferenciasAtuais.colunas = colunasSelecionadas;
  preferenciasAtuais.resultadosPorPagina = resultadosPorPagina;
  document.cookie = `preferencias_${nomeTabela}=${JSON.stringify(preferenciasAtuais)}; path=/; max-age=31536000`;
}

function criarTabela(dados, colunasSelecionadas = null) {
  const tabela = document.createElement('table');
  tabela.classList = 'tabela-lista';

  const thead = document.createElement('thead');
  const headerRow = document.createElement('tr');
  const colunas = colunasSelecionadas || Object.keys(dados[0]);
  colunas.forEach((coluna, indice) => {
    const th = document.createElement('th');
    th.textContent = coluna;
    th.dataset.coluna = coluna;
    const setaCima = document.createElement('span');
    setaCima.className = 'icone-seta-cima';
    setaCima.classList.add('ordem');
    setaCima.innerHTML = '&#8593;';
    setaCima.addEventListener('click', () => ordenarTabela(dados, coluna, 'asc'));
    const setaBaixo = document.createElement('span');
    setaBaixo.className = 'icone-seta-baixo';
    setaBaixo.classList.add('ordem');
    setaBaixo.innerHTML = '&#8595;';
    setaBaixo.addEventListener('click', () => ordenarTabela(dados, coluna, 'desc'));
    th.appendChild(setaCima);
    th.appendChild(setaBaixo);
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
      let valor = linha[coluna] || '-';
      if (correspondenciaUnidades[coluna]) {
        valor += ` ${correspondenciaUnidades[coluna]}`;
      }
      td.textContent = valor;
      tr.appendChild(td);
    });

    const tdAcoes = document.createElement('td');
    tdAcoes.classList = 'acoes';
    tdAcoes.innerHTML = `
            <!-- <a title="Ver detalhes" class="icone-acao">${viewSVG}</a> -->
            <a title="Editar" class="icone-acao">${editSVG}</a>
            <a title="Apagar" class="icone-acao">${delSVG}</a>
        `;
    tr.appendChild(tdAcoes);

    tbody.appendChild(tr);
  });
  tabela.appendChild(tbody);
  return tabela;
}

function ordenarTabela(dados, coluna, ordem) {
  const dadosOrdenados = dados.sort((a, b) => {
    if (ordem === 'asc') {
      return a[coluna] > b[coluna] ? 1 : -1;
    } else {
      return a[coluna] < b[coluna] ? 1 : -1;
    }
  });

  // Adiciona a classe "ativa" ao elemento SVG correspondente
  const th = document.querySelector(`[data-coluna="${coluna}"]`);
  const seta = ordem === 'asc' ? th.querySelector('.ordem:first-child') : th.querySelector('.ordem:last-child');
  seta.classList.add('ativa');

  renderizarTabela(dadosOrdenados, 1, preferenciasAtuais.resultadosPorPagina, preferenciasAtuais.colunas);
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
  if (dadosTabela.length === 0) {
    $.ajax({
      url: './includes/cria_tabela.php',
      type: 'GET',
      data: { tabela: nomeTabela },
      success: function (response) {
        dadosTabela = JSON.parse(response);
        const preferencias = carregarPreferencias(nomeTabela);
        if (preferencias.colunas && preferencias.colunas.length > 0) {
          preferenciasAtuais.colunas = preferencias.colunas;
          preferenciasAtuais.resultadosPorPagina = preferencias.resultadosPorPagina;
          paginaCarregada = false;
        } else {
          if (colunasSelecionadas && colunasSelecionadas.length > 0) {
            preferenciasAtuais.colunas = colunasSelecionadas
          } else {
            preferenciasAtuais.colunas = Object.keys(dadosTabela[0]).filter(coluna => !colunasNaoExibirPorPadrao.includes(coluna));
          }
          preferenciasAtuais.resultadosPorPagina = resultadosPorPagina;
        }
        renderizarTabela(dadosTabela, pagina, preferenciasAtuais.resultadosPorPagina, preferenciasAtuais.colunas);
      },
      error: function () {
        alert('Erro ao carregar a tabela.');
      }
    });
  } else {
    const preferencias = carregarPreferencias(nomeTabela);
    if (preferencias) {
      preferenciasAtuais.colunas = preferencias.colunas;
      preferenciasAtuais.resultadosPorPagina = preferencias.resultadosPorPagina;
    } else {
      if (colunasSelecionadas) {
        preferenciasAtuais.colunas = colunasSelecionadas
      } else {
        preferenciasAtuais.colunas = Object.keys(dadosTabela[0]).filter(coluna => !colunasNaoExibirPorPadrao.includes(coluna));
      }
      preferenciasAtuais.resultadosPorPagina = resultadosPorPagina;
    }
    renderizarTabela(dadosTabela, pagina, preferenciasAtuais.resultadosPorPagina, preferenciasAtuais.colunas);
  }
}

function mudarResultadosPorPagina(resultadosPorPagina) {
  preferenciasAtuais.resultadosPorPagina = resultadosPorPagina;
  carregarTabela(nomeTabela, 1, resultadosPorPagina);
}

function mudarColunasSelecionadas(colunasSelecionadas) {
  preferenciasAtuais.colunas = colunasSelecionadas;
  carregarTabela(nomeTabela, 1, preferenciasAtuais.resultadosPorPagina);
}

function renderizarTabela(dados, pagina, resultadosPorPagina, colunasSelecionadas = null) {
  const total = dados.length;
  const startIndex = (pagina - 1) * (resultadosPorPagina === 'todos' ? total : resultadosPorPagina);
  const endIndex = resultadosPorPagina === 'todos' ? total : startIndex + resultadosPorPagina;
  const dadosPagina = dados.slice(startIndex, endIndex);

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

$(document).ready(function () {
  // Eventos para overlay de filtros
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  nomeTabela = urlParams.get('tabela'); // Definindo nomeTabela aqui
  carregarTabela(nomeTabela);

  $('#resultadosPorPagina').change(function() {
      const resultadosPorPagina = $(this).val();
      carregarTabela(nomeTabela, 1, resultadosPorPagina);
  });
});