let dadosTabela = [];
let colunasSelecionadas = [];
let todasColunas = [];
let totalComId = [];

let nomeTabela = "";
const colunasNaoExibirPorPadrao = [
  "Geração",
  "Socket",
  "Seguimento",
  "P-Cores",
  "E-Cores",
  "Turbo",
  "Garantia",
  "Antivirus",
  "Rede",
  "IP",
  "Inclusão",
  "Atualizado",
  "Rede",
  "Wi-Fi",
  "MAC Wi-Fi",
];
let preferenciasAtuais = {
  colunas: [],
  resultadosPorPagina: 25,
};
let paginaCarregada = false;
const correspondenciaUnidades = {
  Clock: " Ghz", // gigahertz
  Turbo: " Ghz", // gigahertz
  "Tamanho da Tela": ' "', // polegadas
};
let detalhes = {
  svg: "",
  texto: "",
  cor: "#000000",
};

async function carregarTabela(
  nomeTabela,
  pagina = 1,
  resultadosPorPagina = 25
) {
  try {
    if (nomeTabela === "computadores") {
      colunasNaoExibirPorPadrao.push("Marca", "Modelo", "GPU");
    }
    if (nomeTabela === "notebooks") {
      colunasNaoExibirPorPadrao.push("GPU", "Monitor");
    }
    if (nomeTabela === "servidores") {
      colunasNaoExibirPorPadrao.push("GPU");
    }

    let tabelaPreferencias = nomeTabela;
    let tabelaFonte = nomeTabela;

    if (nomeTabela === "computadores") {
      nomeTabela += "&tipo=0";
    } else if (nomeTabela === "notebooks") {
      tabelaFonte = "computadores";
      nomeTabela = "computadores&tipo=1";
    } else if (nomeTabela === "servidores") {
      tabelaFonte = "computadores";
      nomeTabela = "computadores&tipo=2";
    }
    if (!(await verificarSeTabelaExiste(tabelaFonte))) {
      document.getElementById("tabela").innerHTML =
        'A tabela "' + tabelaFonte + '" não existe!';
      return;
    }
    let response = await fetch(
      `./includes/cria_tabela.php?tabela=${nomeTabela}`
    );
    if (!response.ok) throw new Error("Erro ao carregar a tabela.");
    let data = await response.text();
    try {
      dadosTabela = JSON.parse(data);
    } catch (error) {
      console.error(
        "Erro ao processar JSON:",
        error,
        "Resposta recebida:",
        data
      );
    }
    const preferencias = carregarPreferencias(tabelaPreferencias);
    if (
      preferencias &&
      preferencias.colunas &&
      preferencias.colunas.length > 0
    ) {
      preferenciasAtuais = {
        ...preferencias,
        filtroAtivo:
          preferencias.filtroAtivo !== undefined
            ? preferencias.filtroAtivo
            : true,
        filtroInativo:
          preferencias.filtroInativo !== undefined
            ? preferencias.filtroInativo
            : false,
      };
    } else {
      preferenciasAtuais = {
        colunas:
          colunasSelecionadas && colunasSelecionadas.length > 0
            ? colunasSelecionadas
            : Object.keys(dadosTabela[0]).filter(
                (coluna) => !colunasNaoExibirPorPadrao.includes(coluna)
              ),
        resultadosPorPagina: resultadosPorPagina,
        filtroAtivo: true,
        filtroInativo: false,
      };
    }
    todasColunas = Object.keys(dadosTabela[0]);
    renderizarTabela(
      dadosTabela,
      pagina,
      preferenciasAtuais.resultadosPorPagina,
      preferenciasAtuais.colunas,
      todasColunas
    );
  } catch (error) {
    console.error("Erro ao carregar tabela:", error);
    document.getElementById("tabela").innerHTML =
      "Erro ao carregar a tabela. Por favor, tente novamente mais tarde.";
  }
}

async function verificarSeTabelaExiste(nomeTabela) {
  try {
    let response = await fetch("./includes/conecta_db.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: new URLSearchParams({
        tabela: nomeTabela,
        funcao: "teste",
      }),
    });

    if (!response.ok)
      throw new Error("Erro ao verificar a existência da tabela.");

    let textResponse = await response.text();
    return textResponse.trim() === "true";
  } catch (error) {
    alert(error.message);
    return false;
  }
}

