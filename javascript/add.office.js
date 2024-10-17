function selecionaFree() {
    let office = document.getElementById('nome-add-office');
    office.required = true;
    office.disabled = false;
    formularioAddOffice('Free');
}

function selecionaOffice() {
    let office = document.getElementById('nome-add-office');
    office.value = '';
    office.required = false;
    office.disabled = true;
    formularioAddOffice('Microsoft Office');
}

function formularioAddOffice(str1) {

    let linha = document.getElementById("linha-2");
    let conteudo = '';
    if (str1 === 'Microsoft Office') {
        conteudo = `
            <div id="h-line-add-office-2" class="h-line">Informações do pacote:</div>
            <div id="b-line-add-office-2" class="b-line" style="flex-basis:100%">
                <label class="label" for="ver-add-office">Versão:</label>
                <input id="ver-add-office" class="input" type="text" name="ver-add-office" placeholder="Digite a versão" required  style="width:100%">
            </div>
            <div id="b-line-add-office-3" class="b-line" style="flex-basis:100%">
                <label class="label" for="ed-add-office">Edição:</label>
                <input id="ed-add-office" class="input" type="text" name="ed-add-office" placeholder="Digite o nome da edição" required style="width:100%">    
            </div>
        `;
    } else if (str1 === 'Free') {
        conteudo = `
            <div id="h-line-add-office-2" class="h-line">Informações do sistema:</div>
            <div id="b-line-office-2" class="b-line" style="flex-basis:100%">
                <label class="label" for="dev-add-office">Desenvolvedor:</label>
                <input id="dev-add-office" class="input" type="text" name="dev-add-office" placeholder="Digite o nome do desenvolvedor" required style="width:100%">
            </div>
            <div id="b-line-office-3" class="b-line" style="flex-basis:100%">
                <label class="label" for="ver-add-office">Versão:</label>
                <input id="ver-add-office" class="input" type="text" name="ver-add-office" placeholder="Digite a versão" required style="width:100%">
            </div>
            <div id="b-line-office-4" class="b-line" style="flex-basis:100%">
                <label class="label" for="ed-add-office">Edição:</label>
                <input id="ed-add-office" class="input" type="text" name="ed-add-office" placeholder="Digite o nome da edição (opcional)" style="width:100%">
            </div>
        `;
    }
    linha.innerHTML = conteudo;
}

let closeTimeout; // Variável para armazenar a referência do timeout

async function insertOffice(event) {
    event.preventDefault(); // Previne o comportamento padrão do formulário

    // Capturar valor do campo de texto ou definir como nulo

    let devElement = document.getElementById('dev-add-office');
    let dev = devElement ? devElement.value : 'Microsoft';

    let radioOffice = document.getElementById('office');
    let nome = radioOffice.checked ? 'Office' : document.getElementById('nome-add-office').value;

    let edElement = document.getElementById('ed-add-office');
    let ed = edElement ? edElement.value : null;
    if (ed === "") {
        ed = null;
    }

    let versao = document.getElementById('ver-add-office').value;

    let formData = {
        dev: dev,
        nome: nome,
        ed: ed,
        versao: versao,
    };

    try {
        let response = await fetch('./includes/inserir_office.php', {
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
                throw new Error('Erro ao inserir o pacote office.');
            }
        }

        let overlay = document.getElementById('overlay');
        
        let mensagem = `
        <div id="add_office" class="bloco-overlay">
            <div class="header">
                <span>Adicionar Pacote Office</span>
                <div id="botoes">
                    <div id="b-line-header-1" class="b-line">
                    <div id="fecharOverlay" class="flex-center icon-button margin-bottom rotated-icon"><a title="Fechar" href="#" onclick="closeOverlay()">${addSVG}</a></div>
                </div>
            </div>
        </div>
            <div id="linha-1" class="linha fim">
                <div id="h-line-add-os-1" class="h-line centralizado">${dev} ${nome} ${versao} ${ed} inserido com sucesso!</div>
            </div>
            <div id="linha-2" class="linha fim centralizado">
            <div id="b-line-1" class="b-line">
                <div id="okOverlay" class="large-button adjust-position flex-center"><a title="Ok" href="#" onclick="closeOverlay()">${okSVG}</a></div>
            </div>
        </div>
        `;
        overlay.innerHTML = mensagem;

        atualizarTabela();

        // Fechar o overlay após a inserção com um retardo de 5 segundos
        closeTimeout = setTimeout(function () {
            closeOverlay();
        }, 5000); // 5000 milissegundos = 5 segundos
    } catch (error) {
        alert(error.message); // Exibe um alert com a mensagem de erro
    }
}