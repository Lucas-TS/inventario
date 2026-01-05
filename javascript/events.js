function handleOverlayClick(event) {
  // Verifica se o clique foi na div #bloco-overlay ou em um de seus filhos
  if (event.target.closest("#bloco-overlay")) {
    return; // Não faz nada se o clique foi na #bloco-overlay
  }
  ShowObjectWithEffect("overlay", 0, "fade", 200);
}

function handleEvent(event) {
  // Ignora keyup de navegação para não sobrescrever a seleção feita via teclado
  if (event.type === 'keyup' && ['ArrowDown', 'ArrowUp', 'Enter', 'Escape'].includes(event.key)) {
    return;
  }

  const isBoxWithValue =
    event.target.classList.contains("box") && event.target.value;
  const isOpenBox = event.target.classList.contains("openBox");
  const isFixedBox = event.target.classList.contains("fixedBox");

  if (
    isBoxWithValue ||
    (isOpenBox && event.target.value !== verificarValor(event.target.id))
  ) {
    showSuggestions(event.target.value, event.target.id);
  }
  if (isFixedBox) {
    let inputBox = event.target.id;
    let $suggestions = $(`#suggestions-${inputBox}`);
    $suggestions.addClass("visivel");
  }
}

// Add a new function to get the matching suggestion value
function verificarValor(inputId) {
  const $suggestions = $("#suggestions-" + inputId);
  const suggestionValues = $suggestions
    .find("p")
    .map(function () {
      return $(this).text();
    })
    .toArray();
  const inputValue = $("#" + inputId).val();
  return suggestionValues.includes(inputValue);
}

$(document).ready(function () {
  loadAllSVGs()
    .then(() => {
      // Definir nomeTabela
      const queryString = window.location.search;
      const urlParams = new URLSearchParams(queryString);
      nomeTabela = urlParams.get("tabela");

      // Carrega tabela apenas se houver nomeTabela
      if (
        nomeTabela &&
        typeof carregarTabela === "function" &&
        !tabelaCarregada
      ) {
        carregarTabela(nomeTabela).catch((error) => {
          console.error("Erro ao carregar tabela:", error);
        });
        tabelaCarregada = true;
      }

      const cardsContainer = document.querySelector("#cards-container");

      if (cardsContainer) {
        const prefs = buscarPersonalizacaoCards();
        const cardsPadrao = [
          { nome: prefs["bloco-card-1"] || "computadores",bloco: "bloco-card-1", },
          { nome: prefs["bloco-card-2"] || "so", bloco: "bloco-card-2" },
          { nome: prefs["bloco-card-3"] || "situacao", bloco: "bloco-card-3" },
          { nome: prefs["bloco-card-4"] || "antivirus", bloco: "bloco-card-4" },
        ];
        Promise.all(
          cardsPadrao.map((card) => carregarCard(card.nome, card.bloco))
        ).then(() => {
          ShowObjectWithEffect("FlexContainer1", 1, "dropup", 200);
          ShowObjectWithEffect("content", 1, "dropright", 200);
          ShowObjectWithEffect("FlexContainer2", 1, "dropdown", 200);
        });
      } else {
        // Só os efeitos visuais
        ShowObjectWithEffect("FlexContainer1", 1, "dropup", 200);
        ShowObjectWithEffect("content", 1, "dropright", 200);
        ShowObjectWithEffect("FlexContainer2", 1, "dropdown", 200);
      }
    })
    .catch((error) => console.error("Erro ao carregar SVGs:", error));

  $(document).on("click", "input", function (event) {
    event.stopPropagation();
    const $this = $(this);
    const valor = $this.val();
    const campoId = $this.attr("id");
    const $suggestions = $("#suggestions-" + campoId);

    $('[id^="suggestions"]').removeClass("visivel");

    const valorExiste = $suggestions
      .find("p")
      .toArray()
      .some((p) => $(p).text() === valor);
    const pExiste = $suggestions.find("p").length;

    if (
      campoId === "tipo-mem" ||
      ["situacao"].includes(campoId) ||
      campoId === "gp-add-user" ||
      campoId === "gp-edit-user"
    ) {
      if (pExiste > 1) {
        $suggestions.addClass("visivel");
      }
    } else if (
      !valorExiste &&
      (valor !== "" || ["marca-proc"].includes(campoId))
    ) {
      $suggestions.addClass("visivel");
    }
  });

  $(document).click(function (event) {
    // Adiciona um evento de clique ao documento
    if (
      !$('[id^="suggestions"]').is(event.target) &&
      $('[id^="suggestions"]').has(event.target).length === 0
    ) {
      // Se o clique não foi em um elemento de sugestões ou dentro de um elemento de sugestões
      $('[id^="suggestions"]').removeClass("visivel"); // Remove a classe 'visivel' de todos os elementos de sugestões
    }
  });

  document.addEventListener("click", handleEvent);
  document.addEventListener("keyup", handleEvent);
  // Adiciona eventos de clique e tecla pressionada ao documento

  var buscarElemento = document.getElementById("buscar");
  if (buscarElemento) {
    buscarElemento.addEventListener("click", function (event) {
      event.preventDefault(); // Evita o comportamento padrão do formulário
      buscarTabela();
    });
  }
});

