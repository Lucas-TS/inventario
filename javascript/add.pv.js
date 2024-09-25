function insertPv(event) {
    event.preventDefault(); // Previne o comportamento padrão do formulário

    // Capturar valor do campo de texto ou definir como nulo
    let chipset = document.getElementById('chipset-add-pv').value;
    let marca = document.getElementById('marca-add-pv').value;
    let modelo = document.getElementById('modelo-add-pv').value;
    let qtde = document.getElementById('mem-add-pv').value;
    let tipo = document.getElementById('mem-pv').value;
    let memoria = qtde + " " + tipo;

    var formData = {
        chipset: chipset,
        marca: marca,
        modelo: modelo,
        memoria: memoria,
    };

    console.log(formData);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "./includes/inserir_pv.php", true);
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) { // Verifica se a requisição foi concluída
            var overlay = document.getElementById('overlay'); // Seleciona a div com o ID 'overlay'
            if (xhr.status === 200) { // Verifica se a resposta do servidor foi bem-sucedida (status 200)
                overlay.innerHTML = `
                <div id="add_pv" class="bloco-overlay">
                    <div class="header">
                        <span>Adicionar Placa de Vídeo</span>
                        <div id="botoes">
                            <div id="b-line-header-1" class="b-line">
                            <div id="fecharOverlay" class="flex-center icon-button margin-bottom rotated-icon adjust-position"><a title="Fechar" href="#" onclick="ShowObjectWithEffect('overlay', 0, 'fade', 200);">${maisSVG}</a></div>
                        </div>
                    </div>
                </div>
                <div id="linha-1" class="linha fim">
                    <div id="h-line-add-pv-1" class="h-line centralizado">${marca} ${chipset} ${modelo} ${memoria} inserida com sucesso!</div>
                </div>
                <div id="linha-2" class="linha fim centralizado">
                    <div id="b-line-1" class="b-line">
                        <div id="okOverlay" class="large-button"><a title="Ok" href="#" onclick="ShowObjectWithEffect('overlay', 0, 'fade', 200);">${okSVG}</a></div>
                    </div>
                </div>
                `; // Insere a mensagem de sucesso na div 'overlay'
                // Fechar o overlay após a inserção com um retardo de 5 segundos
                setTimeout(function() {
                    ShowObjectWithEffect('overlay', 0, 'fade', 200); // Função para fechar o overlay com efeito de fade
                }, 5000); // 5000 milissegundos = 5 segundos
            } else {
                alert("Erro: " + xhr.statusText); // Exibe um alert com a mensagem de erro
            }
        }
    };
    xhr.send(JSON.stringify(formData));
}