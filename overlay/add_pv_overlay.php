<div id="bloco-overlay" class="bloco-overlay" style="width:750px">
    <form name="add_pv_form" method="post" accept-charset="UTF-8" id="add_pv_form" onsubmit="insertPv(event)">
        <div class="header">
            <span>Adicionar Placa de Vídeo</span>
            <div id="botoes">
                <div id="b-line-header-1" class="b-line">
                <div id="fecharOverlay" class="flex-center icon-button margin-bottom rotated-icon"><a title="Fechar" href="#" onclick="ShowObjectWithEffect('overlay', 0, 'fade', 200);"><?php include '../images/add.svg'; ?></a></div>
                </div>
            </div>
        </div>
        <div id="linha-1" class="linha">
            <div id="h-line-add-pv-1" class="h-line">Chipset:</div>
            <div id="b-line-add-pv-1" class="b-line"><label class="label" for="chipset-add-pv">Marca e modelo:</label>
                <input id="chipset-add-pv" name="chipset-add-pv" type="text" class="input box" placeholder="Digite o nome completo" style="width:350px" required title="Ex.: AMD Radeon RX-550, NVIDIA GeForce RTX 3060">
                <div id="suggestions-chipset-add-pv" class="suggestions-box chipset-add-pv">
                </div>
            </div>
        </div>
        <div id="linha-2" class="linha">
            <div id="h-line-add-pv-2" class="h-line">Informações complementares:</div>
            <div id="b-line-add-pv-2" class="b-line"><label class="label" for="marca-add-pv">Fabricante:</label>
                <input id="marca-add-pv" name="marca-add-pv" type="text" class="input box" placeholder="Digite o nome" style="width:250px" required title="Ex.: Asus, Galax, MSI, XFX, Zotac">
                <div id="suggestions-marca-add-pv" class="suggestions-box marca-add-pv">
                </div>
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-add-pv-3" class="b-line"><label class="label" for="modelo-add-pv">Modelo:</label>
                <input id="modelo-add-pv" name="modelo-add-pv" type="text" class="input box" placeholder="Digite o modelo" style="width:250px" required title="Ex.: MECH 2X OC, Speedster SWFT210">
                <div id="suggestions-modelo-add-pv" class="suggestions-box modelo-add-pv">
                </div>
            </div>
        </div>
        <div id="linha-3" class="linha">
            <div id="h-line-add-pv-3" class="h-line">Memória:</div>
            <div id="b-line-add-pv-4" class="b-line" style="flex-basis:100%"><label class="label" for="mem-add-pv">Tamanho:</label>
                <input id="mem-add-pv" name="mem-add-pv" type="text" class="input unity" placeholder="Quantidade e unidade" style="width:200px" required title="Número e unidade. Ex.: 512MB, 2GB, 4GB ...">
            </div>
            <div id="b-line-add-pv-5" class="b-line"><span class="label">Tipos:</span>
                <input type="radio" id="DDR2-pv" name="mem-pv" class="radio" value="DDR2">
                <label for="DDR2-pv"><span></span>DDR2</label>
                <input type="radio" id="DDR3-pv" name="mem-pv" class="radio" value="DDR3">
                <label for="DDR3-pv"><span></span>DDR3</label>
                <input type="radio" id="GDDR3-pv" name="mem-pv" class="radio" value="GDDR3">
                <label for="GDDR3-pv"><span></span>GDDR3</label>
                <input type="radio" id="GDDR5-pv" name="mem-pv" class="radio" value="GDDR5">
                <label for="GDDR5-pv"><span></span>GDDR5</label>
                <input type="radio" id="GDDR5X-pv" name="mem-pv" class="radio" value="GDDR5X">
                <label for="GDDR5X-pv"><span></span>GDDR5X</label>
                <input type="radio" id="GDDR6-pv" name="mem-pv" class="radio" value="GDDR6">
                <label for="GDDR6-pv"><span></span>GDDR6</label>
                <input type="radio" id="GDDR6X-pv" name="mem-pv" class="radio" value="GDDR6X">
                <label for="GDDR6X-pv"><span></span>GDDR6X</label>
            </div>
        </div>
        <div id="linha-4" class="linha fim botoes">
            <div id="botoes">
                <div id="b-line-add-pv-19" class="b-line">
                    <button id="limpar" title="Limpar" class="flex-center large-button" type="reset"><?php include '../images/erase.svg'; ?></button>
                </div>
                <div id="h-spacer"></div>
                <div id="b-line-add-pv-20" class="b-line">
                    <button id="enviar" title="Enviar" class="flex-center large-button" type="submit"><?php include '../images/ok.svg'; ?></button>
                </div>
            </div>
        </div>
    </form>
</div>