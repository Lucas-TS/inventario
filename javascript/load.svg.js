let maisSVG = '';
let menosSVG = '';
let okSVG = '';
let eraseSVG = '';
let delSVG = '';
let viewSVG = '';
let editSVG = '';
let primeiraSVG = '';
let anteriorSVG = '';
let proximaSVG = '';
let ultimaSVG = '';
let ordemSVG = '';
let returnSVG = '';
let infoSVG = '';
let manutSVG = '';
let esperaSVG = '';
let defeitoSVG = '';
let binSVG = '';

function loadSVG(url, callback) {
    fetch(url)
        .then(response => response.text())
        .then(data => {
            callback(data);
        })
        .catch(error => console.error('Error loading SVG:', error));
}

loadSVG('./images/add.svg', svg => {
    maisSVG = svg;
});

loadSVG('./images/menos.svg', svg => {
    menosSVG = svg;
});

loadSVG('./images/ok.svg', svg => {
    okSVG = svg;
});

loadSVG('./images/erase.svg', svg => {
    eraseSVG = svg;
});

loadSVG('./images/del.svg', svg => {
    delSVG = svg;
});

loadSVG('./images/view.svg', svg => {
    viewSVG = svg;
});

loadSVG('./images/edit.svg', svg => {
    editSVG = svg;
});

loadSVG('./images/primeira.svg', svg => {
    primeiraSVG = svg;
});

loadSVG('./images/anterior.svg', svg => {
    anteriorSVG = svg;
});

loadSVG('./images/proximo.svg', svg => {
    proximoSVG = svg;
});

loadSVG('./images/ultima.svg', svg => {
    ultimaSVG = svg;
});

loadSVG('./images/ordem.svg', svg => {
    ordemSVG = svg;
});

// Adicionar ícones da situação
loadSVG('./images/return.svg', svg => {
    returnSVG = svg;
});

loadSVG('./images/info.svg', svg => {
    infoSVG = svg;
});

loadSVG('./images/manut.svg', svg => {
    manutSVG = svg;
});

loadSVG('./images/espera.svg', svg => {
    esperaSVG = svg;
});

loadSVG('./images/defeito.svg', svg => {
    defeitoSVG = svg;
});

loadSVG('./images/bin.svg', svg => {
    binSVG = svg;
});
