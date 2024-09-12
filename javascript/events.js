function handleEvent(event) {
    const isBoxWithValue = event.target.classList.contains('box') && event.target.value;
    const isOpenBox = event.target.classList.contains('openBox');

    if (isBoxWithValue || (isOpenBox && event.target.value !== verificarValor(event.target.id))) {
        console.log(event.target.value, event.target.id);
        showSuggestions(event.target.value, event.target.id);
    }
}

// Add a new function to get the matching suggestion value
function verificarValor(inputId) {
    const $suggestions = $('#suggestions-' + inputId);
    const suggestionValues = $suggestions.find('p').map(function() {
        return $(this).text();
    }).toArray();
    return suggestionValues.find(value => value === $('#' + inputId).val());
}

$(document).ready(function () {
    $('input').on('click', function (event) {
        event.stopPropagation();
        const $this = $(this);
        const valor = $this.val();
        const campoId = $this.attr('id');
        const $suggestions = $('#suggestions-' + campoId);

        $('[id^="suggestions"]').removeClass('visivel');

        const valorExiste = $suggestions.find('p').toArray().some(p => $(p).text() === valor);

        if (!valorExiste && (valor !== "" || ["tipo-mem", "tam-hd"].includes(campoId))) {
            $suggestions.addClass('visivel');
        }
    });

    $(document).click(function (event) {
        if (!$('[id^="suggestions"]').is(event.target) && $('[id^="suggestions"]').has(event.target).length === 0) {
            $('[id^="suggestions"]').removeClass('visivel');
        }
    });

    $(document).on('click', '[id^="suggestions"] p', function () {
        const $input = $('#' + $(this).closest('[id^="suggestions"]').attr('id').replace('suggestions-', ''));
        $input.val($(this).text());
        $('[id^="suggestions"]').removeClass('visivel');
    });

    document.addEventListener('click', handleEvent);
    document.addEventListener('keyup', handleEvent);
});

const topoButton = document.getElementById('topo');
const addButton = document.getElementById('adicionar');

window.addEventListener('scroll', () => {
    if (window.scrollY > 100) {
        topoButton.classList.remove('oculto');
        if (addButton) {
            addButton.style.bottom = '113px';
        }
    } else {
        topoButton.classList.add('oculto');
        if (addButton) {
            addButton.style.bottom = '50px';
        }
    }
});