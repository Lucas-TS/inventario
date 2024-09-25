function carregarTabela(nomeTabela, pagina = 1, limite = 2) {
    $.ajax({
        url: './includes/cria_tabela.php',
        type: 'GET',
        data: { tabela: nomeTabela, pagina: pagina, limite: limite },
        success: function(response) {
            $('#tabela').html(response);
        },
        error: function() {
            alert('Erro ao carregar a tabela.');
        }
    });
}

$(document).ready(function() {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const valor = urlParams.get('tabela');
    const limite = urlParams.get('limite') || 2;

    carregarTabela(valor, 1, limite);
});

function filtrarTabela() {
    var table, tr, td, i, j, txtValue, input, filter;
    table = document.querySelector("table");
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, except the first two (header and filter inputs)
    for (i = 2; i < tr.length; i++) {
        tr[i].style.display = "";
        for (j = 0; j < tr[i].getElementsByTagName("td").length; j++) {
            input = table.getElementsByTagName("input")[j];
            filter = input.value.toUpperCase();
            td = tr[i].getElementsByTagName("td")[j];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                    break;
                }
            }
        }
    }
}