window.addEventListener("load", function () {
  paginaCarregada = true;
});

function carregarPreferencias(nomeTabela) {
  const cookies = document.cookie.split(";");
  for (let i = 0; i < cookies.length; i++) {
    const cookie = cookies[i].trim();
    if (cookie.trim().startsWith(`preferencias_${nomeTabela}=`)) {
      const preferencias = JSON.parse(
        cookie.replace(`preferencias_${nomeTabela}=`, "")
      );
      preferenciasAtuais = preferencias;
      return preferenciasAtuais; // Retorna as preferências carregadas
    }
  }
  preferenciasAtuais = {
    colunas: [],
    resultadosPorPagina: 10,
    filtroAtivo: true,
    filtroInativo: false, // Por padrão, não exibir inativos
  };
  return preferenciasAtuais; // Retorna as preferências padrão
}

function formatarMAC(enderecoMAC) {
  return enderecoMAC.match(/.{1,2}/g).join(":");
}

function criarTabela(dados, colunasSelecionadas = null, todasColunas) {
  const colunasExcetoAtivoEId = todasColunas.filter(
    (coluna) => coluna.toLowerCase() !== "ativo" && coluna !== "id_link"
  );
  const todasColunasExibidas = colunasExcetoAtivoEId.every((coluna) =>
    colunasSelecionadas.includes(coluna)
  );

  const tabela = document.createElement("table");
  tabela.classList = "tabela-lista";

  const thead = document.createElement("thead");
  const headerRow = document.createElement("tr");
  const colunas = colunasSelecionadas || Object.keys(dados[0]);

  colunas.forEach((coluna, indice) => {
    const th = document.createElement("th");
    th.dataset.coluna = coluna;
    if (coluna === "Ativo") {
      th.style.width = "70px";
    }
    // Criar SVG manualmente
    const setaSVGWrapper = document.createElementNS(
      "http://www.w3.org/2000/svg",
      "svg"
    );
    setaSVGWrapper.setAttribute("viewBox", "0 0 12 24");
    setaSVGWrapper.setAttribute("class", "icon");

    const path1 = document.createElementNS(
      "http://www.w3.org/2000/svg",
      "path"
    );
    path1.setAttribute("id", "primary");
    path1.setAttribute("class", "ordem");
    path1.setAttribute(
      "d",
      "M 4.461298,0.73682249 0.27817068,6.8551356 A 1.9547326,1.9547326 0 0 0 1.6269362,9.7872345 H 9.993192 A 1.9547326,1.9547326 0 0 0 11.341957,6.8551356 L 7.15883,0.73682249 a 1.6028807,1.6028807 0 0 0 -2.697532,0 z"
    );

    const path2 = document.createElementNS(
      "http://www.w3.org/2000/svg",
      "path"
    );
    path2.setAttribute("id", "secondary");
    path2.setAttribute("class", "ordem");
    path2.setAttribute(
      "d",
      "m 7.15883,22.713998 4.183127,-6.098766 A 1.9547326,1.9547326 0 0 0 9.993192,13.683133 H 1.6269362 A 1.9547326,1.9547326 0 0 0 0.27817068,16.615232 L 4.461298,22.713998 a 1.6028807,1.6028807 0 0 0 2.697532,0 z"
    );

    setaSVGWrapper.appendChild(path1);
    setaSVGWrapper.appendChild(path2);

    path1.addEventListener("click", () => {
      ordenarTabela(totalComId, coluna, "asc");
    });

    path2.addEventListener("click", () => {
      ordenarTabela(totalComId, coluna, "desc");
    });

    th.appendChild(setaSVGWrapper);

    // Adicionar o título da coluna após as setas
    const titulo = document.createTextNode(coluna);
    th.appendChild(titulo);
    headerRow.appendChild(th);
  });

  const thAcoes = document.createElement("th");
  thAcoes.textContent = "Ações";
  headerRow.appendChild(thAcoes);
  thead.appendChild(headerRow);
  tabela.appendChild(thead);

  const tbody = document.createElement("tbody");
  dados.forEach((linha) => {
    const tr = document.createElement("tr");

    colunas.forEach((coluna) => {
      const td = document.createElement("td");
      let valor = linha[coluna] || "-";
      if (coluna.toLowerCase().includes("mac")) {
        valor = formatarMAC(valor);
      }
      if (coluna === "Situação") {
        obterDetalhesSituacao(linha[coluna]);
        const svgComCor = detalhes.svg.replace("<svg", `<svg fill="${detalhes.cor}"`);
        td.innerHTML = `
                  <div class="situacao">
                  ${svgComCor} 
                  <span class="span-situacao" style="color: ${detalhes.cor};">${detalhes.texto}</span>
                  </div>`;
      } else if (coluna === "Grupo") {
        valor = linha[coluna] === "0" ? "Usuários" : "Administradores";
        td.textContent = valor;
      } else if (coluna === "Ativo") {
        valor = linha[coluna] === "0" ? inativoSVG : ativoSVG;
        td.innerHTML = valor;
      } else if (coluna === "Wi-Fi" || coluna === "Antivirus") {
        valor = linha[coluna] === "0" ? "Não" : "Sim";
        td.innerHTML = valor;
      } else if (coluna === "Rede") {
        valor = linha[coluna] === "0" ? "Onboard" : "Offboard";
        td.innerHTML = valor;
      } else {
        if (correspondenciaUnidades[coluna]) {
          valor += ` ${correspondenciaUnidades[coluna]}`;
        }
        if (
          coluna === "SSD" ||
          coluna === "HD" ||
          coluna === "Monitor"
        ) {
          valor = valor.replace(/\n/g, "<br>");
          td.innerHTML = valor;
        } else {
          td.textContent = valor;
        }
      }
      tr.appendChild(td);
    });

    const tdAcoes = document.createElement("td");
    tdAcoes.classList = "acoes";

    // Condicionar a inclusão do link "Ver detalhes"
    if (!todasColunasExibidas) {
      tdAcoes.innerHTML = `<a title="Ver detalhes" class="icone-acao" onclick="verItem(${linha.id_link}, '${nomeTabela}')">${viewSVG}</a>`;
    }

    if (nomeTabela === "notebooks" || nomeTabela === "servidores") {
      nomeTabelaAcao = "computadores";
    } else {
      nomeTabelaAcao = nomeTabela;
    }

    tdAcoes.innerHTML += `
              <a title="Editar" class="icone-acao" onclick="exibirOverlayEditar(${linha.id_link}, '${nomeTabelaAcao}')">${editSVG}</a>
              <a title="Apagar" class="icone-acao apagar" onclick="confirmaApagar(${linha.id_link}, '${nomeTabelaAcao}')">${delSVG}</a>
          `;

    tr.appendChild(tdAcoes);
    tbody.appendChild(tr);
  });

  tabela.appendChild(tbody);
  return tabela;
}

