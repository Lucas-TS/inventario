function salvarPreferencias(nomeTabela, colunasSelecionadas) {
    const preferencias = {
        tabela: nomeTabela,
        colunas: colunasSelecionadas
    };
    document.cookie = `preferencias_${nomeTabela}=${JSON.stringify(preferencias)}; path=/; max-age=31536000`; // 1 ano
}