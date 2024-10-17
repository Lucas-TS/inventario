$(document).ready(function () {
    fetch('images/')
        .then(response => response.text())
        .then(data => {
            $(data).find("a:contains(.svg)").each(function () {
                var fileName = $(this).attr("href");
                var variableName = fileName.replace('.svg', 'SVG');

                if (sessionStorage.getItem(variableName)) {
                    window[variableName] = sessionStorage.getItem(variableName);
                } else {
                    fetch('images/' + fileName)
                        .then(response => response.text())
                        .then(svgContent => {
                            window[variableName] = svgContent;
                            sessionStorage.setItem(variableName, svgContent);
                        });
                }
            });
        });
});
