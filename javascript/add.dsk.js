let contadorDsk = 0;
let contadorbDsk = 7; // Início em 7 para evitar conflitos
const maxArmazenamentos = 4;

function adicionarArmazenamento() {
    if (contadorDsk >= maxArmazenamentos) {
        document.getElementById('adicionarDsk').style.display = 'none';
        return;
    }
    contadorDsk++;
    contadorbDsk++;
    const container = document.getElementById('armazenamentos-container');
    const novoArmazenamento = document.createElement('div');
    novoArmazenamento.id = `armazenamento-${contadorDsk}`;
    novoArmazenamento.classList.add('armazenamento');
    novoArmazenamento.innerHTML = `
        <div id="b-line-${contadorbDsk}" class="b-line">
            <div id="removerDsk"><a title="Remover armazenamento" href="#" onclick="removerArmazenamento(${contadorDsk})">${maisSVG}</a></div>
            <span style="font-weight:bold;padding-left:5px;color:#AAAAAA;"> Armazenamento ${contadorDsk} »   </span>        
            <span class="label" style="padding-left:15px;">Tipo:</span>
            <input type="radio" id="hd-${contadorDsk}" name="tipo-dsk-${contadorDsk}" class="tipo-dsk" value="HD" onclick="mostrarFormulario(${contadorDsk}, 'HD')">
            <label for="hd-${contadorDsk}"><span></span>HD</label>
            <input type="radio" id="ssd-${contadorDsk}" name="tipo-dsk-${contadorDsk}" class="tipo-dsk" value="SSD" onclick="mostrarFormulario(${contadorDsk}, 'SSD')">
            <label for="ssd-${contadorDsk}"><span></span>SSD</label>
        </div>
        <div id="formulario-${contadorDsk}" class="formulario"></div>
        <div id="h-spacer"></div>
    `;
    container.appendChild(novoArmazenamento);
    if (contadorDsk >= maxArmazenamentos) {
        document.getElementById('adicionarDsk').style.display = 'none';
    }
}

function removerArmazenamento(id) {
    const container = document.getElementById('armazenamentos-container');
    const armazenamento = document.getElementById(`armazenamento-${id}`);
    container.removeChild(armazenamento);

    // Renumerar os armazenamentos restantes
    contadorDsk--;
    let armazenamentos = container.getElementsByClassName('armazenamento');
    for (let i = 0; i < armazenamentos.length; i++) {
        armazenamentos[i].id = `armazenamento-${i + 1}`;
        armazenamentos[i].querySelector('.b-line span').innerText = ` Armazenamento ${i + 1} » `;
        armazenamentos[i].querySelectorAll('input').forEach(input => {
            let name = input.name.split('-');
            name[name.length - 1] = i + 1;
            input.name = name.join('-');
            input.id = input.id.replace(/\d+$/, i + 1);
        });
        armazenamentos[i].querySelectorAll('label').forEach(label => {
            label.htmlFor = label.htmlFor.replace(/\d+$/, i + 1);
        });
        armazenamentos[i].querySelector('a').setAttribute('onclick', `removerArmazenamento(${i + 1})`);
    }

    // Mostrar o botão de adicionar armazenamento se houver menos de 4 armazenamentos
    if (contadorDsk < maxArmazenamentos) {
        document.getElementById('adicionarDsk').style.display = 'flex';
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

function mostrarFormulario(contadorDsk, tipo) {
    const formulario = document.getElementById(`formulario-${contadorDsk}`);
    formulario.innerHTML = gerarFormulario(contadorDsk, tipo);
}

function gerarFormulario(contadorDsk, tipo) {
    if (tipo === 'HD') {
        return `
            <div id="b-line-${contadorbDsk++}" class="b-line">
                <label class="label" for="tam-hd-${contadorDsk}">Tamanho:</label>
                <input id="tam-hd-${contadorDsk}" class="input" type="text" name="tam-hd-${contadorDsk}" placeholder="Escolha" required style="width:100px" onfocus="clearPlaceholder(this)" onblur="restorePlaceholder(this)" onkeyup="showSuggestionsDsk('hd', ${contadorDsk})">
            </div>
            <div id="suggestions-tam-hd-${contadorDsk}" class="suggestions-box tam-hd">
                <p>1 TB</p>
                <p>500 GB</p>
                <p>320 GB</p>
                <p>250 GB</p>
                <p>160 GB</p>
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-${contadorbDsk}" class="b-line">
                <span class="label">Interface:</span>
                <input type="radio" id="IDE-${contadorDsk}" name="tipo-hd-${contadorDsk}" class="tipo-hd" value="IDE">
                <label for="IDE-${contadorDsk}"><span></span>IDE</label>
                <input type="radio" id="SATA-${contadorDsk}" name="tipo-hd-${contadorDsk}" class="tipo-hd" value="SATA">
                <label for="SATA-${contadorDsk}"><span></span>SATA</label>
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-${contadorbDsk}" class="b-line">
                <label class="label" for="saude-hd-${contadorDsk}">Saúde:</label>
                <button title="Diminuir" type="button" id="menos" class="menos" onclick="less(this, 'saude')">${menosSVG}</button>
                <input type="text" name="saude-hd-${contadorDsk}" class="saude-hd input" value="100" style="width:59px;text-align:center;"><span style="color:#AAAAAA"> %</span>
                <button title="Aumentar" type="button" id="mais" class="mais" disabled onclick="more(this, 'saude')">${maisSVG}</button>
            </div>
        `;
    } else if (tipo === 'SSD') {
        return `
            <div id="b-line-${contadorbDsk}" class="b-line">
                <label class="label" for="tam-ssd-${contadorDsk}">Tamanho:</label>
                <input id="tam-ssd-${contadorDsk}" class="input" type="text" name="tam-ssd-${contadorDsk}" placeholder="Escolha" required style="width:100px" onfocus="clearPlaceholder(this)" onblur="restorePlaceholder(this)" onkeyup="showSuggestionsDsk('ssd', ${contadorDsk})">
            </div>
            <div id="suggestions-tam-ssd-${contadorDsk}" class="suggestions-box tam-ssd">
                <p>512 GB</p>
                <p>500 GB</p>
                <p>480 GB</p>
                <p>250 GB</p>
                <p>240 GB</p>
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-${contadorbDsk}" class="b-line">
                <span class="label">Interface:</span>
                <input type="radio" id="SATA-${contadorDsk}" name="tipo-ssd-${contadorDsk}" class="tipo-ssd" value="SATA">
                <label for="SATA-${contadorDsk}"><span></span>SATA 2,5"</label>
                <input type="radio" id="M2SATA-${contadorDsk}" name="tipo-ssd-${contadorDsk}" class="tipo-ssd" value="M2SATA">
                <label for="M2SATA-${contadorDsk}"><span></span>M.2 SATA</label>
                <input type="radio" id="NVME-${contadorDsk}" name="tipo-ssd-${contadorDsk}" class="tipo-ssd" value="NVME">
                <label for="NVME-${contadorDsk}"><span></span>NVME</label>
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-${contadorbDsk}" class="b-line">
                <label class="label" for="saude-ssd-${contadorDsk}">Saúde:</label>
                <button title="Diminuir" type="button" id="menos" class="menos" onclick="less(this, 'saude')">${menosSVG}</button>
                <input type="text" name="saude-ssd-${contadorDsk}" class="saude-ssd input" value="100" style="width:59px;text-align:center;"><span style="color:#AAAAAA"> %</span>
                <button title="Aumentar" type="button" id="mais" class="mais" disabled onclick="more(this, 'saude')">${maisSVG}</button>
            </div>
        `;
    }
}
