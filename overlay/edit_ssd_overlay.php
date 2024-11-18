<div id="bloco-overlay" class="bloco-overlay" style="width:500px">
    <form name="edit_ssd_form" method="post" accept-charset="UTF-8" id="edit_ssd_form" onsubmit="editarSsd(event)">
        <div class="header">
            <span>Editar SSD</span>
            <div id="botoes">
                <div id="b-line-header-1" class="b-line">
                <div id="fecharOverlay" class="flex-center icon-button margin-bottom rotated-icon"><a title="Fechar" href="#" onclick="ShowObjectWithEffect('overlay', 0, 'fade', 200);"><?php include '../images/add.svg'; ?></a></div>
                </div>
            </div>
        </div>
        <div id="linha-1" class="linha">
            <div id="h-line-edit-ssd-1" class="h-line">Cadastro:</div>
            <div id="b-line-edit-ssd-1" class="b-line"><label class="label" for="id-edit-ssd">ID:</label>
                <input id="id-edit-ssd" name="id-edit-ssd" type="text" class="input" placeholder="" readonly title="ID">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-edit-ssd-2" class="b-line">
                <input type="checkbox" id="ativo-edit-ssd" class="checkbox" value="1">
                <label for="ativo-edit-ssd"><span></span>Ativo</label>
            </div>
        </div>
        <div id="linha-2" class="linha">
            <div id="h-line-edit-ssd-2" class="h-line">Informações:</div>
            <div id="b-line-edit-ssd-3" class="b-line"><label class="label" for="tam-edit-ssd">Tamanho:</label>
                <input id="tam-edit-ssd" name="tam-edit-ssd" type="text" class="input" placeholder="Digite" style="width:150px" required title="Apenas o numero sem unidade. Ex.: 500, 1,0, 320, 250">
            </div>
            <div id="h-spacer"></div>
            <div id="b-line-edit-ssd-4" class="b-line" style="flex:1">
                <span class="label">Unidade:</span>
                <input type="radio" id="tb" name="un-edit-ssd" class="radio" value="TB">
                <label for="tb"><span></span>TB</label>
                <input type="radio" id="gb" name="un-edit-ssd" class="radio" value="GB">
                <label for="gb"><span></span>GB</label>
            </div>
        </div>
        <div id="linha-4" class="linha fim botoes">
            <div id="botoes">
                <div id="b-line-edit-ssd-19" class="b-line">
                    <button id="limpar" title="Limpar" class="flex-center large-button" type="reset"><?php include '../images/erase.svg'; ?></button>
                </div>
                <div id="h-spacer"></div>
                <div id="b-line-edit-ssd-20" class="b-line">
                    <button id="enviar" title="Enviar" class="flex-center large-button" type="submit"><?php include '../images/ok.svg'; ?></button>
                </div>
            </div>
        </div>
    </form>
</div>