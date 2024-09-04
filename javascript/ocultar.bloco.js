function alternarVisibilidade() {
    const corpoTabela = document.getElementById('ocultavel');
    corpoTabela.classList.toggle('visivel');
    const iconeSeta = document.getElementById('icone-seta');
    iconeSeta.classList.toggle('visivel');
    const blocoOcultavel = document.getElementById('bloco-ocultavel');
    blocoOcultavel.classList.toggle('visivel');
    const botaoLimpar = document.getElementById('limpar');
    botaoLimpar.classList.toggle('visivel');
 }