function ordenarTabela(dados, coluna, ordem) {
  const dadosOrdenados = dados.sort((a, b) => {
    const valA = isNaN(a[coluna]) ? a[coluna] : Number(a[coluna]);
    const valB = isNaN(b[coluna]) ? b[coluna] : Number(b[coluna]);
    if (ordem === "asc") {
      return valA > valB ? 1 : -1;
    } else {
      return valA < valB ? 1 : -1;
    }
  });

  // Renderizar a tabela
  renderizarTabela(
    dadosOrdenados,
    1,
    preferenciasAtuais.resultadosPorPagina,
    preferenciasAtuais.colunas,
    todasColunas
  );

  // Adicionar a classe "ativa" ao elemento SVG correspondente após renderização
  setTimeout(() => {
    const th = document.querySelector(`[data-coluna="${coluna}"]`);
    const seta =
      ordem === "asc"
        ? th.querySelector("#primary")
        : th.querySelector("#secondary");
    if (seta) {
      seta.classList.add("ativa");
    } else {
      console.log("Elemento seta não encontrado");
    }
  }, 0);
}

function criarPaginacao(total, paginaAtual, resultadosPorPagina) {
  const totalPaginas =
    resultadosPorPagina === "todos"
      ? 1
      : Math.ceil(total / resultadosPorPagina);
  const fragment = document.createDocumentFragment();

  const criarLink = (svg, pagina, classe, title) => {
    const link = document.createElement("a");
    link.href = "#";
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
    const div = document.createElement("div");
    div.className = classeDiv;
    div.innerHTML = svg;

    const link = document.createElement("a");
    link.href = "#";
    link.className = classeLink;
    link.title = title;
    link.onclick = () => {
      carregarTabela(nomeTabela, pagina, resultadosPorPagina);
      return false;
    };

    link.appendChild(div); // Agora o link envolve a div
    return link;
  };

  if (paginaAtual > 1) {
    if (paginaAtual > 2) {
      fragment.appendChild(
        criarDivComLink(
          primeiraSVG,
          1,
          "botao-seta primeira",
          "primeira",
          "Primeira página"
        )
      );
    }
    fragment.appendChild(
      criarDivComLink(
        anteriorSVG,
        paginaAtual - 1,
        "botao-seta anterior",
        "anterior",
        "Página anterior"
      )
    );
  }

  for (
    let i = Math.max(1, paginaAtual - 2);
    i <= Math.min(totalPaginas, paginaAtual + 2);
    i++
  ) {
    if (i === paginaAtual) {
      const div = document.createElement("div");
      div.className = "botao-atual";
      div.textContent = i;
      fragment.appendChild(div);
    } else {
      fragment.appendChild(
        criarDivComLink(i, i, "botao-numero", "numero", `Página ${i}`)
      );
    }
  }

  if (paginaAtual < totalPaginas) {
    fragment.appendChild(
      criarDivComLink(
        proximoSVG,
        paginaAtual + 1,
        "botao-seta proxima",
        "proxima",
        "Próxima página"
      )
    );
    if (paginaAtual < totalPaginas - 1) {
      fragment.appendChild(
        criarDivComLink(
          ultimaSVG,
          totalPaginas,
          "botao-seta ultima",
          "ultima",
          "Última página"
        )
      );
    }
  }

  return fragment;
}

