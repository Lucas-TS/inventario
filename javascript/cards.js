const centerTextPlugin = {
  id: "centerText",
  afterDraw(chart) {
    const {
      ctx,
      chartArea: { left, right, top, bottom, width, height },
    } = chart;
    ctx.save();
    ctx.font = "bold 50px Arial";
    ctx.fillStyle = "#444";
    ctx.textAlign = "center";
    ctx.textBaseline = "middle";
    // O total pode ser passado por options ou calculado
    const total = chart.config.options.plugins.centerText.total || "";
    ctx.fillText(total, left + width / 2, top + height / 2);
    ctx.restore();
  },
};

async function exibirGraficoComputadores() {
  const tipoTexto = {
    0: "Desktop",
    1: "Notebook",
    2: "Servidor",
  };

  const tipoCor = {
    0: "#3F51B5",
    1: "#4CAF50",
    2: "#FF9800",
  };

  const labels = [];
  const valores = [];
  const cores = [];

  // Inicia todos com 0 para garantir legenda completa
  for (const tipo in tipoTexto) {
    labels.push(tipoTexto[tipo]);
    valores.push(0);
    cores.push(tipoCor[tipo] ?? "#999");
  }

  const res = await fetch("./cards/computadores.php");
  const dados = await res.json();

  // Preenche valores reais
  dados.tipos.forEach((item) => {
    valores[item.tipo] = item.quantidade;
  });

  const divBloco = document.getElementById("bloco-card-1");
  if (!divBloco) return;

  // Limpa conteúdo anterior
  divBloco.innerHTML = "";

  // 1) Cria título externo
  const tituloChart = document.createElement("p");
  tituloChart.className = "texto-titulo";
  tituloChart.textContent = "Distribuição por Tipo de Computador";
  divBloco.appendChild(tituloChart);

  // 2) Cria wrapper + canvas
  const wrapper = document.createElement("div");
  wrapper.className = "grafico-wrapper";
  divBloco.appendChild(wrapper);

  const canvas = document.createElement("canvas");
  canvas.id = "grafico-computadores";
  const canvasHolder = document.createElement("div");
  canvasHolder.className = "canvas-holder";
  canvasHolder.appendChild(canvas);
  wrapper.appendChild(canvasHolder);

  // 4) Monta o gráfico
  Chart.register(ChartDataLabels);
  new Chart(canvas.getContext("2d"), {
    type: "doughnut",
    plugins: [ChartDataLabels, centerTextPlugin],
    data: {
      labels,
      datasets: [
        {
          data: valores,
          backgroundColor: cores,
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
          total: dados.total, // Passe o total aqui!
        },
      },
    },
  });

  // Cria legenda customizada
  const legenda = document.createElement("div");
  legenda.className = "grafico-legenda";
  labels.forEach((label, i) => {
    const item = document.createElement("div");
    item.className = "legenda-item";
    item.innerHTML = `<span class="legenda-cor" style="background:${cores[i]}"></span>${label}`;
    legenda.appendChild(item);
  });
  wrapper.appendChild(legenda); // Adiciona ao lado do canvas-holder
}

async function exibirGraficoSituacoes() {
  const situacoesEsperadas = {
    0: "Em uso",
    1: "Devolver",
    2: "Distribuir",
    3: "Manutenção",
    4: "Aguardando peças",
    5: "Defeito",
    6: "Descarregar",
    7: "Bloqueado",
    8: "Disponível",
    9: "Cautelado",
  };

  // Inicia todas com quantidade zero
  const mapaSituacoes = {};
  for (const codigo in situacoesEsperadas) {
    mapaSituacoes[codigo] = { situacao: codigo, quantidade: 0 };
  }

  const res = await fetch("./cards/situacao.php");
  const dados = await res.json();

  for (const item of dados.situacoes) {
    mapaSituacoes[item.situacao] = item;
  }

  const labels = [];
  const valores = [];
  const cores = [];

  for (const item of Object.values(mapaSituacoes)) {
    const detalhes = await obterDetalhesSituacao(String(item.situacao));
    labels.push(detalhes.texto);
    valores.push(item.quantidade);
    cores.push(detalhes.cor);
  }

  const divBloco = document.getElementById("bloco-card-3");
  if (!divBloco) return;

  divBloco.innerHTML = "";

  // 1) Título externo
  const tituloChart = document.createElement("p");
  tituloChart.className = "texto-titulo";
  tituloChart.textContent = "Distribuição por Situação";
  divBloco.appendChild(tituloChart);

  // 2) Wrapper + canvas
  const wrapper = document.createElement("div");
  wrapper.className = "grafico-wrapper";
  divBloco.appendChild(wrapper);

  const canvas = document.createElement("canvas");
  canvas.id = "grafico-situacoes";
  const canvasHolder = document.createElement("div");
  canvasHolder.className = "canvas-holder";
  canvasHolder.appendChild(canvas);
  wrapper.appendChild(canvasHolder);

  // 4) Monta o gráfico
  Chart.register(ChartDataLabels);
  new Chart(canvas.getContext("2d"), {
    type: "doughnut",
    plugins: [ChartDataLabels, centerTextPlugin],
    data: {
      labels,
      datasets: [
        {
          data: valores,
          backgroundColor: cores,
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
          total: dados.total, // Passe o total aqui!
        },
      },
    },
  });

  // Cria legenda customizada
  const legenda = document.createElement("div");
  legenda.className = "grafico-legenda";
  labels.forEach((label, i) => {
    const item = document.createElement("div");
    item.className = "legenda-item";
    item.innerHTML = `<span class="legenda-cor" style="background:${cores[i]}"></span>${label}`;
    legenda.appendChild(item);
  });
  wrapper.appendChild(legenda); // Adiciona ao lado do canvas-holder
}