document.addEventListener("focusout", function (event) {
  if (event.target.classList.contains("unity")) {
    let valor = event.target.value.trim();

    // Primeiro, garantir o espaço entre o número e a unidade
    valor = valor.replace(/(\d)([a-zA-Z]+)/, "$1 $2").toUpperCase();

    // Depois, adicionar a unidade se ainda não tiver
    if (!/^\d+\s*(GB|MB)$/i.test(valor)) {
      let numero = parseInt(valor, 10);
      if (numero > 63) {
        valor += " MB";
      } else {
        valor += " GB";
      }
    }

    // Atualiza o valor do campo
    event.target.value = valor;
  }
});

// Adiciona um evento para remover todos os espaços quando o input perde o foco
document.addEventListener("focusout", function (event) {
  if (event.target.classList.contains("trim")) {
    event.target.value = event.target.value.replace(/\s+/g, "");
  }
});

// Adiciona um evento para remover espaços quando o input perde o foco
document.addEventListener("focusout", function (event) {
  if (event.target.classList.contains("input")) {
    event.target.value = event.target.value.trim();
  }
});

// Observador para detectar novos inputs adicionados dinamicamente
const overlayObserver = new MutationObserver((mutations) => {
  mutations.forEach((mutation) => {
    if (mutation.attributeName === "style") {
      var overlay = document.getElementById("overlay");
      if (overlay && getComputedStyle(overlay).display !== "none") {
        var avatar1 = document.getElementById("avatar1");
        if (avatar1) {
          selectImage(avatar1);
        }
      }
    }
  });
});

// Assumindo que a div do overlay tem o ID 'overlay'
const overlayElement = document.getElementById("overlay");
overlayObserver.observe(overlayElement, { attributes: true });

const observer = new MutationObserver((mutations) => {
  mutations.forEach((mutation) => {
    mutation.addedNodes.forEach((node) => {
      if (node.nodeType === 1 && node.matches("input.trim")) {
        node.addEventListener("focusout", function () {
          this.value = this.value.replace(/\s+/g, "");
        });
      }
      if (node.nodeType === 1 && node.matches("input.trim")) {
        node.addEventListener("focusout", function () {
          this.value = this.value.trim();
        });
      }
    });

    // Novo código para verificar se avatar1 foi adicionado
    if (mutation.addedNodes.length > 0) {
      var avatar1 = document.getElementById("avatar1");
      if (avatar1) {
        selectImage(avatar1);
        observer.disconnect(); // Desconecta o observer após encontrar o elemento
      }
    }
  });
});

// Configura o observador para monitorar mudanças no DOM
observer.observe(document.body, { childList: true, subtree: true });
galleryObserver.observe(document.body, { childList: true, subtree: true });

window.onload = buscaSessaoPhp;

const topoButton = document.getElementById("topo"); // Seleciona o botão com ID 'topo'
const addButton = document.getElementById("adicionar"); // Seleciona o botão com ID 'adicionar'

window.addEventListener(
  "scroll",
  () => {
    if (window.scrollY > 100) {
      topoButton.classList.remove("botao-oculto");
      if (addButton) {
        addButton.style.bottom = "113px";
      }
    } else {
      topoButton.classList.add("botao-oculto");
      if (addButton) {
        addButton.style.bottom = "50px";
      }
    }
  },
  { passive: true }
);

document.addEventListener("input", function (event) {
  if (event.target && event.target.id === "tam-add-hd") {
    event.target.value = event.target.value.replace(/[^0-9,]/g, "");
  }
});

