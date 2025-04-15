function suggestionsMem(valores, edit = 0) {

    var arrayValores = valores.split(',');

    var div = document.getElementById('suggestions-tipo-mem');
    div.innerHTML = '';
    
    if (edit === 0) {
        var input = document.getElementById('tipo-mem');
        input.value = '';
    }

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

async function showSuggestions(str1, str2) {
    const $suggestions = $(`#suggestions-${str2}`);

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
        case 'mem-pv-nb':
            marca = document.getElementById('gpu-pv-nb').value;
            break;
        case 'gpu-pv-nb':
            marca = 'Notebook';
            break;
        case 'chipset-add-pv':
            marca = document.getElementById('seg-add-pv').value;
            break;
        case 'chipset-edit-pv':
            marca = document.getElementById('seg-edit-pv').value;
            break;
        case 'tipo-mem':
        case 'situacao':
        case 'gp-add-user':
        case 'gp-edit-user':
            return;
        default:
            if (str2.startsWith('modelo-monitor-')) {
                const numero = str2.split('-').pop();
                marca = document.getElementById(`marca-monitor-${numero}`).value;
            }
            break;
    }

    try {
        const response = await fetch(`./includes/auto_complete.php?q=${str1}&n=${str2}&mm=${encodeURIComponent(marca)}`);
        if (!response.ok) throw new Error('Erro na requisição.');
        console.log(response);
        const data = await response.text();
        $suggestions.html(data);
        if (!$suggestions.hasClass("visivel")) {
            $suggestions.addClass('visivel');
        }
    } catch (error) {
        console.error("Erro na requisição fetch:", error.message);
    }
}

function passarValor(nr, input, id) {
    let valor = $("#suggestions-" + input + " #p" + nr).text();
    let campo = document.getElementById(input);
    campo.value = valor;

    let suggestions = document.getElementById('suggestions-' + input);
    suggestions.classList.remove('visivel');

    let hiddenElement = document.getElementById('hidden-' + input);
    if (hiddenElement) {
        hiddenElement.value = id;
    }
}