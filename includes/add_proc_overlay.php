<div id="add_proc" class="bloco-overlay">
    <form name="add_proc_form" method="post" accept-charset="UTF-8" action="includes/add_proc.php" id="add_proc_form">
        <div class="header">
            <span>Adicionar Processador</span>
            <div id="botoes">
                <div id="b-line-header-1" class="b-line">
                <div id="fecharOverlay"><a title="Fechar" href="#" onclick="ShowObjectWithEffect('overlay', 0, 'fade', 200);"><?php include '../images/add.svg'; ?></a></div>
                </div>
            </div>
        </div>
        <div id="linha-1" class="linha">
            <div id="h-line-add-proc-1" class="h-line">Informações básicas:</div>
            <div id="b-line-add-proc-1" class="b-line"><label class="label" for="marca">Marca:</label>
                <input id="marca-proc" name="marca" type="text" class="input fixedBox" placeholder="Digite a marca" style="width:250px">
                <div id="suggestions-marca-proc" class="suggestions-box marca-proc">
                    <p id="p1" onclick="passarValor(1,'marca-proc','');">AMD</p>
                    <p id="p2" onclick="passarValor(2,'marca-proc','');">Intel</p>
                </div>
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-add-proc-2" class="b-line"><label class="label" for="modelo">Modelo:</label>
                <input id="modelo-proc" name="modelo" type="text" class="input" placeholder="Digite o modelo" style="width:250px">
            </div>
        </div>
        <div id="linha-2" class="linha">
            <div id="h-line-add-proc-2" class="h-line">Informações complementares:</div>
            <div id="b-line-add-proc-3" class="b-line"><label class="label" for="modelo">Geração:</label>
                <input id="ger-proc" name="ger" type="text" class="input" placeholder="Digite a geração" style="width:100px">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-add-proc-4" class="b-line"><label class="label" for="modelo">Socket:</label>
                <input id="skt-proc" name="skt" type="text" class="input" placeholder="Digite o socket" style="width:100px" title="Ex.: AM4, AM5, LGA 1155, LGA 1200">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-add-proc-5" class="b-line"><label class="label" for="modelo">Seguimento:</label>
                <input id="skt-proc" name="skt" type="text" class="input" placeholder="Digite o seguimento" style="width:100px" title="teste">
            </div>
        </div>
        <div id="linha-3" class="linha fim botoes">
            <div id="botoes">
                <div id="b-line-add-proc-19" class="b-line">
                    <button id="limpar" type="reset"><?php include '../images/erase.svg'; ?></button>
                </div>
                <div id="h-spacer"></div>
                <div id="b-line-add-proc-20" class="b-line">
                    <button id="enviar" type="submit"><?php include '../images/ok.svg'; ?></button>
                </div>
            </div>

    </form>
</div>