function criarMensagemPaginacao(total, paginaAtual, resultadosPorPagina) {
  const info = document.createElement("div");
  info.className = "paginacao-info";

  if (resultadosPorPagina === "todos") {
    info.textContent = `Exibindo todos os ${total} resultados.`;
  } else {
    const inicio = (paginaAtual - 1) * resultadosPorPagina + 1;
    const fim = Math.min(paginaAtual * resultadosPorPagina, total);
    info.textContent = `Exibindo resultados de ${inicio} a ${fim} de um total de ${total}.`;
  }

  return info;
}

function mudarResultadosPorPagina(resultadosPorPagina) {
  preferenciasAtuais.resultadosPorPagina = resultadosPorPagina;
  carregarTabela(nomeTabela, 1, resultadosPorPagina);
}

function mudarColunasSelecionadas(colunasSelecionadas) {
  preferenciasAtuais.colunas = colunasSelecionadas;
  carregarTabela(nomeTabela, 1, preferenciasAtuais.resultadosPorPagina);
}

function renderizarTabela(
  dados,
  pagina,
  resultadosPorPagina,
  colunasSelecionadas = null,
  todasColunas = []
) {
  const dadosFiltrados = dados.filter((item) => {
    if (preferenciasAtuais.filtroAtivo && preferenciasAtuais.filtroInativo) {
      return true; // Exibir todos
    } else if (preferenciasAtuais.filtroAtivo) {
      return item.Ativo === "1";
    } else if (preferenciasAtuais.filtroInativo) {
      return item.Ativo === "0";
    }
    return false; // Não exibir nada se nenhum filtro estiver selecionado
  });

  const total = dadosFiltrados.length;
  const startIndex =
    (pagina - 1) *
    (resultadosPorPagina === "todos" ? total : resultadosPorPagina);
  const endIndex =
    resultadosPorPagina === "todos" ? total : startIndex + resultadosPorPagina;
  const dadosPagina = dadosFiltrados.slice(startIndex, endIndex);

  // Garantir que 'id' esteja sempre presente nos dados passados para criarTabela
  const dadosComId = dadosPagina.map((item) => {
    const itemComId = { id_link: item.ID };
    colunasSelecionadas.forEach((coluna) => {
      itemComId[coluna] = item[coluna];
    });
    return itemComId;
  });

  totalComId = dadosFiltrados.map((item) => {
    const itemComId = { id_link: item.ID };
    colunasSelecionadas.forEach((coluna) => {
      itemComId[coluna] = item[coluna];
    });
    return itemComId;
  });

  const tabela = criarTabela(dadosComId, colunasSelecionadas, todasColunas);
  document.getElementById("tabela").innerHTML = "";
  document.getElementById("tabela").appendChild(tabela);

  const resultadoContainer = document.getElementById("resultados");
  resultadoContainer.innerHTML = "";

  const textoResultado = criarMensagemPaginacao(
    total,
    pagina,
    resultadosPorPagina
  );
  resultadoContainer.appendChild(textoResultado);

  const paginacaoContainer = document.getElementById("paginacao");
  paginacaoContainer.innerHTML = "";

  if (resultadosPorPagina !== "todos") {
    const paginacao = criarPaginacao(total, pagina, resultadosPorPagina);
    paginacaoContainer.appendChild(paginacao);
  }
}

