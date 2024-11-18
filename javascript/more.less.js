function changeValue(input, change, tipo) {
    let numero = parseInt(input.value) + change;
    setValue(input, numero, tipo);
    toggleButtons(input, tipo);
}

function startInterval(callback, input, change, tipo) {
    let interval;
    callback(input, change, tipo); // Executa a função uma vez imediatamente
    interval = setInterval(() => callback(input, change, tipo), 100); // Ajustar a taxa de intervalo para 200ms
    return interval;
}

let initialized = false;

function setupButton(button, input, change, tipo) {
    let interval;
    let timeout;

    // Verifica se os eventos já estão configurados
    if (button.dataset.initialized) return;

    const handleMousedown = () => {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            interval = startInterval(changeValue, input, change, tipo);
        }, 200);
    };
    const handleMouseup = () => {
        clearTimeout(timeout);
        clearInterval(interval);
    };
    const handleMouseleave = handleMouseup;
    const handleTouchstart = handleMousedown;
    const handleTouchend = handleMouseup;
    const handleTouchcancel = handleMouseup;

    // Adicionar eventos de clique
    button.addEventListener('mousedown', handleMousedown);
    button.addEventListener('mouseup', handleMouseup);
    button.addEventListener('mouseleave', handleMouseleave);
    button.addEventListener('touchstart', handleTouchstart, { passive: true });
    button.addEventListener('touchend', handleTouchend, { passive: true });
    button.addEventListener('touchcancel', handleTouchcancel, { passive: true });

    // Marca o botão como inicializado
    button.dataset.initialized = true;
}

function initializeListeners() {
    document.querySelectorAll('.qtde-mem, .saude-ssd, .saude-hd, .conexoes').forEach(input => {
        const tipo = input.dataset.tipo || 'mem';
        // Configurar os valores iniciais e botões
        setValue(input, parseInt(input.value), tipo);
        toggleButtons(input, tipo);

        let menosButton = input.previousElementSibling;
        let maisButton = input.nextElementSibling.nextElementSibling;
        if (menosButton && maisButton) {
            setupButton(menosButton, input, -1, tipo);
            setupButton(maisButton, input, 1, tipo);
        }
    });
}

// Inicializar os listeners e o observador do DOM
document.addEventListener('DOMContentLoaded', initializeListeners);

function handleInput() {
    let value = parseInt(this.value);
    const tipo = this.dataset.tipo || 'mem';
    if (isNaN(value) || value < getMinValue(tipo)) {
        value = getMinValue(tipo);
    } else if (value > getMaxValue(tipo)) {
        value = getMaxValue(tipo);
    }
    setValue(this, value, tipo);
    toggleButtons(this, tipo);
}

function handleBlur() {
    let value = parseInt(this.value);
    const tipo = this.dataset.tipo || 'mem';
    if (isNaN(value) || value < getMinValue(tipo)) {
        value = getMinValue(tipo);
    } else if (value > getMaxValue(tipo)) {
        value = getMaxValue(tipo);
    }
    setValue(this, value, tipo);
    toggleButtons(this, tipo);
}

function less(button, tipo) {
    let input = button.nextElementSibling;
    if (input) {
        let numero = parseInt(input.value);
        if (numero > getMinValue(tipo)) {
            numero--;
            setValue(input, numero, tipo);
        }
        toggleButtons(input, tipo);
    }
}

function more(button, tipo) {
    let input = button.previousElementSibling.previousElementSibling;
    if (input) {
        let numero = parseInt(input.value);
        if (numero < getMaxValue(tipo)) {
            numero++;
            setValue(input, numero, tipo);
        }
        toggleButtons(input, tipo);
    }
}

function setValue(input, value, tipo) {
    let minValue = getMinValue(tipo);
    let maxValue = getMaxValue(tipo);
    if (value < minValue) {
        value = minValue;
    } else if (value > maxValue) {
        value = maxValue;
    }
    input.value = value;
}

function toggleButtons(input, tipo) {
    let numero = parseInt(input.value);
    let menosButton = input.previousElementSibling;
    let maisButton = input.nextElementSibling.nextElementSibling;
    if (menosButton && maisButton) {
        menosButton.disabled = (numero === getMinValue(tipo));
        maisButton.disabled = (numero === getMaxValue(tipo));
    }
}

function getMinValue(tipo) {
    return tipo === 'mem' ? 1 : 0;
}

function getMaxValue(tipo) {
    return tipo === 'mem' ? 1024 : 100;
}