const centerTextPlugin = {
  id: "centerText",
  afterDraw(chart) {
    const {
      ctx,
      chartArea: { left, top, width, height },
    } = chart;
    ctx.save();

    // Só desenha o texto central se for doughnut ou pie
    const tipo = chart.config.type;
    if (tipo === "doughnut") {
      ctx.font = "bold 50px Arial";
      ctx.fillStyle = "#444";
      ctx.textAlign = "center";
      ctx.textBaseline = "middle";
      const total = chart.config.options.plugins.centerText.total || "";
      ctx.fillText(total, left + width / 2, top + height / 2);
    }
    ctx.restore();
  },
};

const tiposPermitidosGraficos = ["doughnut", "bar", "pie", "line"]; // Adicione/remova conforme desejar
loadSVG("doughnut.svg");
loadSVG("bar.svg");
loadSVG("pie.svg");
loadSVG("line.svg");
const iconesPorTipo = {
  doughnut: doughnutSVG, // pode ser um SVG, uma classe CSS ou um Unicode/emoji
  bar: barSVG,
  pie: pieSVG,
  line: lineSVG,
};

async function carregarCard(nomeArquivo, blocoId) {
  let tipos = {};
  try {
    tipos = JSON.parse(localStorage.getItem("cardsGraficoTipo") || "{}");
  } catch {}

  const res = await fetch(`./cards/${nomeArquivo}.php`);
  const dados = await res.json();
  const divBloco = document.getElementById(blocoId);
  if (!divBloco) return;
  divBloco.innerHTML = "";

  // Título
  if (dados.titulo) {
    const titulo = document.createElement("div");
    titulo.className = "texto-titulo";
    titulo.style.display = "flex";
    titulo.style.alignItems = "center";
    titulo.style.justifyContent = "space-between";

    // Título do card
    const tituloSpan = document.createElement("span");
    tituloSpan.textContent = dados.titulo;
    titulo.appendChild(tituloSpan);

    // Botão de gráfico (se for gráfico)
    const tipoGraficoAtual = tipos[blocoId] || dados.grafico.tipo || "bar";
    let btnGrafico = null;
    if (dados.tipo === "grafico") {
      btnGrafico = document.createElement("button");
      btnGrafico.className = "btn-tipo-grafico";
      btnGrafico.id = `btnGrafico-${blocoId}`;
      btnGrafico.title = "Alterar tipo de gráfico";
      btnGrafico.innerHTML = iconesPorTipo[tipoGraficoAtual];
      btnGrafico.onclick = (e) => {
        e.stopPropagation();
        alternarTipoGrafico(blocoId, nomeArquivo, dados.grafico.tipo);
      };
      titulo.appendChild(btnGrafico);
    }

    // Botão de personalização
    const btnSeta = document.createElement("button");
    btnSeta.className = "btn-seta-card";
    btnSeta.innerHTML = setaSVG;
    btnSeta.title = "Personalizar este card";
    btnSeta.onclick = (e) => {
      e.stopPropagation();
      abrirPersonalizacaoCard(blocoId, nomeArquivo);
    };
    titulo.appendChild(btnSeta);

    divBloco.appendChild(titulo);
    atualizarIconeBotaoGrafico(blocoId, tipoGraficoAtual);
  }

  // Conteúdo dinâmico
  switch (dados.tipo) {
    case "grafico":
      // Busca o tipo salvo ou usa o padrão do PHP/dados
      const tipoGrafico = tipos[blocoId] || dados.grafico.tipo || "pie";
      // Passa o tipo para a função
      criarGraficoNoCard(divBloco, { ...dados.grafico, tipo: tipoGrafico });
      break;
    case "texto":
      divBloco.innerHTML += `<div class="card-texto">${dados.texto}</div>`;
      break;
    case "tabela":
      criarTabelaNoCard(divBloco, dados.colunas, dados.linhas);
      break;
    case "link":
      divBloco.innerHTML += `<a href="${dados.url}" class="card-link">${dados.texto}</a>`;
      break;
    // Adicione outros tipos conforme necessário
  }
}

