let contadorMonitor = 0;
let contadorbMonitor = 0;
let maxMonitores = 4;

function adicionarMonitor() {
    const scrollPos = window.scrollY;
    contadorMonitor++;
    contadorbMonitor++;
        if (contadorMonitor >= maxMonitores) {
        document.getElementById('adicionarMonitor').style.display = 'none';
    }
    let container = document.getElementById('monitores-container');
    let novoMonitor = document.createElement('div');
    novoMonitor.id = `monitor-${contadorMonitor}`;
    novoMonitor.classList.add('monitor');
    novoMonitor.innerHTML = `
        <div id="b-line-mon-${contadorbMonitor}" class="b-line">
            <div id="removerMonitor" class="flex-center icon-button margin-bottom rotated-icon"><a title="Remover monitor" href="#" onclick="removerMonitor(${contadorMonitor})">${addSVG}</a></div>
            <span style="font-weight:bold;padding-left:5px;color:#AAAAAA;"> Monitor ${contadorMonitor} »   </span>        
            <span class="label" style="padding-left:15px;">Marca:</span>
            <input id="marca-monitor-${contadorMonitor}" class="input box" type="text" name="marca-monitor-${contadorMonitor}" placeholder="Escolha a marca" required style="width:140px" onkeyup="disableModelo(${contadorMonitor})">
            </div>
            <div id="suggestions-marca-monitor-${contadorMonitor}" class="suggestions-box marca-monitor">
            </div>
        </div>
        <div id="h-spacer"></div>
        <div id="b-line-mon-${++contadorbMonitor}" class="b-line">
            <label class="label" for="modelo-monitor-${contadorMonitor}">Modelo:</label>
            <input id="modelo-monitor-${contadorMonitor}" class="input box openBox" type="text" name="modelo-monitor-${contadorMonitor}" placeholder="Escolha a marca" required disabled style="width:190px" onkeyup="verificarTecla(event, monitor, ${contadorMonitor})">
        </div>
        <div id="suggestions-modelo-monitor-${contadorMonitor}" class="suggestions-box modelo-monitor">
        </div>
        <input id="hidden-modelo-monitor-${contadorMonitor}" name="hidden-modelo-monitor-${contadorMonitor}" type="hidden" value="">
        <input id="hidden-id-assoc-monitor-${contadorMonitor}" name="hidden-id-assoc-monitor-${contadorMonitor}" type="hidden" value="">
        <div id="h-spacer"></div>
        <div id="b-line-mon-${++contadorbMonitor}" class="b-line">
            <span class="label">Conexão:</span>
            <input type="radio" id="HDMI-${contadorMonitor}" name="con-monitor-${contadorMonitor}" class="radio" value="HDMI">
            <label for="HDMI-${contadorMonitor}"><span></span>HDMI</label>
            <input type="radio" id="DP-${contadorMonitor}" name="con-monitor-${contadorMonitor}" class="radio" value="DP">
            <label for="DP-${contadorMonitor}"><span></span>DP</label>
            <input type="radio" id="DVI-${contadorMonitor}" name="con-monitor-${contadorMonitor}" class="radio" value="DVI">
            <label for="DVI-${contadorMonitor}"><span></span>DVI</label>
            <input type="radio" id="VGA-${contadorMonitor}" name="con-monitor-${contadorMonitor}" class="radio" value="VGA">
            <label for="VGA-${contadorMonitor}"><span></span>VGA</label>
        </div>
        <div id="h-spacer"></div>    
        <div id="b-line-mon-${++contadorbMonitor}" class="b-line fichaMon" style="flex:1">
        <table id="fichaMon-${contadorMonitor}" class="fichaMon ultimo">
            <tr><td>&nbsp;</td></tr><tr><td><span>Escolha um modelo para carregar a ficha técnica</span></td></tr>
        </table>
        </div>
    `;
    container.appendChild(novoMonitor);

    requestAnimationFrame(() => {
        window.scrollTo(0, scrollPos);
    });
}

function removerMonitor(id) {
    let container = document.getElementById('monitores-container');
    let monitor = document.getElementById(`monitor-${id}`);
    container.removeChild(monitor);

    const scrollPos = window.scrollY;

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
        monitores[i].querySelectorAll('.suggestions-box').forEach(box => {
            if (box.id.startsWith('suggestions-modelo-monitor-')) {
                box.id = `suggestions-modelo-monitor-${i + 1}`;
            } else if (box.id.startsWith('suggestions-marca-monitor-')) {
                box.id = `suggestions-marca-monitor-${i + 1}`;
            }
        });
    }

    requestAnimationFrame(() => {
        window.scrollTo(0, scrollPos);
    });

    if (contadorMonitor < maxMonitores) {
        document.getElementById('adicionarMonitor').style.display = 'flex';
    }
}

function mostrarModelo(n) {
    let campo = document.getElementById(`modelo-monitor-${n}`);
    campo.removeAttribute('disabled');
    campo.setAttribute('placeholder', 'Escolha');
    let campoModelo = `modelo-monitor-${n}`;
    showSuggestions('', campoModelo);
}

function disableModelo(n) {
    let campo = document.getElementById(`modelo-monitor-${n}`);
    let hiddenMon = document.getElementById(`hidden-modelo-monitor-${n}`);
    campo.disabled = true;
    campo.value = '';
    campo.setAttribute('placeholder', 'Escolha a marca');
    hiddenMon.value = '';

}

function limparFicha(n) {
    document.getElementById(`fichaMon-${n}`).innerHTML = ``;
}