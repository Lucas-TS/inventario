let contadorMonitor = 0;
let contadorbMonitor = 0; // Início em 24 para evitar conflitos
const maxMonitores = 4;

function adicionarMonitor() {
    if (contadorMonitor >= maxMonitores) {
        document.getElementById('adicionarMonitor').style.display = 'none';
        return;
    }
    contadorMonitor++;
    contadorbMonitor++;
    const container = document.getElementById('monitores-container');
    const novoMonitor = document.createElement('div');
    novoMonitor.id = `monitor-${contadorMonitor}`;
    novoMonitor.classList.add('monitor');
    novoMonitor.innerHTML = `
        <div id="b-line-mon-${contadorbMonitor}" class="b-line">
            <div id="removerMonitor"><a title="Remover monitor" href="#" onclick="removerMonitor(${contadorMonitor})">${maisSVG}</a></div>
            <span style="font-weight:bold;padding-left:5px;color:#AAAAAA;"> Monitor ${contadorMonitor} »   </span>        
            <span class="label" style="padding-left:15px;">Marca:</span>
            <input id="marca-monitor-${contadorMonitor}" class="input box" type="text" name="marca-monitor-${contadorMonitor}" placeholder="Escolha" required style="width:190px" onkeyup="disableModelo(${contadorMonitor})">
            <input id="hidden-marca-monitor-${contadorMonitor}" name="hidden-marca-monitor-${contadorMonitor}" type="hidden" value="">
            </div>
            <div id="suggestions-marca-monitor-${contadorMonitor}" class="suggestions-box marca-monitor">
            </div>
        </div>
        <div id="h-spacer"></div>
        <div id="b-line-mon-${++contadorbMonitor}" class="b-line">
            <label class="label" for="modelo-monitor-${contadorMonitor}">Modelo:</label>
            <input id="modelo-monitor-${contadorMonitor}" class="input box openSug" type="text" name="modelo-monitor-${contadorMonitor}" placeholder="Escolha uma marca" required disabled style="width:290px">
        </div>
        <div id="suggestions-modelo-monitor-${contadorMonitor}" class="suggestions-box modelo-monitor">
        </div>
        <div id="h-spacer"></div>
        <div id="b-line-mon-${++contadorbMonitor}" class="b-line">
            <span class="label">Conexão:</span>
            <input type="radio" id="HDMI-${contadorMonitor}" name="con-monitor-${contadorMonitor}" class="con-monitor" value="HDMI">
            <label for="HDMI-${contadorMonitor}"><span></span>HDMI</label>
            <input type="radio" id="DP-${contadorMonitor}" name="con-monitor-${contadorMonitor}" class="con-monitor" value="DP">
            <label for="DP-${contadorMonitor}"><span></span>DisplayPort</label>
            <input type="radio" id="DVI-${contadorMonitor}" name="con-monitor-${contadorMonitor}" class="con-monitor" value="DVI">
            <label for="DVI-${contadorMonitor}"><span></span>DVI</label>
            <input type="radio" id="VGA-${contadorMonitor}" name="con-monitor-${contadorMonitor}" class="con-monitor" value="VGA">
            <label for="VGA-${contadorMonitor}"><span></span>VGA</label>
        </div>
        <div id="h-spacer"></div>    
        <div id="b-line-mon-${++contadorbMonitor}" class="b-line fichaMon" style="flex:1">
        <table id="fichaMon-${contadorMonitor}" class="fichaMon">
        </table>
        </div>
    `;
    container.appendChild(novoMonitor);
    if (contadorMonitor >= maxMonitores) {
        document.getElementById('adicionarMonitor').style.display = 'none';
    }
}

function removerMonitor(id) {
    const container = document.getElementById('monitores-container');
    const monitor = document.getElementById(`monitor-${id}`);
    container.removeChild(monitor);

    // Renumerar os monitores restantes
    contadorMonitor--;
    let monitores = container.getElementsByClassName('monitor');
    for (let i = 0; i < monitores.length; i++) {
        monitores[i].id = `monitor-${i + 1}`;
        monitores[i].querySelector('.b-line span').innerText = ` Monitor ${i + 1} » `;
        monitores[i].querySelectorAll('input').forEach(input => {
            let name = input.name.split('-');
            name[name.length - 1] = i + 1;
            input.name = name.join('-');
            input.id = input.id.replace(/\d+$/, i + 1);
        });
        monitores[i].querySelectorAll('label').forEach(label => {
            label.htmlFor = label.htmlFor.replace(/\d+$/, i + 1);
        });
        monitores[i].querySelector('a').setAttribute('onclick', `removerMonitor(${i + 1})`);
    }

    // Mostrar o botão de adicionar monitor se houver menos de 4 monitores
    if (contadorMonitor < maxMonitores) {
        document.getElementById('adicionarMonitor').style.display = 'flex';
    }

    // Ajustar valores e adicionar eventos
    document.querySelectorAll('.saude-hd, .saude-ssd').forEach(input => {
        let tipo = 'saude';

        setValue(input, parseInt(input.value), tipo);
        toggleButtons(input, tipo);

        input.addEventListener('input', function() {
            let value = parseInt(this.value);
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
            if (isNaN(value) || value < getMinValue(tipo)) {
                value = getMinValue(tipo);
            } else if (value > getMaxValue(tipo)) {
                value = getMaxValue(tipo);
            }
            setValue(this, value, tipo);
            toggleButtons(this, tipo);
        });
    });
}

function mostrarModelo(n) {
    const campo = document.getElementById(`modelo-monitor-${n}`);
    campo.removeAttribute('disabled');
    campo.setAttribute('placeholder', 'Escolha');
    const campoModelo = `modelo-monitor-${n}`;
    showSuggestions('', campoModelo);
}

function disableModelo(n) {
    var campo = document.getElementById(`modelo-monitor-${n}`);
    campo.disabled = true;
    campo.setAttribute('placeholder', 'Escolha uma marca');
}