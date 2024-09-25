<h2>Selecione as colunas</h2>
<div id="checkboxes-colunas"></div>
<button onclick="aplicarFiltros()">Aplicar</button>

<script>
console.log('Script carregado');

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM completamente carregado e analisado');
    carregarColunas();
});

function carregarColunas() {
    console.log('Função carregarColunas chamada');
    fetch('./includes/cria_tabela.php?acao=buscarColunas&tabela=nome_da_tabela_padrao')
    .then(response => response.json())
    .then(data => {
        console.log('Dados recebidos:', data);
        const checkboxesDiv = document.getElementById('checkboxes-colunas');
        checkboxesDiv.innerHTML = '';
        data.forEach(coluna => {
            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.name = 'colunas';
            checkbox.value = coluna;
            checkbox.id = coluna;

            const label = document.createElement('label');
            label.htmlFor = coluna;
            label.appendChild(document.createTextNode(coluna));

            checkboxesDiv.appendChild(checkbox);
            checkboxesDiv.appendChild(label);
            checkboxesDiv.appendChild(document.createElement('br'));
        });
    })
    .catch(error => console.error('Erro ao carregar colunas:', error));
}

function aplicarFiltros() {
    carregarTabela('nome_da_tabela_padrao');
    ShowObjectWithEffect('overlay', 0, 'fade', 200);
}
</script>
