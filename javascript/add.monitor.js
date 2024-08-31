let contador = 0;
let contadorb = 11; // Início em 11 para evitar conflitos
const maxMonitores = 4;

function adicionarMonitor() {
    if (contador >= maxMonitores) {
        document.getElementById('adicionarMonitor').style.display = 'none';
        return;
    }
    contador++;
    contadorb++;
    const container = document.getElementById('monitores-container');
    const novoMonitor = document.createElement('div');
    novoMonitor.id = `monitor-${contador}`;
    novoMonitor.classList.add('monitor');
    novoMonitor.innerHTML = `
        <div id="b-line-${contadorb}" class="b-line">
            <div id="removerMonitor"><a title="Remover monitor" href="#" onclick="removerMonitor(${contador})">${maisSVG}</a></div>
            <span style="font-weight:bold;padding-left:5px;color:#AAAAAA;"> Monitor ${contador} »   </span>        
            <span class="label" style="padding-left:15px;">Tipo:</span>
            <input type="radio" id="hd-${contador}" name="tipo-monitor-${contador}" class="tipo-monitor" value="HD">
            <label for="hd-${contador}"><span></span>HD</label>
            <input type="radio" id="ssd-${contador}" name="tipo-monitor-${contador}" class="tipo-monitor" value="SSD" >
            <label for="ssd-${contador}"><span></span>SSD</label>
        </div>
        <div id="formulario-${contador}" class="formulario"></div>
        <div id="h-spacer"></div>
        <div id="b-line-${contadorb}" class="b-line">
                <label class="label" for="tam-hd-${contador}">Tamanho:</label>
                <input id="tam-hd-${contador}" class="input" type="text" name="tam-hd-${contador}" placeholder="Escolha" required style="width:100px" onfocus="clearPlaceholder(this)" onblur="restorePlaceholder(this)" onkeyup="showSuggestionsMonitor('hd', ${contador})">
            </div>
            <div id="suggestions-tam-hd-${contador}" class="suggestions-box tam-hd">
                <p>1 TB</p>
                <p>500 GB</p>
                <p>320 GB</p>
                <p>250 GB</p>
                <p>160 GB</p>
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-${contadorb}" class="b-line">
                <span class="label">Interface:</span>
                <input type="radio" id="IDE-${contador}" name="tipo-hd-${contador}" class="tipo-hd" value="IDE">
                <label for="IDE-${contador}"><span></span>IDE</label>
                <input type="radio" id="SATA-${contador}" name="tipo-hd-${contador}" class="tipo-hd" value="SATA">
                <label for="SATA-${contador}"><span></span>SATA</label>
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-${contadorb}" class="b-line">
                <label class="label" for="saude-hd-${contador}">Saúde:</label>
                <button title="Diminuir" type="button" id="menos" class="menos" onclick="less(this, 'saude')">${menosSVG}</button>
                <input type="text" name="saude-hd-${contador}" class="saude-hd input" value="100" style="width:59px;text-align:center;"><span style="color:#AAAAAA"> %</span>
                <button title="Aumentar" type="button" id="mais" class="mais" disabled onclick="more(this, 'saude')">${maisSVG}</button>
            </div>
    `;
    container.appendChild(novoMonitor);
    if (contador >= maxMonitores) {
        document.getElementById('adicionarMonitor').style.display = 'none';
    }
}

