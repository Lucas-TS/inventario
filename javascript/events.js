function handleOverlayClick(event) {
    // Verifica se o clique foi na div #bloco-overlay ou em um de seus filhos
    if (event.target.closest('#bloco-overlay')) {
        return; // Não faz nada se o clique foi na #bloco-overlay
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

        if (!valorExiste && (valor !== "" || ["tipo-mem"].includes(campoId))) {
            // Se o valor não existe e não é vazio ou o ID do campo é 'tipo-mem' ou 'marca-proc'
            $suggestions.addClass('visivel'); // Adiciona a classe 'visivel' ao elemento de sugestões correspondente
        }

        if (["marca-proc"].includes(campoId) || ["seg-proc"].includes(campoId)) {
            // Se o valor não existe e não é vazio ou o ID do campo é 'tipo-mem' ou 'marca-proc'
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

    document.getElementById('buscar').addEventListener('click', function(event) {
        event.preventDefault(); // Evita o comportamento padrão do formulário
        buscarTabela();
    });
});

// Função para remover todos os espaços dos inputs com a classe 'trim'
function removeAllSpaces() {
    const inputs = document.querySelectorAll('input.trim');
    inputs.forEach(input => {
        input.value = input.value.replace(/\s+/g, '');
    });
}

// Função para remover espaços dos inputs
function trimInputs() {
    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => {
        input.value = input.value.trim();
    });
}

// Adiciona um evento para remover todos os espaços quando o input perde o foco
document.addEventListener('focusout', function(event) {
    if (event.target.classList.contains('trim')) {
        event.target.value = event.target.value.replace(/\s+/g, '');
    }
});

// Adiciona um evento para remover espaços quando o input perde o foco
document.addEventListener('focusout', function(event) {
    if (event.target.classList.contains('input')) {
        event.target.value = event.target.value.trim();
    }
});

// Observador para detectar novos inputs adicionados dinamicamente
const observer = new MutationObserver(mutations => {
    mutations.forEach(mutation => {
        mutation.addedNodes.forEach(node => {
            if (node.nodeType === 1 && node.matches('input.trim')) {
                node.addEventListener('focusout', function() {
                    this.value = this.value.replace(/\s+/g, '');
                });
            }
            if (node.nodeType === 1 && node.matches('input.trim')) {
                node.addEventListener('focusout', function() {
                    this.value = this.value.trim();
                });
            }
        });
    });
});

// Configura o observador para monitorar mudanças no DOM
observer.observe(document.body, { childList: true, subtree: true });

const topoButton = document.getElementById('topo'); // Seleciona o botão com ID 'topo'
const addButton = document.getElementById('adicionar'); // Seleciona o botão com ID 'adicionar'

window.addEventListener('scroll', () => {
    if (window.scrollY > 100) {
        topoButton.classList.remove('botao-oculto');
        if (addButton) {
            addButton.style.bottom = '113px';
        }
    } else {
        topoButton.classList.add('botao-oculto');
        if (addButton) {
            addButton.style.bottom = '50px';
        }
    }
});