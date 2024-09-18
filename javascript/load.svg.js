let maisSVG = '';
let menosSVG = '';
let okSVG = '';

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