let dadosTabela = [];
let colunasSelecionadas = [];
let nomeTabela = '';
const colunasNaoExibirPorPadrao = ['Ativo', 'Geração', 'Socket', 'Seguimento', 'P-Cores', 'E-Cores', 'Turbo', 'Memória', 'Lacre', 'Garantia', 'Antivirus', 'Rede', 'IP', 'Inclusão', 'Atualizado'];
let preferenciasAtuais = {
  colunas: [],
  resultadosPorPagina: 10
};
let paginaCarregada = false;
const correspondenciaUnidades = {
  'Clock': ' Ghz', // metros
  'Turbo': ' Ghz', // quilogramas
};
let detalhes = {
  svg: "",
  texto: "",
  cor: "#000000"
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

function formatarMAC(enderecoMAC) {
  return enderecoMAC.match(/.{1,2}/g).join(':');
}

function criarTabela(dados, colunasSelecionadas = null, nomeTabela) {
  const todasColunas = Object.keys(dados[0]);
  const colunasExcetoAtivo = todasColunas.filter(coluna => coluna.toLowerCase() !== "ativo");
  const todasColunasExibidas = colunasExcetoAtivo.every(coluna => colunasSelecionadas.includes(coluna));

  const tabela = document.createElement('table');
  tabela.classList = 'tabela-lista';

  const thead = document.createElement('thead');
  const headerRow = document.createElement('tr');
  const colunas = colunasSelecionadas || Object.keys(dados[0]);

  colunas.forEach((coluna, indice) => {
    const th = document.createElement('th');
    th.dataset.coluna = coluna;

    // Criar SVG manualmente
    const setaSVGWrapper = document.createElementNS("http://www.w3.org/2000/svg", "svg");
    setaSVGWrapper.setAttribute("viewBox", "0 0 12 24");
    setaSVGWrapper.setAttribute("class", "icon");

    const path1 = document.createElementNS("http://www.w3.org/2000/svg", "path");
    path1.setAttribute("id", "primary");
    path1.setAttribute("class", "ordem");
    path1.setAttribute("d", "M 4.461298,0.73682249 0.27817068,6.8551356 A 1.9547326,1.9547326 0 0 0 1.6269362,9.7872345 H 9.993192 A 1.9547326,1.9547326 0 0 0 11.341957,6.8551356 L 7.15883,0.73682249 a 1.6028807,1.6028807 0 0 0 -2.697532,0 z");

    const path2 = document.createElementNS("http://www.w3.org/2000/svg", "path");
    path2.setAttribute("id", "secondary");
    path2.setAttribute("class", "ordem");
    path2.setAttribute("d", "m 7.15883,22.713998 4.183127,-6.098766 A 1.9547326,1.9547326 0 0 0 9.993192,13.683133 H 1.6269362 A 1.9547326,1.9547326 0 0 0 0.27817068,16.615232 L 4.461298,22.713998 a 1.6028807,1.6028807 0 0 0 2.697532,0 z");

    setaSVGWrapper.appendChild(path1);
    setaSVGWrapper.appendChild(path2);

    path1.addEventListener('click', () => {
      ordenarTabela(dados, coluna, 'asc');
    });
    path2.addEventListener('click', () => {
      ordenarTabela(dados, coluna, 'desc');
    });

    th.appendChild(setaSVGWrapper);

    // Adicionar o título da coluna após as setas
    const titulo = document.createTextNode(coluna);
    th.appendChild(titulo);

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

      if (coluna.toLowerCase().includes('mac')) {
        valor = formatarMAC(valor);
      }

      if (coluna === "Situação") {

        obterDetalhesSituacao(linha[coluna]);
          td.innerHTML = `
            <div class="situacao">
            ${detalhes.svg} 
            <span class="span-situacao" style="color: ${detalhes.cor};">${detalhes.texto}</span>
            </div>`;
      } else {
        if (correspondenciaUnidades[coluna]) {
          valor += ` ${correspondenciaUnidades[coluna]}`;
        }
        td.textContent = valor;
      }
      tr.appendChild(td);
    });

    const tdAcoes = document.createElement('td');
    tdAcoes.classList = 'acoes';

    // Condicionar a inclusão do link "Ver detalhes"
    if (!todasColunasExibidas) {
      tdAcoes.innerHTML = `<a title="Ver detalhes" class="icone-acao">${viewSVG}</a>`;
    }

    tdAcoes.innerHTML += `
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

  // Renderizar a tabela
  renderizarTabela(dadosOrdenados, 1, preferenciasAtuais.resultadosPorPagina, preferenciasAtuais.colunas);

  // Adicionar a classe "ativa" ao elemento SVG correspondente após renderização
  setTimeout(() => {
    const th = document.querySelector(`[data-coluna="${coluna}"]`);
    const seta = ordem === 'asc' ? th.querySelector('#primary') : th.querySelector('#secondary');
    console.log('Seta encontrada:', seta);
    if (seta) {
      seta.classList.add('ativa');
    } else {
      console.log('Elemento seta não encontrado');
    }
  }, 0);
}

function criarPaginacao(total, paginaAtual, resultadosPorPagina) {
  const totalPaginas = resultadosPorPagina === 'todos' ? 1 : Math.ceil(total / resultadosPorPagina);

  const criarLink = (svg, pagina, classe, title) => {
    const link = document.createElement('a');
    link.href = '#';
    link.innerHTML = svg;
    link.className = classe;
    link.title = title;
    link.onclick = () => {
      carregarTabela(nomeTabela, pagina, resultadosPorPagina);
      return false;
    };
    return link;
  };

  const criarDivComLink = (svg, pagina, classeDiv, classeLink, title) => {
    const div = document.createElement('div');
    div.className = classeDiv;
    div.appendChild(criarLink(svg, pagina, classeLink, title));
    return div;
  };

  const fragment = document.createDocumentFragment();

  if (paginaAtual > 1) {
    if (paginaAtual > 2) {
      fragment.appendChild(criarDivComLink(primeiraSVG, 1, 'botao-seta primeira', 'primeira', 'Primeira página'));
    }
    fragment.appendChild(criarDivComLink(anteriorSVG, paginaAtual - 1, 'botao-seta anterior', 'anterior', 'Página anterior'));
  }

  for (let i = Math.max(1, paginaAtual - 2); i <= Math.min(totalPaginas, paginaAtual + 2); i++) {
    if (i === paginaAtual) {
      const div = document.createElement('div');
      div.className = 'botao-atual';
      div.textContent = i;
      fragment.appendChild(div);
    } else {
      fragment.appendChild(criarDivComLink(i, i, 'botao-numero', 'numero', `Página ${i}`));
    }
  }

  if (paginaAtual < totalPaginas) {
    fragment.appendChild(criarDivComLink(proximoSVG, paginaAtual + 1, 'botao-seta proxima', 'proxima', 'Próxima página'));
    if (paginaAtual < totalPaginas - 1) {
      fragment.appendChild(criarDivComLink(ultimaSVG, totalPaginas, 'botao-seta ultima', 'ultima', 'Última página'));
    }
  }

  return fragment;
}

function carregarTabela(nomeTabela, pagina = 1, resultadosPorPagina = 10) {
  if (!verificarSeTabelaExiste(nomeTabela)) {
    document.getElementById('tabela').innerHTML = 'A tabela "' + nomeTabela + '" não existe!';
    return;
  }

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
            preferenciasAtuais.colunas = colunasSelecionadas;
          } else {
            preferenciasAtuais.colunas = Object.keys(dadosTabela[0]).filter(coluna => !colunasNaoExibirPorPadrao.includes(coluna));
          }
          preferenciasAtuais.resultadosPorPagina = resultadosPorPagina;
        }
        renderizarTabela(dadosTabela, pagina, preferenciasAtuais.resultadosPorPagina, preferenciasAtuais.colunas, Object.keys(dadosTabela[0]));
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
        preferenciasAtuais.colunas = colunasSelecionadas;
      } else {
        preferenciasAtuais.colunas = Object.keys(dadosTabela[0]).filter(coluna => !colunasNaoExibirPorPadrao.includes(coluna));
      }
      preferenciasAtuais.resultadosPorPagina = resultadosPorPagina;
    }
    renderizarTabela(dadosTabela, pagina, preferenciasAtuais.resultadosPorPagina, preferenciasAtuais.colunas, Object.keys(dadosTabela[0]));
  }
}

function verificarSeTabelaExiste(nomeTabela) {
  let existe = false;
  $.ajax({
    url: './includes/conecta_db.php',
    type: 'POST',
    data: { tabela: nomeTabela, funcao: 'teste' },
    async: false,
    success: function (response) {
        if (response.trim() === 'true') {
        existe = true;
      }
    },
    error: function () {
      alert('Erro ao verificar a existência da tabela.');
    }
  });
  return existe;
}

function mudarResultadosPorPagina(resultadosPorPagina) {
  preferenciasAtuais.resultadosPorPagina = resultadosPorPagina;
  carregarTabela(nomeTabela, 1, resultadosPorPagina);
}

function mudarColunasSelecionadas(colunasSelecionadas) {
  preferenciasAtuais.colunas = colunasSelecionadas;
  carregarTabela(nomeTabela, 1, preferenciasAtuais.resultadosPorPagina);
}

function renderizarTabela(dados, pagina, resultadosPorPagina, colunasSelecionadas = null, todasColunas = []) {
  const total = dados.length;
  const startIndex = (pagina - 1) * (resultadosPorPagina === 'todos' ? total : resultadosPorPagina);
  const endIndex = resultadosPorPagina === 'todos' ? total : startIndex + resultadosPorPagina;
  const dadosPagina = dados.slice(startIndex, endIndex);

  const tabela = criarTabela(dadosPagina, colunasSelecionadas, todasColunas);
  document.getElementById('tabela').innerHTML = '';
  document.getElementById('tabela').appendChild(tabela);

  const paginacaoContainer = document.getElementById('paginacao');
  paginacaoContainer.innerHTML = '';

  if (resultadosPorPagina !== 'todos') {
    const paginacao = criarPaginacao(total, pagina, resultadosPorPagina);
    paginacaoContainer.appendChild(paginacao);
  }
}

function buscarTabela() {
  const termoBusca = document.getElementById('input-busca').value.toLowerCase();
  const dadosFiltrados = dadosTabela.filter(item => {
      return Object.values(item).some(valor => 
          valor != null && valor.toString().toLowerCase().includes(termoBusca)
      );
  });
  renderizarTabela(dadosFiltrados, 1, preferenciasAtuais.resultadosPorPagina, preferenciasAtuais.colunas);
}

function obterDetalhesSituacao(situacao) {
  return new Promise((resolve) => {
    switch (situacao) {
      case "0":
        detalhes.svg = okSVG;
        detalhes.texto = "Em uso";
        detalhes.cor = "#008000";
        break;
      case "1":
        detalhes.svg = returnSVG;
        detalhes.texto = "Devolver";
        detalhes.cor = "#01CF73";
        break;
      case "2":
        detalhes.svg = infoSVG;
        detalhes.texto = "Distribuir";
        detalhes.cor = "#2196F3";
        break;
      case "3":
        detalhes.svg = manutSVG;
        detalhes.texto = "Manutenção";
        detalhes.cor = "#FF9800";
        break;
      case "4":
        detalhes.svg = esperaSVG;
        detalhes.texto = "Aguardando peças";
        detalhes.cor = "#02B3C0";
        break;
      case "5":
        detalhes.svg = defeitoSVG;
        detalhes.texto = "Defeito";
        detalhes.cor = "#D50000";
        break;
      case "6":
        detalhes.svg = binSVG;
        detalhes.texto = "Descarregar";
        detalhes.cor = "#7E57C2";
        break;
      default:
        detalhes.svg = "";
        detalhes.texto = "";
        detalhes.cor = "#000000";
    }
    console.log(detalhes);
    resolve(detalhes);
  });
}

$(document).ready(function () {
  // Eventos para overlay de filtros
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  nomeTabela = urlParams.get('tabela'); // Definindo nomeTabela aqui
  carregarTabela(nomeTabela);

  $('#resultadosPorPagina').change(function () {
    const resultadosPorPagina = $(this).val();
    carregarTabela(nomeTabela, 1, resultadosPorPagina);
  });
});