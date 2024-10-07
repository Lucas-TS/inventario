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
let ascSVG = '';
let descSVG = '';

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

loadSVG('./images/asc.svg', svg => {
    ascSVG = svg;
});

loadSVG('./images/desc.svg', svg => {
    descSVG = svg;
});