function salvarPreferencias(nomeTabela, colunasSelecionadas, resultadosPorPagina, filtroAtivo, filtroInativo) {
    preferenciasAtuais = {
        colunas: colunasSelecionadas,
        resultadosPorPagina: resultadosPorPagina,
        filtroAtivo: filtroAtivo,
        filtroInativo: filtroInativo
    };
    document.cookie = `preferencias_${nomeTabela}=${JSON.stringify(preferenciasAtuais)}; path=/; max-age=31536000`;
  }