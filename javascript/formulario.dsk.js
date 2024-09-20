let contadorDsk = 0;
let contadorbDsk = 0;
let maxArmazenamentos = 4;

function adicionarArmazenamento() {
    const scrollPos = window.scrollY;

    if (contadorDsk >= maxArmazenamentos) {
        document.getElementById('adicionarDsk').style.display = 'none';
        return;
    }
    contadorDsk++;
    contadorbDsk++;
    let container = document.getElementById('armazenamentos-container');
    let novoArmazenamento = document.createElement('div');
    novoArmazenamento.id = `armazenamento-${contadorDsk}`;
    novoArmazenamento.classList.add('armazenamento');
    novoArmazenamento.innerHTML = `
        <div id="b-line-dsk-${contadorbDsk}" class="b-line">
            <div id="removerDsk" class="flex-center icon-button margin-bottom rotated-icon"><a title="Remover armazenamento" href="#" onclick="removerArmazenamento(${contadorDsk})">${maisSVG}</a></div>
            <span style="font-weight:bold;padding-left:5px;color:#AAAAAA;"> Armazenamento ${contadorDsk} »   </span>        
            <span class="label" style="padding-left:15px;">Tipo:</span>
            <input type="radio" id="hd-${contadorDsk}" name="tipo-dsk-${contadorDsk}" class="radio" value="HD" onclick="mostrarFormulario(${contadorDsk}, 'HD')">
            <label for="hd-${contadorDsk}"><span></span>HD</label>
            <input type="radio" id="ssd-${contadorDsk}" name="tipo-dsk-${contadorDsk}" class="radio" value="SSD" onclick="mostrarFormulario(${contadorDsk}, 'SSD')">
            <label for="ssd-${contadorDsk}"><span></span>SSD</label>
        </div>
        <div id="formulario-${contadorDsk}" class="formulario"></div>
        <div id="h-spacer"></div>
    `;
    container.appendChild(novoArmazenamento);
    document.getElementById('adicionarDsk').style.display = 'none';

    requestAnimationFrame(() => {
        window.scrollTo(0, scrollPos);
    });
}

function removerArmazenamento(id) {
    const scrollPos = window.scrollY;

    let container = document.getElementById('armazenamentos-container');
    let armazenamento = document.getElementById(`armazenamento-${id}`);
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
    requestAnimationFrame(() => {
        window.scrollTo(0, scrollPos);
    });
}

function mostrarFormulario(contadorDsk, tipo) {
    let formulario = document.getElementById(`formulario-${contadorDsk}`);
    formulario.innerHTML = gerarFormulario(contadorDsk, tipo);
}

function gerarFormulario(contadorDsk, tipo) {
    const scrollPos = window.scrollY;

    if (contadorDsk < maxArmazenamentos) {
        document.getElementById('adicionarDsk').style.display = 'flex';
    }
    if (tipo === 'HD') {
        return `
            <div id="b-line-dsk-${++contadorbDsk}" class="b-line">
                <label class="label" for="tam-hd-${contadorDsk}">Tamanho:</label>
                <input id="tam-hd-${contadorDsk}" class="input box"  type="text" name="tam-hd-${contadorDsk}" placeholder="Escolha" required style="width:100px">
            </div>
            <div id="suggestions-tam-hd-${contadorDsk}" class="suggestions-box tam-hd">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-dsk-${++contadorbDsk}" class="b-line">
                <span class="label">Interface:</span>
                <input type="radio" id="IDE-${contadorDsk}" name="tipo-hd-${contadorDsk}" class="radio" value="IDE">
                <label for="IDE-${contadorDsk}"><span></span>IDE</label>
                <input type="radio" id="SATA-${contadorDsk}" name="tipo-hd-${contadorDsk}" class="radio" value="SATA">
                <label for="SATA-${contadorDsk}"><span></span>SATA</label>
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-dsk-${++contadorbDsk}" class="b-line">
                <label class="label" for="saude-hd-${contadorDsk}">Saúde:</label>
                <button title="Diminuir" type="button" id="menos" class="menos" onclick="less(this, 'saude')">${menosSVG}</button>
                <input type="number" name="saude-hd-${contadorDsk}" class="saude-hd input" value="100" style="width:59px;text-align:center;"><span style="color:#AAAAAA"> %</span>
                <button title="Aumentar" type="button" id="mais" class="mais" disabled onclick="more(this, 'saude')">${maisSVG}</button>
            </div>
            <input id="hidden-tam-hd-${contadorDsk}" name="hidden-tam-hd-${contadorDsk}" type="hidden" value="">
        `;
    } else if (tipo === 'SSD') {
        return `
            <div id="b-line-dsk-${++contadorbDsk}" class="b-line">
                <label class="label" for="tam-ssd-${contadorDsk}">Tamanho:</label>
                <input id="tam-ssd-${contadorDsk}" class="input box" type="text" name="tam-ssd-${contadorDsk}" placeholder="Escolha" required style="width:100px">
            </div>
            <div id="suggestions-tam-ssd-${contadorDsk}" class="suggestions-box tam-ssd">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-dsk-${++contadorbDsk}" class="b-line">
                <span class="label">Interface:</span>
                <input type="radio" id="SATA-${contadorDsk}" name="tipo-ssd-${contadorDsk}" class="radio" value="SATA">
                <label for="SATA-${contadorDsk}"><span></span>SATA 2,5"</label>
                <input type="radio" id="M2SATA-${contadorDsk}" name="tipo-ssd-${contadorDsk}" class="radio" value="M2SATA">
                <label for="M2SATA-${contadorDsk}"><span></span>M.2 SATA</label>
                <input type="radio" id="NVME-${contadorDsk}" name="tipo-ssd-${contadorDsk}" class="radio" value="NVME">
                <label for="NVME-${contadorDsk}"><span></span>NVME</label>
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-dsk-${++contadorbDsk}" class="b-line">
                <label class="label" for="saude-ssd-${contadorDsk}">Saúde:</label>
                <button title="Diminuir" type="button" id="menos" class="menos" onclick="less(this, 'saude')">${menosSVG}</button>
                <input type="number" name="saude-ssd-${contadorDsk}" class="saude-ssd input" value="100" style="width:59px;text-align:center;"><span style="color:#AAAAAA"> %</span>
                <button title="Aumentar" type="button" id="mais" class="mais" disabled onclick="more(this, 'saude')">${maisSVG}</button>
            </div>
            <input id="hidden-tam-ssd-${contadorDsk}" name="hidden-tam-ssd-${contadorDsk}" type="hidden" value="">
        `;
    }
    requestAnimationFrame(() => {
        window.scrollTo(0, scrollPos);
    });
}
