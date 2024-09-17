function handleOverlayClick(event) {
    // Verifica se o clique foi na div #add_proc ou em um de seus filhos
    if (event.target.closest('#add_proc')) {
        return; // Não faz nada se o clique foi na #add_proc
    }
    ShowObjectWithEffect('overlay', 0, 'fade', 200);
}

function handleEvent(event) {
    const isBoxWithValue = event.target.classList.contains('box') && event.target.value;
    const isOpenBox = event.target.classList.contains('openBox');

    if (isBoxWithValue || (isOpenBox && event.target.value !== verificarValor(event.target.id))) {
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
    // Quando o documento estiver pronto, executa esta função

    $(document).on('click', 'input', function (event) {
        // Adiciona um evento de clique a todos os elementos <input>
        event.stopPropagation(); // Impede que o evento clique se propague para outros elementos
        const $this = $(this); // Armazena o elemento <input> clicado
        const valor = $this.val(); // Obtém o valor do <input>
        const campoId = $this.attr('id'); // Obtém o ID do <input>
        const $suggestions = $('#suggestions-' + campoId); // Seleciona o elemento de sugestões correspondente ao ID do <input>

        $('[id^="suggestions"]').removeClass('visivel'); // Remove a classe 'visivel' de todos os elementos de sugestões

        const valorExiste = $suggestions.find('p').toArray().some(p => $(p).text() === valor);
        // Verifica se o valor do <input> já existe nas sugestões

        if (!valorExiste && (valor !== "" || ["tipo-mem", "marca-proc"].includes(campoId))) {
            // Se o valor não existe e não é vazio ou o ID do campo é 'tipo-mem' ou 'tam-hd' ou 'marca-proc'
            $suggestions.addClass('visivel'); // Adiciona a classe 'visivel' ao elemento de sugestões correspondente
        }
    });

    $(document).click(function (event) {
        // Adiciona um evento de clique ao documento
        if (!$('[id^="suggestions"]').is(event.target) && $('[id^="suggestions"]').has(event.target).length === 0) {
            // Se o clique não foi em um elemento de sugestões ou dentro de um elemento de sugestões
            $('[id^="suggestions"]').removeClass('visivel'); // Remove a classe 'visivel' de todos os elementos de sugestões
        }
    });

    document.addEventListener('click', handleEvent);
    document.addEventListener('keyup', handleEvent);
    // Adiciona eventos de clique e tecla pressionada ao documento
});

const topoButton = document.getElementById('topo'); // Seleciona o botão com ID 'topo'
const addButton = document.getElementById('adicionar'); // Seleciona o botão com ID 'adicionar'


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

function recarregarEventos() {
    $(document).ready(function () {
        // Quando o documento estiver pronto, executa esta função
    
        $('input').on('click', function (event) {
            // Adiciona um evento de clique a todos os elementos <input>
            event.stopPropagation(); // Impede que o evento clique se propague para outros elementos
            const $this = $(this); // Armazena o elemento <input> clicado
            const valor = $this.val(); // Obtém o valor do <input>
            const campoId = $this.attr('id'); // Obtém o ID do <input>
            const $suggestions = $('#suggestions-' + campoId); // Seleciona o elemento de sugestões correspondente ao ID do <input>
    
            $('[id^="suggestions"]').removeClass('visivel'); // Remove a classe 'visivel' de todos os elementos de sugestões
    
            const valorExiste = $suggestions.find('p').toArray().some(p => $(p).text() === valor);
            // Verifica se o valor do <input> já existe nas sugestões
    
            if (!valorExiste && (valor !== "" || ["tipo-mem", "marca-proc"].includes(campoId))) {
                console.log('logica');
                // Se o valor não existe e não é vazio ou o ID do campo é 'tipo-mem' ou 'tam-hd' ou 'marca-proc'
                $suggestions.addClass('visivel'); // Adiciona a classe 'visivel' ao elemento de sugestões correspondente
            }
        });
    
        $(document).click(function (event) {
            // Adiciona um evento de clique ao documento
            if (!$('[id^="suggestions"]').is(event.target) && $('[id^="suggestions"]').has(event.target).length === 0) {
                // Se o clique não foi em um elemento de sugestões ou dentro de um elemento de sugestões
                $('[id^="suggestions"]').removeClass('visivel'); // Remove a classe 'visivel' de todos os elementos de sugestões
            }
        });
    
        document.addEventListener('click', handleEvent);
        document.addEventListener('keyup', handleEvent);
        // Adiciona eventos de clique e tecla pressionada ao documento
    });
}