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

    // Adicionar eventos de clique e keyup ao documento
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