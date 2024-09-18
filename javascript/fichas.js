function fichaProcessador(str1) {
    var div = document.getElementById('fichaProc');
    div.innerHTML = '';
    $.ajax({
        url: "./includes/auto_complete.php",
        method: "GET",
        data: { fp: str1 },
        success: function (response) {
            var dados = JSON.parse(response);
            var output = '<tr>';

            output += "<td><b>Geração:</b> " + (dados.geracao ? dados.geracao : "N/A") + "</td>";
            if (dados.ecores) {
                output += "<td><b>P-Cores / E-Cores / Threads:</b> " + dados.pcores + " / " + dados.ecores + " / " + dados.threads + "</td>";
            } else {
                output += "<td><b>Cores / Threads:</b> " + dados.pcores + " / " + dados.threads + "</td>";
            }
            output += "<td><b>Memória:</b> " + dados.memoria + "</td>";

            output += "</tr><tr>";

            output += "<td><b>Socket:</b> " + dados.socket + "</td>";
            if (dados.clock && dados.turbo) {
                output += "<td><b>Clock / Turbo (Ghz):</b> " + dados.clock + " / " + dados.turbo + "</td>";
            } else {
                output += "<td><b>Clock:</b> " + dados.clock + "</td>";
            }
            output += "<td><b>iGPU:</b> " + (dados.igpu ? dados.igpu : "N/A") + "</td>";

            output += "</tr>";

            div.innerHTML = output;
        }
    });
}

function fichaMonitor(str1, str2) {
    var div = document.getElementById('fichaMon-' + str2);
    div.innerHTML = '';
    $.ajax({
        url: "./includes/auto_complete.php",
        method: "GET",
        data: { fm: str1 },
        success: function (response) {
            var dados = JSON.parse(response);
            var output = '<tr>';

            output += "<td><b>Tamanho:</b> " + dados.tamanho + " polegadas</td>";
            output += "<td><b>HDMI:</b> " + (dados.hdmi !== null ? dados.hdmi : 0) + "</td>";
            output += "<td><b>DVI:</b> " + (dados.dvi !== null ? dados.dvi : 0) + "</td>";
            output += '<td style="border-right:none"><b>USB:</b> ' + (dados.usb !== null ? dados.usb : 0) + "</td>";

            output += "</tr><tr>";

            output += "<td><b>Resolução:</b> " + dados.resolucao + "</td>";
            output += "<td><b>DisplayPort:</b> " + (dados.dp !== null ? dados.dp : 0) + "</td>";
            output += "<td><b>VGA (D-SUB):</b> " + (dados.vga !== null ? dados.vga : 0) + "</td>";
            output += '<td style="border-right:none"><b>Áudio P2:</b> ' + (dados.p2 !== null ? dados.p2 : 0) + "</td>";
            
            output += "</tr>";

            div.innerHTML = output;
        }
    });
}

function limparFichaMon(n) {
    document.getElementById(`fichaMon-${n}`).innerHTML = `<tr><td>&nbsp;</td></tr><tr><td><span>Escolha um modelo da lista para carregar a ficha técnica</span></td></tr>`;
}

function limparFichaProc() {
    document.getElementById(`fichaProc`).innerHTML = `<tr><td>&nbsp;</td></tr><tr><td><span>Escolha um modelo da lista para carregar a ficha técnica</span></td></tr>`;
}