async function exibirGraficoSO() {
  // Gera cor baseada no nome (usando hash + HSL)
  function gerarPaleta(total) {
    const cores = [];

    // Espaço entre tons — quanto menos itens, mais espaçamento
    const hueStep = total > 12 ? 25 : 360 / total;

    for (let i = 0; i < total; i++) {
      const hue = Math.round((i * hueStep) % 360);
      const saturation = 70;
      const lightness = 50;

      cores.push(`hsl(${hue}, ${saturation}%, ${lightness}%)`);
    }

    return cores;
  }

  const res = await fetch("./cards/so.php");
  const dados = await res.json();

  const labels = [];
  const valores = [];
  const totalItens = dados.sistemas.length;
  const cores = gerarPaleta(totalItens);

  dados.sistemas.forEach((item, i) => {
    labels.push(item.nome);
    valores.push(item.quantidade);
    // usa a cor gerada para o índice atual
    cores[i] = cores[i];
  });

  const divBloco = document.getElementById("bloco-card-2");
  if (!divBloco) return;
  divBloco.innerHTML = "";

  // 1) Título externo
  const tituloChart = document.createElement("p");
  tituloChart.className = "texto-titulo";
  tituloChart.textContent = "Distribuição por Sistema Operacional";
  divBloco.appendChild(tituloChart);

  // 2) Wrapper + canvas
  const wrapper = document.createElement("div");
  wrapper.className = "grafico-wrapper";
  divBloco.appendChild(wrapper);

  const canvas = document.createElement("canvas");
  canvas.id = "grafico-so";
  const canvasHolder = document.createElement("div");
  canvasHolder.className = "canvas-holder";
  canvasHolder.appendChild(canvas);
  wrapper.appendChild(canvasHolder);

  // 4) Monta o gráfico
  Chart.register(ChartDataLabels);
  new Chart(canvas.getContext("2d"), {
    type: "doughnut",
    plugins: [ChartDataLabels, centerTextPlugin],
    data: {
      labels,
      datasets: [
        {
          data: valores,
          backgroundColor: cores,
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
          total: dados.total, // Passe o total aqui!
        },
      },
    },
  });

  // 5) Legenda customizada
  const legenda = document.createElement("div");
  legenda.className = "grafico-legenda";
  labels.forEach((label, i) => {
    const item = document.createElement("div");
    item.className = "legenda-item";
    item.innerHTML = `<span class="legenda-cor" style="background:${cores[i]}"></span>${label}`;
    legenda.appendChild(item);
  });
  wrapper.appendChild(legenda);
}

async function exibirGraficoAntivirus() {
  const res = await fetch("./cards/antivirus.php");
  const dados = await res.json();

  const labels = [];
  const valores = [];
  const cores = [];

  const corMapeada = {
    Sim: "#4CAF50", // Verde
    Não: "#F44336", // Vermelho
  };

  dados.sistemas.forEach((item) => {
    labels.push(item.nome);
    valores.push(item.quantidade);
    cores.push(corMapeada[item.nome] ?? "#999");
  });

  const divBloco = document.getElementById("bloco-card-4");
  if (!divBloco) return;
  divBloco.innerHTML = "";

  const titulo = document.createElement("p");
  titulo.className = "texto-titulo";
  titulo.textContent = "Antivírus Instalado";
  divBloco.appendChild(titulo);

  const wrapper = document.createElement("div");
  wrapper.className = "grafico-wrapper";
  divBloco.appendChild(wrapper);

  const canvas = document.createElement("canvas");
  canvas.id = "grafico-antivirus";
  const canvasHolder = document.createElement("div");
  canvasHolder.className = "canvas-holder";
  canvasHolder.appendChild(canvas);
  wrapper.appendChild(canvasHolder);

  Chart.register(ChartDataLabels);
  new Chart(canvas.getContext("2d"), {
    type: "doughnut",
    plugins: [ChartDataLabels, centerTextPlugin],
    data: {
      labels,
      datasets: [
        {
          data: valores,
          backgroundColor: cores,
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
          total: dados.total, // Passe o total aqui!
        },
      },
    },
  });

  // Legenda customizada
  const legenda = document.createElement("div");
  legenda.className = "grafico-legenda";
  labels.forEach((label, i) => {
    const item = document.createElement("div");
    item.className = "legenda-item";
    item.innerHTML = `<span class="legenda-cor" style="background:${cores[i]}"></span>${label}`;
    legenda.appendChild(item);
  });
  wrapper.appendChild(legenda);
}
