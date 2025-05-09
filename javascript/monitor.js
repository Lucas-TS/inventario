async function insertMon(event) {
    event.preventDefault(); // Previne o comportamento padrão do formulário

    // Capturar valor do campo de texto ou definir como nulo
    let funcao = 'inserir';
    let marca = document.getElementById('marca-add-mon').value;
    let modelo = document.getElementById('modelo-add-mon').value;
    let tela = document.getElementById('tam-add-mon').value;
    let resh = document.getElementById('resh-add-mon').value;
    let resv = document.getElementById('resv-add-mon').value;
    let res = resh + "x" + resv;
    let hdmi = document.getElementById('qtde-hdmi').value || null;
    let dp = document.getElementById('qtde-dp').value || null;
    let dvi = document.getElementById('qtde-dvi').value || null;
    let vga = document.getElementById('qtde-vga').value || null;
    let usb = document.getElementById('qtde-usb').value || null;
    let p2 = document.getElementById('qtde-p2').value || null;

    if (hdmi === "0") hdmi = null;
    if (dp === "0") dp = null;
    if (dvi === "0") dvi = null;
    if (vga === "0") vga = null;
    if (usb === "0") usb = null;
    if (p2 === "0") p2 = null;

    let formData = {
        funcao: funcao,
        marca: marca,
        modelo: modelo,
        tela: tela,
        res: res,
        hdmi: hdmi,
        dp: dp,
        dvi: dvi,
        vga: vga,
        usb: usb,
        p2: p2,
    };

    try {
        let response = await fetch('./includes/monitor.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=UTF-8'
            },
            body: JSON.stringify(formData)
        });

        if (!response.ok) {
            if (response.status === 409) { // Conflito
                throw new Error('Registro já existe.');
            } else {
                throw new Error('Erro ao inserir o monitor.');
            }
        }

        let overlay = document.getElementById('overlay');
        overlay.innerHTML = `
        <div id="add_mon" class="bloco-overlay">
            <div class="header">
                <span>Adicionar Monitor</span>
                <div id="botoes">
                    <div id="b-line-header-1" class="b-line">
                        <div id="fecharOverlay" class="flex-center icon-button margin-bottom rotated-icon">
                            <a title="Fechar" href="#" onclick="closeOverlay()">${addSVG}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="linha-1" class="linha fim">
                <div id="h-line-add-mon-1" class="h-line centralizado">${marca} ${modelo} inserido com sucesso!</div>
            </div>
            <div id="linha-2" class="linha fim centralizado">
                <div id="b-line-1" class="b-line">
                    <div id="okOverlay" class="large-button adjust-position flex-center">
                        <a title="Ok" href="#" onclick="closeOverlay()">${okSVG}</a>
                    </div>
                </div>
            </div>
        </div>
        `;

        atualizarTabela();

        // Fechar o overlay após a inserção com um retardo de 5 segundos
        closeTimeout = setTimeout(function () {
            closeOverlay();
        }, 5000); // 5000 milissegundos = 5 segundos
    } catch (error) {
        alert(error.message); // Exibe um alert com a mensagem de erro
    }
}

async function editarMonOverlay(id, arquivo) {
    await exibirOverlay(arquivo); // Espera a execução e finalização de exibirOverlay
    let funcao = 'buscar';

    let formData = {
        funcao: funcao,
        id: id,
    };

    try {
        let response = await fetch('./includes/monitor.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=UTF-8'
            },
            body: JSON.stringify(formData)
        });
        if (!response.ok) {
            throw new Error('Erro ao buscar os dados.');
        }
        let data = await response.json(); // Converte a resposta para JSON
        //Preenche os campos do formulário com os dados retornados
        document.getElementById('id-edit-mon').value = data.id;
        document.getElementById('marca-edit-mon').value = data.marca;
        document.getElementById('modelo-edit-mon').value = data.modelo;
        document.getElementById('tam-edit-mon').value = data.tamanho_tela;
        let resolucao= data.resolucao;
        let partes = resolucao.split('x');
        let resh = partes[0]; // número antes do 'x'
        let resv = partes[1]; // número depois do 'x'
        document.getElementById('resh-edit-mon').value = resh;
        document.getElementById('resv-edit-mon').value = resv;
        document.getElementById('qtde-hdmi').value = data.hdmi !== null ? data.hdmi : 0;
        document.getElementById('qtde-dp').value = data.dp !== null ? data.dp : 0;
        document.getElementById('qtde-dvi').value = data.dvi !== null ? data.dvi : 0;
        document.getElementById('qtde-vga').value = data.vga !== null ? data.vga : 0;
        document.getElementById('qtde-usb').value = data.usb !== null ? data.usb : 0;
        document.getElementById('qtde-p2').value = data.p2 !== null ? data.p2 : 0;

        if (data.ativo === 1) {
            document.getElementById('ativo-edit-mon').checked = true;
        }
        // Continue para outros campos conforme necessário
    } catch (error) {
        console.error(error.message);
    }
}

