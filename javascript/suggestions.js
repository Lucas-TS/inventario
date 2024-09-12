function suggestionsMem(valores) {

    var arrayValores = valores.split(',');

    var div = document.getElementById('suggestions-tipo-mem');
    div.innerHTML = '';

    var input = document.getElementById('tipo-mem');
    input.value = '';

    for (var i = 0; i < arrayValores.length; i++) {
        var p = document.createElement('p');
        p.textContent = arrayValores[i];
        p.id = 'p' + i;
        p.setAttribute('onclick', 'passarValor(' + i + ', "tipo-mem", "mem")');
        div.appendChild(p);
    }
    if (arrayValores.length === 1) {
        input.value = arrayValores[0];
    }
}

function showSuggestions(str1, str2) {
    const $suggestions = $(`#suggestions-${str2}`);
    if (!$suggestions.hasClass("visivel")) {
        $suggestions.addClass('visivel');
    }

    let marca = '';
    const so = document.querySelector('input[name="so"]:checked')?.value;
    const office = document.querySelector('input[name="office"]:checked')?.value;

    switch (str2) {
        case 'ver-win':
        case 'distro-linux':
            marca = so;
            break;
        case 'ver-linux':
            marca = `${so} ${document.getElementById('distro-linux').value}`;
            break;
        case 'ed-win':
            marca = `${so} ${document.getElementById('ver-win').value}`;
            break;
        case 'if-linux':
            marca = `${so} ${document.getElementById('distro-linux').value} ${document.getElementById('ver-linux').value}`;
            break;
        case 'ver-ms':
        case 'nome-free':
            marca = office;
            break;
        case 'ed-ms':
            marca = `${office} ${document.getElementById('ver-ms').value}`;
            break;
        case 'ver-free':
            marca = document.getElementById('nome-free').value;
            break;
        case 'marca-pv':
            marca = document.getElementById('gpu-pv').value;
            break;
        case 'modelo-pv':
            marca = `${document.getElementById('gpu-pv').value} ${document.getElementById('marca-pv').value}`;
            break;
        case 'mem-pv':
            marca = `${document.getElementById('gpu-pv').value} ${document.getElementById('marca-pv').value} ${document.getElementById('modelo-pv').value}`;
            break;
        default:
            if (str2.startsWith('modelo-monitor-')) {
                const numero = str2.split('-').pop();
                marca = document.getElementById(`marca-monitor-${numero}`).value;
            }
            break;
    }

    console.log(str1, str2, marca);
    $.ajax({
        url: "./includes/auto_complete.php",
        method: "GET",
        data: { q: str1, n: str2, mm: marca },
        success: function (response) {
            $suggestions.html(response);
        }
    });
}


function passarValor(nr, input, id) {
    let valor = $("#p" + nr).text();
    $(input).val(valor);

    let suggestions = document.getElementById('suggestions-' + input);
    suggestions.classList.remove('visivel');

    let hiddenElement = document.getElementById('hidden-' + input);
    if (hiddenElement) {
        hiddenElement.value = id;
    }
}