function removerMonitor(id) {
    const container = document.getElementById('monitores-container');
    const monitor = document.getElementById(`monitor-${id}`);
    container.removeChild(monitor);

    // Renumerar os monitores restantes
    contador--;
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
    if (contador < maxMonitores) {
        document.getElementById('adicionarMonitor').style.display = 'flex';
    }

    // Ajustar valores e adicionar eventos
    document.querySelectorAll('.saude-hd, .saude-ssd').forEach(input => {
        let tipo = 'saude';

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
}

function mostrarFormulario(contador, tipo) {
    const formulario = document.getElementById(`formulario-${contador}`);
    formulario.innerHTML = gerarFormulario(contador, tipo);
}

function gerarFormulario(contador, tipo) {
    if (tipo === 'HD') {
        return `
            <div id="b-line-${contadorb}" class="b-line">
                <label class="label" for="tam-hd-${contador}">Tamanho:</label>
                <input id="tam-hd-${contador}" class="input" type="text" name="tam-hd-${contador}" placeholder="Escolha" required style="width:100px" onfocus="clearPlaceholder(this)" onblur="restorePlaceholder(this)" onkeyup="showSuggestionsMonitor('hd', ${contador})">
            </div>
            <div id="suggestions-tam-hd-${contador}" class="suggestions-box tam-hd">
                <p>1 TB</p>
                <p>500 GB</p>
                <p>320 GB</p>
                <p>250 GB</p>
                <p>160 GB</p>
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-${contadorb}" class="b-line">
                <span class="label">Interface:</span>
                <input type="radio" id="IDE-${contador}" name="tipo-hd-${contador}" class="tipo-hd" value="IDE">
                <label for="IDE-${contador}"><span></span>IDE</label>
                <input type="radio" id="SATA-${contador}" name="tipo-hd-${contador}" class="tipo-hd" value="SATA">
                <label for="SATA-${contador}"><span></span>SATA</label>
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-${contadorb}" class="b-line">
                <label class="label" for="saude-hd-${contador}">Saúde:</label>
                <button title="Diminuir" type="button" id="menos" class="menos" onclick="less(this, 'saude')">${menosSVG}</button>
                <input type="text" name="saude-hd-${contador}" class="saude-hd input" value="100" style="width:59px;text-align:center;"><span style="color:#AAAAAA"> %</span>
                <button title="Aumentar" type="button" id="mais" class="mais" disabled onclick="more(this, 'saude')">${maisSVG}</button>
            </div>
        `;
    } else if (tipo === 'SSD') {
        return `
            <div id="b-line-${contadorb}" class="b-line">
                <label class="label" for="tam-ssd-${contador}">Tamanho:</label>
                <input id="tam-ssd-${contador}" class="input" type="text" name="tam-ssd-${contador}" placeholder="Escolha" required style="width:100px" onfocus="clearPlaceholder(this)" onblur="restorePlaceholder(this)" onkeyup="showSuggestionsMonitor('ssd', ${contador})">
            </div>
            <div id="suggestions-tam-ssd-${contador}" class="suggestions-box tam-ssd">
                <p>512 GB</p>
                <p>500 GB</p>
                <p>480 GB</p>
                <p>250 GB</p>
                <p>240 GB</p>
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-${contadorb}" class="b-line">
                <span class="label">Interface:</span>
                <input type="radio" id="SATA-${contador}" name="tipo-ssd-${contador}" class="tipo-ssd" value="SATA">
                <label for="SATA-${contador}"><span></span>SATA 2,5"</label>
                <input type="radio" id="M2SATA-${contador}" name="tipo-ssd-${contador}" class="tipo-ssd" value="M2SATA">
                <label for="M2SATA-${contador}"><span></span>M.2 SATA</label>
                <input type="radio" id="NVME-${contador}" name="tipo-ssd-${contador}" class="tipo-ssd" value="NVME">
                <label for="NVME-${contador}"><span></span>NVME</label>
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-${contadorb}" class="b-line">
                <label class="label" for="saude-ssd-${contador}">Saúde:</label>
                <button title="Diminuir" type="button" id="menos" class="menos" onclick="less(this, 'saude')">${menosSVG}</button>
                <input type="text" name="saude-ssd-${contador}" class="saude-ssd input" value="100" style="width:59px;text-align:center;"><span style="color:#AAAAAA"> %</span>
                <button title="Aumentar" type="button" id="mais" class="mais" disabled onclick="more(this, 'saude')">${maisSVG}</button>
            </div>
        `;
    }
}
