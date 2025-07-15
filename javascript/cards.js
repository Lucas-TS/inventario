async function exibirGraficoComputadores() {
  const tipoTexto = {
    0: 'Desktop',
    1: 'Notebook',
    2: 'Servidor'
  };

  const tipoCor = {
    0: '#3F51B5',
    1: '#4CAF50',
    2: '#FF9800'
  };

  const labels = [];
  const valores = [];
  const cores = [];

  // Inicia todos com 0 para garantir legenda completa
  for (const tipo in tipoTexto) {
    labels.push(tipoTexto[tipo]);
    valores.push(0);
    cores.push(tipoCor[tipo] ?? '#999');
  }

  const res = await fetch('./cards/computadores.php');
  const dados = await res.json();

  // Preenche valores reais
  dados.tipos.forEach(item => {
    valores[item.tipo] = item.quantidade;
  });

  const divBloco = document.getElementById('bloco-card-1');
  if (divBloco) {
    divBloco.innerHTML = '';

    // Cria div wrapper
    const wrapper = document.createElement('div');
    wrapper.className = 'grafico-wrapper';
    divBloco.appendChild(wrapper);

    // Cria canvas dentro da wrapper
    const canvas = document.createElement('canvas');
    canvas.id = 'grafico-computadores';
    wrapper.appendChild(canvas);

    // Cria texto de total abaixo
    const totalTexto = document.createElement('p');
    totalTexto.className = 'texto-total';
    totalTexto.textContent = `TOTAL: ${dados.total}`;
    divBloco.appendChild(totalTexto);

    Chart.register(ChartDataLabels);

    new Chart(canvas.getContext('2d'), {
      type: 'doughnut',
      plugins: [ChartDataLabels],
      data: {
        labels,
        datasets: [{
          data: valores,
          backgroundColor: cores
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false, // 🎯 desativa aspecto fixo
        plugins: {
          legend: { position: 'right' },
          title: { display: true, text: 'Distribuição por Tipo de Computador' },
          datalabels: {
            formatter: value => value,
            color: '#fff',
            font: { weight: 'bold', size: 13 }
          }
        }
      }
    });
  }
}

async function exibirGraficoSituacoes() {
  const situacoesEsperadas = {
    0: 'Em uso',
    1: 'Devolver',
    2: 'Distribuir',
    3: 'Manutenção',
    4: 'Aguardando peças',
    5: 'Defeito',
    6: 'Descarregar',
    7: 'Bloqueado',
    8: 'Disponível',
    9: 'Cautelado'
  };

  // Inicia todas com quantidade zero
  const mapaSituacoes = {};
  for (const codigo in situacoesEsperadas) {
    mapaSituacoes[codigo] = { situacao: codigo, quantidade: 0 };
  }

  const res = await fetch('./cards/situacao.php');
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

  const divBloco = document.getElementById('bloco-card-3');
  if (divBloco) {
    divBloco.innerHTML = '';

    const wrapper = document.createElement('div');
    wrapper.className = 'grafico-wrapper';
    divBloco.appendChild(wrapper);

    const canvas = document.createElement('canvas');
    canvas.id = 'grafico-situacoes';
    wrapper.appendChild(canvas);

    const totalTexto = document.createElement('p');
    totalTexto.className = 'texto-total';
    totalTexto.textContent = `TOTAL: ${dados.total}`;
    divBloco.appendChild(totalTexto);

    Chart.register(ChartDataLabels);

    new Chart(canvas.getContext('2d'), {
      type: 'doughnut',
      plugins: [ChartDataLabels],
      data: {
        labels,
        datasets: [{
          data: valores,
          backgroundColor: cores
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false, // ✨ permite controle via CSS
        plugins: {
          legend: { position: 'right' },
          title: {
            display: true,
            text: 'Distribuição por Situação'
          },
          datalabels: {
            formatter: value => value,
            color: '#fff',
            font: { weight: 'bold', size: 13 }
          }
        }
      }
    });
  }
}