// Função auxiliar para gráfico
function criarGraficoNoCard(divBloco, grafico) {
  const wrapper = document.createElement("div");
  wrapper.className = "grafico-wrapper";
  divBloco.appendChild(wrapper);

  const canvas = document.createElement("canvas");
  canvas.id = "grafico-" + Math.random().toString(36).substr(2, 5);
  const canvasHolder = document.createElement("div");
  canvasHolder.className = "canvas-holder";
  canvasHolder.appendChild(canvas);
  wrapper.appendChild(canvasHolder);

  Chart.register(ChartDataLabels, centerTextPlugin);
  new Chart(canvas.getContext("2d"), {
    type: grafico.tipo,
    plugins: [ChartDataLabels, centerTextPlugin],
    data: {
      labels: grafico.labels,
      datasets: [
        {
          data: grafico.valores,
          backgroundColor: grafico.cores,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        datalabels: {
          formatter: (v) => (v > 0 ? v : ""),
          color: "#fff",
          font: { weight: "bold", size: 13 },
        },
        centerText: {
          total: grafico.total,
        },
      },
    },
  });

  // Legenda customizada
  if (grafico.labels && grafico.cores) {
    const legenda = document.createElement("div");
    legenda.className = "grafico-legenda";
    grafico.labels.forEach((label, i) => {
      const item = document.createElement("div");
      item.className = "legenda-item";
      item.innerHTML = `<span class="legenda-cor" style="background:${grafico.cores[i]}"></span>${label}`;
      legenda.appendChild(item);
    });
    const totalDiv = document.createElement("div");
    totalDiv.className = "legenda-item";
    totalDiv.innerHTML = `<b>TOTAL: ${grafico.total}</b>`;
    legenda.appendChild(totalDiv);

    wrapper.appendChild(legenda);
  }
}

// Função auxiliar para tabela
function criarTabelaNoCard(divBloco, colunas, linhas) {
  const table = document.createElement("table");
  table.className = "card-tabela";
  const thead = document.createElement("thead");
  const trHead = document.createElement("tr");
  colunas.forEach((col) => {
    const th = document.createElement("th");
    th.textContent = col;
    trHead.appendChild(th);
  });
  thead.appendChild(trHead);
  table.appendChild(thead);

  const tbody = document.createElement("tbody");
  linhas.forEach((linha) => {
    const tr = document.createElement("tr");
    linha.forEach((cell) => {
      const td = document.createElement("td");
      td.textContent = cell;
      tr.appendChild(td);
    });
    tbody.appendChild(tr);
  });
  table.appendChild(tbody);
  divBloco.appendChild(table);
}

function salvarPersonalizacaoCard(blocoId, nomeArquivo) {
  let prefs = {};
  try {
    prefs = JSON.parse(localStorage.getItem("cardsPrefs") || "{}");
  } catch {}
  prefs[blocoId] = nomeArquivo;
  localStorage.setItem("cardsPrefs", JSON.stringify(prefs));
}

function buscarPersonalizacaoCards() {
  try {
    return JSON.parse(localStorage.getItem("cardsPrefs") || "{}");
  } catch {
    return {};
  }
}

function abrirPersonalizacaoCard(blocoId, nomeAtual) {
  const titulo = document
    .getElementById(blocoId)
    .querySelector(".texto-titulo");
  const btnSeta = titulo.querySelector(".btn-seta-card");
  const caixaAberta = titulo.querySelector(".personaliza-card-box");

  // Se já está aberta, fecha e sai
  if (caixaAberta) {
    caixaAberta.remove();
    if (btnSeta) btnSeta.classList.remove("ativo");
    return;
  }

  // Remove caixa anterior se existir e remove classe 'ativo' de todos os botões
  document.querySelectorAll(".personaliza-card-box").forEach((e) => e.remove());
  document
    .querySelectorAll(".btn-seta-card.ativo")
    .forEach((e) => e.classList.remove("ativo"));

  // Opções únicas para todos os cards
  const opcoes = [
    { nome: "computadores", label: "Tipo de Computador" },
    { nome: "so", label: "Sistema Operacional" },
    { nome: "antivirus", label: "Antivírus" },
    { nome: "situacao", label: "Situação" },
  ];

  // Cria caixa suspensa
  const box = document.createElement("div");
  box.className = "personaliza-card-box visivel";

  // Adiciona opções como <p>
  opcoes.forEach((opt) => {
    if (opt.nome === nomeAtual) return; // Não cria o <p> da opção já selecionada
    const p = document.createElement("p");
    p.textContent = opt.label;
    p.onclick = () => {
      salvarPersonalizacaoCard(blocoId, opt.nome);
      box.remove();
      btnSeta.classList.remove("ativo");
      carregarCard(opt.nome, blocoId);
    };
    box.appendChild(p);
  });

  // Posiciona a caixa ao lado do botão
  titulo.style.position = "relative";
  titulo.appendChild(box);

  // Adiciona classe 'ativo' ao botão da seta clicado
  if (btnSeta) btnSeta.classList.add("ativo");

  // Fecha ao clicar fora
  setTimeout(() => {
    document.addEventListener("click", function fecharBox(e) {
      if (!box.contains(e.target)) {
        box.remove();
        if (btnSeta) btnSeta.classList.remove("ativo");
        document.removeEventListener("click", fecharBox);
      }
    });
  }, 10);
}

function alternarTipoGrafico(blocoId, nomeCardAtual, tipoAtualNaTela) {
  // Pega o tipo atual
  let tipos = {};
  try {
    tipos = JSON.parse(localStorage.getItem("cardsGraficoTipo") || "{}");
  } catch {}

  // Fallback: tipo atual exibido na tela
  const atual = tipos[blocoId] || tipoAtualNaTela || tiposPermitidosGraficos[0];

  // Descobre o próximo tipo
  let idx = tiposPermitidosGraficos.indexOf(atual);
  let novoTipo =
    tiposPermitidosGraficos[(idx + 1) % tiposPermitidosGraficos.length];

  // Salva e recarrega
  tipos[blocoId] = novoTipo;
  localStorage.setItem("cardsGraficoTipo", JSON.stringify(tipos));

  // Nome do card salvo normalmente
  let prefs = {};
  try {
    prefs = JSON.parse(localStorage.getItem("cardsPrefs") || "{}");
  } catch {}
  const nomeCard = nomeCardAtual || "computadores";

  carregarCard(nomeCard, blocoId);
}

function atualizarIconeBotaoGrafico(blocoId, tipoAtualNaTela) {
  const atual = tipoAtualNaTela || tiposPermitidosGraficos[0];
  const idx = tiposPermitidosGraficos.indexOf(atual);
  const proximo =
    tiposPermitidosGraficos[(idx + 1) % tiposPermitidosGraficos.length];

  const btn = document.querySelector(`#btnGrafico-${blocoId}`); // ajuste o seletor conforme seu HTML

  if (btn) {
    const icone = iconesPorTipo[proximo] || "";
    btn.innerHTML = icone; // ou btn.className = ..., dependendo da forma que usa ícones
  }
}
