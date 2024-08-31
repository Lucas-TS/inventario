function less(button, tipo) {
    let input = button.nextElementSibling;
    let numero = parseInt(input.value);
    if (numero > getMinValue(tipo)) {
        numero--;
        setValue(input, numero, tipo);
    }
    toggleButtons(input, tipo);
}

function more(button, tipo) {
    let input = button.previousElementSibling.previousElementSibling;
    let numero = parseInt(input.value);
    if (numero < getMaxValue(tipo)) {
        numero++;
        setValue(input, numero, tipo);
    }
    toggleButtons(input, tipo);
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
    menosButton.disabled = (numero === getMinValue(tipo));
    maisButton.disabled = (numero === getMaxValue(tipo));
}

function getMinValue(tipo) {
    return tipo === 'mem' ? 1 : 0;
}

function getMaxValue(tipo) {
    return tipo === 'mem' ? 1024 : 100;
}

// Ajuste do valor digitado aos limites do campo
document.querySelectorAll('.qtde-mem').forEach(input => {
    const tipo = 'mem';

    setValue(input, parseInt(input.value), tipo);
    toggleButtons(input, tipo);

    input.addEventListener('input', function() {
        let value = parseInt(this.value);
        console.log(`Input event: ${value}, Tipo: ${tipo}`);
        if (isNaN(value) || value < getMinValue(tipo)) {
            value = getMinValue(tipo);
        } else if (value > getMaxValue(tipo)) {
            value = getMaxValue(tipo);
        }
        setValue(this, value, tipo);
        toggleButtons(this, tipo);
    });

    input.addEventListener('blur', function() {
        let value = parseInt(this.value);
        console.log(`Blur event: ${value}, Tipo: ${tipo}`);
        if (isNaN(value) || value < getMinValue(tipo)) {
            value = getMinValue(tipo);
        } else if (value > getMaxValue(tipo)) {
            value = getMaxValue(tipo);
        }
        setValue(this, value, tipo);
        toggleButtons(this, tipo);
    });
});