function buscarTabela() {
  const termoBusca = document.getElementById("input-busca").value.toLowerCase();
  const dadosFiltrados = dadosTabela.filter((item) => {
    return Object.values(item).some(
      (valor) =>
        valor != null && valor.toString().toLowerCase().includes(termoBusca)
    );
  });
  renderizarTabela(
    dadosFiltrados,
    1,
    preferenciasAtuais.resultadosPorPagina,
    preferenciasAtuais.colunas,
    todasColunas
  );
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
        detalhes.cor = "#0017CB";
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
      case "7":
        detalhes.svg = bloqueadoSVG;
        detalhes.texto = "Bloqueado";
        detalhes.cor = "#FF0000";
        break;
      case "8":
        detalhes.svg = cauteladoSVG;
        detalhes.texto = "Cautelado";
        detalhes.cor = "#888888";
        break;
      case "9":
        detalhes.svg = disponivelSVG;
        detalhes.texto = "Disponivel";
        detalhes.cor = "#01CF73";
        break;
      default:
        detalhes.svg = "";
        detalhes.texto = "";
        detalhes.cor = "#000000";
    }
    resolve(detalhes);
  });
}

function aplicarFiltros() {
  const checkboxes = document.querySelectorAll(
    '#formCheckboxes input[name="colunas"]'
  );
  colunasSelecionadas = Array.from(checkboxes)
    .filter((checkbox) => checkbox.checked)
    .map((checkbox) => checkbox.value);

  const salvarConfiguracao =
    document.querySelector('input[name="salvarConfiguracao"]:checked').value ===
    "sim";
  const resultadosPorPagina =
    document.getElementById("resultadosPorPaginaOverlay").value === "todos"
      ? "todos"
      : parseInt(
          document.getElementById("resultadosPorPaginaOverlay").value,
          10
        );
  const filtroAtivo = document.getElementById("filtro-ativo").checked;
  const filtroInativo = document.getElementById("filtro-inativo").checked;

  preferenciasAtuais = {
    colunas: colunasSelecionadas,
    resultadosPorPagina: resultadosPorPagina,
    filtroAtivo: filtroAtivo,
    filtroInativo: filtroInativo,
  };

  if (salvarConfiguracao) {
    salvarPreferencias(
      nomeTabela,
      colunasSelecionadas,
      resultadosPorPagina,
      filtroAtivo,
      filtroInativo
    );
  }

  document.getElementById("input-busca").value = "";

  renderizarTabela(
    dadosTabela,
    1,
    resultadosPorPagina,
    colunasSelecionadas,
    todasColunas
  );
  ShowObjectWithEffect("overlay", 0, "fade", 200);
}

let tabelaCarregada = false;