(function () {
  const sessionTimeout = 900; // 15 minutos
  let timeoutHandle = null;
  let sessionExpired = false;

  function redirectToLogin() {
    if (sessionExpired) return; // evita múltiplos alerts
    sessionExpired = true;
    window.location.href = 'login.php?error=locked';
  }

  function renewSession() {
    fetch('./includes/renova_sessao.php', { 
        method: 'POST', 
        keepalive: true // Adicione esta linha
    })
      .then(response => {
        if (!response.ok) {
            console.error('Sessão não renovada, status:', response.status);
            throw new Error('Sessão não renovada');
        }
      })
      .catch(() => {
        redirectToLogin();
      });
  }

  function resetSessionTimer() {
    if (sessionExpired) return;
    clearTimeout(timeoutHandle);
    timeoutHandle = setTimeout(redirectToLogin, sessionTimeout * 1000);
    renewSession();
  }

  // Eventos que indicam atividade
  ['click', 'mousemove', 'keydown', 'scroll', 'touchstart'].forEach(event => {
    document.addEventListener(event, resetSessionTimer);
  });

  // Inicia o timer ao carregar
  resetSessionTimer();
})();

// Estado das seleções por input
const _suggestionState = new Map();

document.addEventListener('keydown', function (e) {
  // apenas quando estamos em um input e pressionando as teclas relevantes
  const keys = ['ArrowDown', 'ArrowUp', 'Enter', 'Escape'];
  if (!keys.includes(e.key)) return;

  const active = document.activeElement;
  if (!active || !active.id) return;

  const inputId = active.id;
  const suggestionsEl = document.getElementById(`suggestions-${inputId}`);
  if (!suggestionsEl || !suggestionsEl.classList.contains('visivel')) return;

  const items = Array.from(suggestionsEl.querySelectorAll('p'));
  if (!items.length) return;

  e.preventDefault();

  let idx = _suggestionState.get(inputId) ?? -1;

  if (e.key === 'ArrowDown') {
    idx = (idx + 1) % items.length;
    _suggestionState.set(inputId, idx);
  } else if (e.key === 'ArrowUp') {
    idx = (idx - 1 + items.length) % items.length;
    _suggestionState.set(inputId, idx);
  } else if (e.key === 'Escape') {
    suggestionsEl.classList.remove('visivel');
    _suggestionState.delete(inputId);
    return;
  } else if (e.key === 'Enter') {
    // se nenhum item estiver selecionado, escolhe o primeiro
    if (idx < 0) {
      items[0].click();
    } else {
      items[idx].click();
    }
    // limpa estado após escolher
    _suggestionState.delete(inputId);
    return;
  }

  // atualiza classe visual "selected"
  items.forEach((el, i) => {
    if (i === idx) {
      el.classList.add('selected');
      // garante que esteja visível no scroll do container
      el.scrollIntoView({ block: 'nearest' });
    } else {
      el.classList.remove('selected');
    }
  });
});

// Quando as sugestões são escondidas por clique fora, limpa o estado
$(document).click(function (event) {
  if (
    !$('[id^="suggestions"]').is(event.target) &&
    $('[id^="suggestions"]').has(event.target).length === 0
  ) {
    $('[id^="suggestions"]').removeClass('visivel');
    _suggestionState.clear();
  }
});

// controla se o último foco veio do teclado (Tab) ou do mouse
let lastInteractionWasKeyboard = false;
document.addEventListener('keydown', (e) => {
  if (e.key === 'Tab') lastInteractionWasKeyboard = true;
});
document.addEventListener('mousedown', () => {
  lastInteractionWasKeyboard = false;
});

// Abre sugestões também ao focar por TAB (não quando foco por clique)
$(document).on('focusin', 'input', function (event) {
  // só abre quando o foco veio do teclado (Tab)
  if (!lastInteractionWasKeyboard) return;

  event.stopPropagation();
  const $this = $(this);
  const valor = $this.val();
  const campoId = $this.attr('id');
  const $suggestions = $('#suggestions-' + campoId);

  // fecha outras caixas
  $('[id^="suggestions"]').removeClass('visivel');

  const valorExiste = $suggestions
    .find('p')
    .toArray()
    .some((p) => $(p).text() === valor);
  const pExiste = $suggestions.find('p').length;

  if (
    campoId === 'tipo-mem' ||
    ['situacao'].includes(campoId) ||
    campoId === 'gp-add-user' ||
    campoId === 'gp-edit-user'
  ) {
    if (pExiste > 1) {
      $suggestions.addClass('visivel');
    }
  } else if (!valorExiste && (valor !== '' || ['marca-proc'].includes(campoId))) {
    $suggestions.addClass('visivel');
  }
});