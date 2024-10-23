// Função para carregar um único SVG
function loadSVG(fileName, retries = 3) {
    const variableName = fileName.replace('.svg', 'SVG');
    
    if (sessionStorage.getItem(variableName)) {
        window[variableName] = sessionStorage.getItem(variableName);
        return Promise.resolve();
    }

    return fetch('images/' + fileName)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.text();
        })
        .then(svgContent => {
            window[variableName] = svgContent;
            sessionStorage.setItem(variableName, svgContent);
        })
        .catch(error => {
            if (retries > 0) {
                console.warn(`Falha ao carregar ${fileName}, tentando novamente...`, error);
                return new Promise(resolve => setTimeout(() => resolve(loadSVG(fileName, retries - 1)), 1000));
            }
            console.error(`Falha ao carregar ${fileName} após ${3 - retries} tentativas`, error);
        });
}

// Função para carregar todos os SVGs
function loadAllSVGs() {
    return new Promise((resolve, reject) => {
        fetch('images/')
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.text();
            })
            .then(data => {
                const promises = [];
                $(data).find("a:contains(.svg)").each(function () {
                    promises.push(loadSVG($(this).attr("href")));
                });
                return Promise.all(promises);
            })
            .then(resolve)
            .catch(reject);
    });
}

// Função auxiliar para usar SVG com fallback
function useSVG(svgName, fallback = '') {
    return window[svgName + 'SVG'] || fallback;
}
