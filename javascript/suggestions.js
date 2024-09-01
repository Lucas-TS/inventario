$(document).ready(function () {
    $('input').on('click', function (event) {
        event.stopPropagation(); // Impede a propagação do evento para o documento
        const valor = $(this).val();
        const campoId = $(this).attr('id');
        const $suggestions = $('#suggestions-' + campoId);

        // Remove a classe 'visivel' de todos os elementos suggestions
        $('[id^="suggestions"]').removeClass('visivel');

        let valorExiste = false;

        // Verifica se o valor do campo é idêntico a algum dos itens da lista
        $suggestions.find('p').each(function () {
            if ($(this).text() === valor) {
                valorExiste = true;
                return false; // Sai do loop each
            }
        });

        if (!valorExiste && (valor !== "" || campoId === "tipo-mem" || campoId === "tam-hd")) {
            $suggestions.addClass('visivel');
        }
    });

    $(document).click(function (event) {
        const $suggestions = $('[id^="suggestions"]');
        if (!$suggestions.is(event.target) && $suggestions.has(event.target).length === 0) {
            $suggestions.removeClass('visivel');
        }
    });

    // Adicionar evento de clique aos itens da lista de sugestões
    $(document).on('click', '[id^="suggestions"] p', function () {
        const $input = $('#' + $(this).closest('[id^="suggestions"]').attr('id').replace('suggestions-', ''));
        $input.val($(this).text());
        $('[id^="suggestions"]').removeClass('visivel');
    });
});

function showSuggestionsDsk(tipo, num) {
    var suggestionsDiv = document.getElementById("suggestions-tam-" + tipo + "-" + num);
    suggestionsDiv.classList.add("visivel");
}

$(document).ready(function() {

    document.addEventListener('click', handleEvent);
    document.addEventListener('keyup', handleEvent);

    function handleEvent(event) {
        if (event.target.classList.contains('box') && event.target.value) {
            showSuggestions(event.target.value, event.target.id);
        } else if (event.target.classList.contains('openSug')) {
            showSuggestions(event.target.value, event.target.id);
        }
    }
});

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