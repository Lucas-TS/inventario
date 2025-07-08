<div id="bloco-overlay" class="bloco-overlay" style="width:500px">
    <form name="add_dsk_form" method="post" accept-charset="UTF-8" id="add_dsk_form" onsubmit="insertDsk(event)">
        <div class="header">
            <span>Adicionar Armazenamento</span>
            <div id="botoes">
                <div id="b-line-header-1" class="b-line">
                <div id="fecharOverlay" class="flex-center icon-button margin-bottom rotated-icon"><a title="Fechar" href="#" onclick="ShowObjectWithEffect('overlay', 0, 'fade', 200);"><?php include '../images/add.svg'; ?></a></div>
                </div>
            </div>
        </div>
        <div id="linha-1" class="linha">
            <div id="h-line-add-dsk-1" class="h-line">Informações:</div>
            <div id="b-line-add-dsk-1" class="b-line" style="flex:1">
                <span class="label">Tipo:</span>
                <input type="radio" id="hd" name="tipo-add-dsk" class="radio" value="HD">
                <label for="hd"><span></span>HD</label>
                <input type="radio" id="ssd" name="tipo-add-dsk" class="radio" value="SSD">
                <label for="ssd"><span></span>SSD</label>
            </div>
            <div id="h-spacer" style="flex-basis:100%"></div>
            <div id="b-line-add-ssd-2" class="b-line"><label class="label" for="tam-add-ssd">Tamanho:</label>
                <input id="tam-add-ssd" name="tam-add-ssd" type="text" class="input" placeholder="Digite" style="width:150px" required title="Apenas o numero sem unidade. Ex.: 500, 1,0, 320, 250">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-add-ssd-3" class="b-line" style="flex:1">
                <span class="label">Unidade:</span>
                <input type="radio" id="tb" name="un-add-ssd" class="radio" value="TB">
                <label for="tb"><span></span>TB</label>
                <input type="radio" id="gb" name="un-add-ssd" class="radio" value="GB" checked>
                <label for="gb"><span></span>GB</label>
            </div>
        </div>
        <div id="linha-4" class="linha fim botoes">
            <div id="botoes">
                <div id="b-line-add-dsk-19" class="b-line">
                    <button id="limpar" title="Limpar" class="flex-center large-button" type="reset"><?php include '../images/erase.svg'; ?></button>
                </div>
                <div id="h-spacer"></div>
                <div id="b-line-add-dsk-20" class="b-line">
                    <button id="enviar" title="Enviar" class="flex-center large-button" type="submit"><?php include '../images/ok.svg'; ?></button>
                </div>
            </div>
        </div>
    </form>
</div>
