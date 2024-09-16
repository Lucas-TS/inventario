function exibirOverlay(pagina) {
    ShowObjectWithEffect('overlay', 1, 'fade', 200);
    paginaOverlay(pagina);
    return false;
}

function paginaOverlay(nomeArquivo) {
    fetch(nomeArquivo)
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro ao carregar o arquivo: ' + response.statusText);
            }
            return response.text();
        })
        .then(data => {
            document.getElementById('overlay').innerHTML = data;
        })
        .catch(error => {
            console.error('Erro:', error);
        });
}