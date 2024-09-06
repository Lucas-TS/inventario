function showSuggestionsDsk(tipo, num) {
    var suggestionsDiv = document.getElementById("suggestions-tam-" + tipo + "-" + num);
    suggestionsDiv.classList.add("visivel");
}

function suggestionsMem(valores) {
    // Dividir a string em uma array
    var arrayValores = valores.split(',');
    // Limpar a div
    var div = document.getElementById('suggestions-tipo-mem');
    div.innerHTML = '';
    // Limpar o valor do input
    var input = document.getElementById('tipo-mem');
    input.value = '';
    // Criar tags <p> e adicionar à div
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
    const $suggestions = $('#suggestions-' + str2);
    if (!$suggestions.hasClass("visivel")) {
        $suggestions.addClass('visivel');
    }
    let marca = '';
    let auto = '';
    // Verifica se o campo que chamou a função é do tipo modelo-monitor-#
    if (str2.startsWith('modelo-monitor-')) {
        // Extrai o número do ID do campo atual
        let numero = str2.split('-').pop();
        // Constrói o ID do campo correspondente
        let marcaMonitorId = 'marca-monitor-' + numero;
        // Obtém o valor do campo correspondente
        let marcaMonitorValue = document.getElementById(marcaMonitorId).value;
        // Define a constante marca com o valor obtido
        marca = marcaMonitorValue;
    }
    if (str2 == 'ver-win' || str2 == 'distro-linux') {
        let os = document.querySelector('input[name="so"]:checked').value;
        marca = os;
    }
    if (str2 == 'ver-linux') {
        let os = document.querySelector('input[name="so"]:checked').value;
        let os2 = document.getElementById(`distro-linux`).value;
        marca = os + ' ' + os2;
        auto = "1";
    }
    if (str2 == 'ed-win') {
        let os = document.querySelector('input[name="so"]:checked').value;
        let os2 = document.getElementById(`ver-win`).value;
        marca = os + ' ' + os2;
        auto = "1";
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
    var valor = $("#p" + nr).text();
    $(input).val(valor);
    $('#suggestions-' + $(input).attr('id')).removeClass('visivel');

    var hiddenElement = document.getElementById('hidden-' + $(input).attr('id'));
    if (hiddenElement) {
        hiddenElement.value = id;
    }
}