async function editarMon(event) {
    event.preventDefault(); // Previne o comportamento padrão do formulário

    // Capturar valor do campo de texto ou definir como nulo
    let funcao = 'editar';
    let id = document.getElementById('id-edit-mon').value;
    let marca = document.getElementById('marca-edit-mon').value;
    let modelo = document.getElementById('modelo-edit-mon').value;
    let tela = document.getElementById('tam-edit-mon').value;
    let resh = document.getElementById('resh-edit-mon').value;
    let resv = document.getElementById('resv-edit-mon').value;
    let res = (resh + 'x' + resv);
    let hdmi = (document.getElementById('qtde-hdmi').value > 0) ? document.getElementById('qtde-hdmi').value : null;
    let dp = (document.getElementById('qtde-dp').value > 0) ? document.getElementById('qtde-dp').value : null;
    let dvi = (document.getElementById('qtde-dvi').value > 0) ? document.getElementById('qtde-dvi').value : null;
    let vga = (document.getElementById('qtde-vga').value > 0) ? document.getElementById('qtde-vga').value : null;
    let usb = (document.getElementById('qtde-usb').value > 0) ? document.getElementById('qtde-usb').value : null;
    let p2 = (document.getElementById('qtde-p2').value > 0) ? document.getElementById('qtde-p2').value : null;
    let ativo = document.getElementById('ativo-edit-mon').checked ? '1' : '0';

    let formData = {
        funcao: funcao,
        id: id,
        marca: marca,
        modelo: modelo,
        tela: tela,
        res: res,
        hdmi: hdmi,
        dp: dp,
        dvi: dvi,
        vga: vga,
        usb: usb,
        p2: p2,
        ativo: ativo,
    };

    try {
        let response = await fetch('./includes/monitor.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=UTF-8'
            },
            body: JSON.stringify(formData)
        });

        if (!response.ok) {
            if (response.status === 409) {
                throw new Error('Erro ao atualizar os dados do monitor.');
            }
        }

        let responseData = await response.json();
        let overlay = document.getElementById('overlay');
        overlay.innerHTML = `
        <div id="edit_mon" class="bloco-overlay">
            <div class="header">
                <span>Editar Monitor</span>
                <div id="botoes">
                    <div id="b-line-header-1" class="b-line">
                        <div id="fecharOverlay" class="flex-center icon-button margin-bottom rotated-icon">
                            <a title="Fechar" href="#" onclick="closeOverlay()">${addSVG}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="linha-1" class="linha fim">
                <div id="h-line-edit-mon-1" class="b-line centralizado">${responseData.mensagem}</div>
            </div>
            <div id="linha-2" class="linha fim centralizado">
                <div id="b-line-1" class="b-line">
                    <div id="okOverlay" class="large-button adjust-position flex-center">
                        <a title="Ok" href="#" onclick="closeOverlay()">${okSVG}</a>
                    </div>
                </div>
            </div>
        </div>
        `;

        atualizarTabela();
        // Fechar o overlay após a inserção com um retardo de 5 segundos
        closeTimeout = setTimeout(function () {
            closeOverlay();
        }, 5000); // 5000 milissegundos = 5 segundos
    } catch (error) {
        alert(error.message); // Exibe um alert com a mensagem de erro
    }
}